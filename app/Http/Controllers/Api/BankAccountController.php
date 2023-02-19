<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankAccountResource;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    /**
     * Return BankAccounts
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $bank_accounts = BankAccount::where('status', 1)->latest()->get();

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'), 'data' => BankAccountResource::collection($bank_accounts)], 200);
    }
}