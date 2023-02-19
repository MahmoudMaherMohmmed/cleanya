<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreRepresentativeRequest;
use App\Http\Requests\UpdateRepresentativeRequest;
use App\Services\UploaderService;
use Illuminate\Http\UploadedFile; 

class RepresentativeController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'representatives';

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
        $representatives = Client::where('type', 1)->latest()->get();
        return view('dashboard.representative.index', compact('representatives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $representative = null;
        return view('dashboard.representative.form', compact('representative'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRepresentativeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRepresentativeRequest $request)
    {
        $representative = new Client();
        $representative->fill($request->except('ímage'));
        if(isset($request->image) && $request->image!=null){
            $representative->image = $this->handleFile($request['image']);
        }
        $representative->type = 1;
        $representative->save();

        return redirect('/representatives')->with('success', trans('dashboard.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $representative = Client::findOrFail($id);
        return view('dashboard.representative.show', compact('representative'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $representative = Client::findOrFail($id);
        return view('dashboard.representative.form', compact('representative'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRepresentativeRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRepresentativeRequest $request, $id)
    {
        $representative = Client::findOrFail($id);
        $representative->fill($request->except('ímage', 'password'));
        if(isset($request->image) && $request->image!=null){
            $representative->image = $this->handleFile($request['image']);
        }
        if($request->password!=null){
            $representative->password = $request->password;
        }
        $representative->type = 1;
        $representative->save();

        return redirect('/representatives')->with('success', trans('dashboard.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $representative = Client::findOrFail($id);
        $representative->delete();

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
