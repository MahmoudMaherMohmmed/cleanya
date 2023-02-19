<?php

namespace App\Http\Controllers;

use App\Models\BankTransfer;
use App\Http\Requests\StoreBankTransferRequest;
use App\Http\Requests\UpdateBankTransferRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Models\BalanceTransaction;
use App\Models\Client;

class BankTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_transfers = BankTransfer::latest()->get();
        return view('dashboard.bank_transfer.index', compact('bank_transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBankTransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankTransferRequest $request)
    {
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankTransfer  $bankTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(BankTransfer $bankTransfer)
    {
        $bank_transfer = BankTransfer::findOrFail($bankTransfer->id);
        return view('dashboard.bank_transfer.show', compact('bank_transfer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankTransfer  $bankTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(BankTransfer $bankTransfer)
    {
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBankTransferRequest  $request
     * @param  \App\Models\BankTransfer  $bankTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankTransferRequest $request, BankTransfer $bankTransfer)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankTransfer  $bankTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankTransfer $bankTransfer)
    {
        return redirect()->back();
    }

    public function updateStatus(Request $request, $id){
        $bank_transfer = BankTransfer::findOrFail($id);
        $bank_transfer->status = $request->status;
        if($bank_transfer->save()){
            if($request->status == 2){
               $this->createBalanceTransaction($bank_transfer, $request->amount);
            }
        }

        return redirect()->back()->with('success', trans('dashboard.status_updated_successfully'));
    }

    private function createBalanceTransaction($bank_transfer, $amount){
        $balance_transaction = new BalanceTransaction();
        $balance_transaction->client_id = $bank_transfer->client_id;
        $balance_transaction->bank_transfer_id = $bank_transfer->id;
        $balance_transaction->amount = $amount;
        if($balance_transaction->save()){
            $this->updateClientBalance($bank_transfer->client_id, $amount);
        }

        return true;
    }

    private function updateClientBalance($client_id, $amount){
        $client = Client::findOrFail($client_id);
        $client->balance = $client->balance + $amount;
        $client->save();

        return true;
    }
}
