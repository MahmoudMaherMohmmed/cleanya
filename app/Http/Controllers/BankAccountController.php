<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Http\Requests\StoreBankAccountRequest;
use App\Http\Requests\UpdateBankAccountRequest;
use App\Services\UploaderService;
use Illuminate\Http\UploadedFile;  

class BankAccountController extends Controller
{
    /**
     * @var IMAGE_PATH 
     */
    const IMAGE_PATH = 'bank_accounts';

    /**
     * @var UploaderService 
     */
    private $uploaderService;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_accounts = BankAccount::latest()->get();
        return view('dashboard.bank_account.index', compact('bank_accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bank_account = null;
        return view('dashboard.bank_account.form', compact('bank_account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBankAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankAccountRequest $request)
    {
        $bank_account = new BankAccount();
        $bank_account->fill($request->except('ímage'));
        if(isset($request->image) && $request->image!=null){
            $bank_account->image = $this->handleFile($request['image']);
        }
        $bank_account->save();

        return redirect('/bank-accounts')->with('success', trans('dashboard.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank_account = BankAccount::findOrFail($id);
        return view('dashboard.bank_account.show', compact('bank_account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank_account = BankAccount::findOrFail($id);
        return view('dashboard.bank_account.form', compact('bank_account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBankAccountRequest  $request
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankAccountRequest $request, BankAccount $bankAccount)
    {
        $bank_account = BankAccount::findOrFail($bankAccount->id);
        $bank_account->fill($request->except('ímage'));
        if(isset($request->image) && $request->image!=null){
            $bank_account->image = $this->handleFile($request['image']);
        }
        $bank_account->save();

        return redirect('/bank-accounts')->with('success', trans('dashboard.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return redirect()->back()->with('success', trans('dashboard.deleted_successfully'));
    }

     /**
     * handle image file that return file path
     * @param File $file
     * @return string
     */
    public function handleFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_PATH);
    }
}
