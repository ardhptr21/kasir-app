<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $filters = $request->only(['date', 'search']);
        if (!isset($filters['search']) || !isset($filters['date'])) {
            $filters['date'] = today();
            $filters['search'] = 'day';
        }

        if ($filters['search'] != 'day' && $filters['search'] != 'month' && isset($filters['search'])) {
            return to_route('transactions.create');
        }

        $transactions = Transaction::filter($filters)->get();
        return view('transactions.index', compact('transactions'));
    }


    public function create()
    {
        $carts = Cart::with(['service', 'user'])->get();
        return view('transactions.create', compact('carts'));
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
        ]);

        $merger = ['transaction_code' => random_alnum(8), 'period' => date('m-Y'), 'user_id' => auth()->user()->id];
        $carts = array_map(function ($v) use ($merger) {
            unset($v['id']);
            $v['created_at'] = now();
            $v['updated_at'] = now();
            return array_merge($v, $merger);
        }, Cart::all()->toArray());

        $transactions = Transaction::insert($carts);

        if ($transactions) {
            $carts = Cart::truncate();
            return to_route('transactions.show')->with([
                'message' => 'Transaksi berhasil dilakukan',
                'cash' => $validated['cash'],
                'total_all' => $validated['total_all'],
                'refund' => $validated['cash'] - $validated['total_all'],
                'transaction_code' => $merger['transaction_code'],
            ]);
        }

        return back()->with('cart_error', 'Transaksi gagal dilakukan');
    }
}
