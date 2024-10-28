<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopupWalletRequest;
use App\Http\Requests\StoreWithdrawWalletRequest;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
   public function wallet(){
        $user = Auth::user();
        $wallet_transactions = WalletTransaction::where('user_id', $user->id)
            ->orderByDesc('id')
            ->paginate(10);
        
        return view('dashboard.wallet', compact('wallet_transactions'));
    }
    public function withdraw_wallet(){
        return view('dashboard.withdraw_wallet');
    }
  
    public function withdraw_wallet_store(StoreWithdrawWalletRequest $request)
    {
        $user = Auth::user();
        
        if($user->wallet->balance < 100000){
            return redirect()->back()->withErrors([
                'amount' => 'Balance anda saat ini tidak cukup'
            ]);
        }

        DB::transaction(function () use ($request, $user) {
            $validated = $request->validated();

            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['type'] = 'Withdraw';
            $validated['amount'] = $user->wallet->balance;
            $validated['is_paid'] = false;
            $validated['user_id'] = $user->id;

            $newTopupWallet = WalletTransaction::create($validated);

            $user->wallet->update([
                'balance' => 0
            ]);
        });

        return redirect()->route('dashboard.wallet');
    }

    public function topup_wallet(){
        return view('dashboard.topup_wallet');
    }
     public function topup_wallet_store(StoreTopupWalletRequest $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            // Validasi request sesuai dengan StoreTopupWalletRequest
            $validated = $request->validated();

            // Cek apakah ada file bukti pembayaran (proof)
            if ($request->hasFile('proof')) {
                // Simpan file ke dalam storage
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath; // Masukkan ke data yang divalidasi
            }

            // Set tipe transaksi topup dan user yang melakukan
            $validated['type'] = 'Topup';
            $validated['is_paid'] = false; // Karena belum dikonfirmasi
            $validated['user_id'] = $user->id;

            // Buat transaksi baru di WalletTransaction
            $newTopupWallet = WalletTransaction::create($validated);
        });

        // Redirect kembali ke halaman wallet setelah berhasil
        return redirect()->route('dashboard.wallet');
    }
}