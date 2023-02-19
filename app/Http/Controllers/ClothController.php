<?php

namespace App\Http\Controllers;

use App\Models\Cloth;
use App\Http\Requests\StoreClothRequest;
use App\Http\Requests\UpdateClothRequest;
use App\Models\Service;
use App\Services\UploaderService;
use Illuminate\Http\UploadedFile;

class ClothController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    public const IMAGE_PATH = 'clothes';

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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $clothes = Cloth::latest()->get();
        return view('dashboard.cloth.index', compact('clothes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $cloth = null;
        $services = Service::latest()->get();

        return view('dashboard.cloth.form', compact('cloth', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClothRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClothRequest $request)
    {
        $cloth = new Cloth();
        $cloth->fill($request->except('ímage', 'service_id', 'cost'));
        if (isset($request->image) && $request->image != null) {
            $cloth->image = $this->handleFile($request['image']);
        }
        if ($cloth->save()) {
            foreach ($request->service_id as $key => $service_id) {
                $cloth->services()->attach($service_id, [
                    'cost' => $request->cost[$key],
                ]);
            }
        }

        return redirect('/clothes')->with('success', trans('dashboard.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cloth  $cloth
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $cloth = Cloth::findOrFail($id);

        return view('dashboard.cloth.show', compact('cloth'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cloth  $cloth
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $cloth = Cloth::findOrFail($id);
        $services = Service::latest()->get();

        return view('dashboard.cloth.form', compact('cloth', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClothRequest  $request
     * @param  \App\Models\Cloth  $cloth
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClothRequest $request, $id)
    {
        $cloth = Cloth::findOrFail($id);
        $cloth->fill($request->except('ímage', 'service_id', 'cost'));
        if (isset($request->image) && $request->image != null) {
            $cloth->image = $this->handleFile($request['image']);
        }
        if ($cloth->save()) {
            $cloth->services()->detach();
            foreach ($request->service_id as $key => $service_id) {
                $cloth->services()->attach($service_id, [
                    'cost' => $request->cost[$key],
                ]);
            }
        }

        return redirect('/clothes')->with('success', trans('dashboard.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cloth  $cloth
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cloth = Cloth::findOrFail($id);
        $cloth->delete();

        return redirect()->back()->with('success', trans('dashboard.deleted_successfully'));
    }

    /**
     * handle image file that return file path
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function handleFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_PATH);
    }
}
