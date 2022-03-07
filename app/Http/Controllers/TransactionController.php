<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
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
            unset($v['created_at'], $v['updated_at'], $v['id']);
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
