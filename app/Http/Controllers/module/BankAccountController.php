<?php

namespace App\Http\Controllers\module;

use App\Models\Campaign;
use App\Models\BankAccount;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankAccountResource;

class BankAccountController extends Controller
{
    public function create($campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);
        $bankAccounts = BankAccount::where('is_active', true)->get();

        return view('donation.create', compact('campaign', 'bankAccounts'));
    }

    public function index()
    {
        $bank_account = BankAccount::latest()->paginate(5);

        return new BankAccountResource(true, 'List Data Bank Account', $bank_account);
    }
}
