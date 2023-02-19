<?php

namespace App\Http\Controllers;

use App\Models\BalanceTransaction;
use App\Http\Requests\StoreBalanceTransactionRequest;
use App\Http\Requests\UpdateBalanceTransactionRequest;

class BalanceTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBalanceTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBalanceTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BalanceTransaction  $balanceTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(BalanceTransaction $balanceTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BalanceTransaction  $balanceTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(BalanceTransaction $balanceTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBalanceTransactionRequest  $request
     * @param  \App\Models\BalanceTransaction  $balanceTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBalanceTransactionRequest $request, BalanceTransaction $balanceTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BalanceTransaction  $balanceTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(BalanceTransaction $balanceTransaction)
    {
        //
    }
}
