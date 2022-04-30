<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Cart;
use App\Models\FreeService;
use App\Models\FreeServiceCart;
use App\Models\Member;
use App\Models\Transaction;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        if ($request->search != 'day' && $request->search != 'month' && isset($request->search)) {
            return to_route('transactions.index');
        }

        $filters = $request->only(['date', 'search']);
        if (!isset($filters['search']) || !isset($filters['date'])) {
            $filters['date'] = today();
            $filters['search'] = 'day';
        }


        $transactions = Transaction::with(['service', 'user'])->filter($filters)->get();
        return view('transactions.index', compact('transactions'));
    }


    public function create(Request $request)
    {
        $carts = Cart::with(['user', 'service.free_service'])->get();
        $member = null;
        if ($request->member) {
            $member = Member::where('member_code', $request->member)->first();

            if (!$member) {
                return redirect($request->fullUrlWithoutQuery('member'));
            }
        }
        return view('transactions.create', compact('carts', 'member'));
    }

    public function show()
    {
        $transaction_code = session('transaction_code');
        if (!$transaction_code) {
            abort(404);
        }
        $transactions = Transaction::with(['service', 'user'])->where('transaction_code', $transaction_code)->get();

        return view('transactions.show', compact('transactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'total_all' => 'required|integer|min:0',
            'cash' => "required|integer|min:$request->total_all",
            'member' => 'string|nullable',
            'type' => 'required|string|in:small,medium,large',
            'merk' => 'required|string',
            'plate' => 'required|string',
        ]);

        $member = null;
        if (isset($validated['member'])) {
            $member = Member::where('member_code', $validated['member'])->first();
            if (!$member) {
                return back()->with('cart_error', "Member dengan kode '{$validated['member']}' tidak ditemukan");
            }
        }

        $merger = ['transaction_code' => random_alnum(8), 'period' => date('m-Y'), 'user_id' => auth()->user()->id];
        $carts = array_map(function ($v) use ($merger, $validated) {
            unset($v['id']);
            $v['created_at'] = now();
            $v['updated_at'] = now();
            $v['merk'] = $validated['merk'];
            $v['plate'] = $validated['plate'];
            $v['type'] = $validated['type'];

            if ($v['service']['free_service']) {
                if ($v['service']['free_service']['free_service_cart']) {
                    $v['total_price'] = 0;
                }
            }

            unset($v['service']);

            return array_merge($v, $merger);
        }, Cart::with(['service.free_service.free_service_cart'])->get()->toArray());

        $transactions = Transaction::insert($carts);

        if ($transactions) {
            $total_point_substraction = array_reduce(FreeServiceCart::with(['free_service'])->get()->toArray(), fn ($prev, $curr) => $prev + $curr['free_service']['max_point'], 0);
            if ($member) {
                if ($member->point >= $total_point_substraction) {
                    $member->point -= $total_point_substraction;
                }
                $member->point += 1;
                $member->save();
            }

            Cart::truncate();
            FreeServiceCart::truncate();

            return to_route('transactions.show')->with([
                'message' => 'Transaksi berhasil dilakukan',
                'cash' => $validated['cash'],
                'total_all' => $validated['total_all'],
                'refund' => $validated['cash'] - $validated['total_all'],
                'transaction_code' => $merger['transaction_code'],
                'type' => $validated['type'],
                'merk' => $validated['merk'],
                'plate' => $validated['plate'],
            ]);
        }

        return back()->with('cart_error', 'Transaksi gagal dilakukan');
    }

    public function export(Request $request)
    {
        $filters = $request->only(['date', 'search']);
        $transactions = Transaction::with(['service', 'user'])->filter($filters)->get();
        $date = null;
        if ($filters['search'] == 'day') {
            $date = DateTime::createFromFormat('Y-m-d', $filters['date'])->getTimestamp();
            $date = 'Hari ' . parse_day(date('N', $date)) . ' ' . date('j', $date) . ' ' . parse_month(date('n', $date)) . ' ' . date('Y', $date);
        } else if ($filters['search'] == 'month') {
            $date = DateTime::createFromFormat('m-Y', $filters['date']);
            $date = 'Bulan ' . parse_month($date->format('n')) . ' ' . $date->format('Y');
        }


        $filename = 'Laporan Transaksi Pada ' . $date;

        return Excel::download(new TransactionsExport($transactions), "$filename.xlsx");
    }

    public function print(Request $request)
    {
        $cash = $request->cash ?? 0;
        $refund = $request->refund ?? 0;
        $type = $request->type ?? 'small';
        $merk = $request->merk ?? '-';
        $plate = $request->plate ?? '-';
        $transactions = Transaction::with(['service'])->where('transaction_code', $request->transaction_code)->get();
        return view('transactions.print', compact('transactions', 'cash', 'refund', 'merk', 'plate', 'type'));
    }
}
