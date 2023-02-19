<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Services\UploaderService;
use Illuminate\Http\UploadedFile;

class ServiceController extends Controller
{
    /**
     * IMAGE_PATH
     *
     * @var string
     */
    public const IMAGE_PATH = 'services';

    /**
     * UploaderService
     *
     * \App\Services\UploaderService $uploaderService
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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $services = Service::latest()->get();
        return view('dashboard.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $service = null;
        return view('dashboard.service.form', compact('service'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $service = new Service();
        $service->fill($request->except('ímage'));
        if (isset($request->image) && $request->image!=null) {
            $service->image = $this->handleFile($request['image']);
        }
        $service->save();

        return redirect('/services')->with('success', trans('dashboard.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View
     */
    public function show(Service $service)
    {
        return view('dashboard.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View
     */
    public function edit(Service $service)
    {
        return view('dashboard.service.form', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->fill($request->except('ímage'));
        if (isset($request->image) && $request->image!=null) {
            $service->image = $this->handleFile($request['image']);
        }
        $service->save();

        return redirect('/services')->with('success', trans('dashboard.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->back()->with('success', trans('dashboard.deleted_successfully'));
    }

    /**
     * handle image file that return file path
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function handleFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_PATH);
    }
}
