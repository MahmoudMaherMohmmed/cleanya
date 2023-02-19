<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Services\UploaderService;
use Illuminate\Http\UploadedFile;

class ApplicationController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'application';

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
        $applications = Application::latest()->get();
        return view('dashboard.application.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $application = null;
        return view('dashboard.application.form', compact('application'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApplicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicationRequest $request)
    {
        $application = new Application();
        $application->fill($request->except('working_days', 'logo'));
        $application->working_days = $this->getWorkingDaysString($request->working_days);
        if(isset($request->logo) && $request->logo!=null){
            $application->logo = $this->handleFile($request['logo']);
        }
        $application->save();

        return redirect('/application')->with('success', trans('dashboard.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        return view('dashboard.application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        return view('dashboard.application.form', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApplicationRequest  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $application->fill($request->except('working_days', 'logo'));
        $application->working_days = $this->getWorkingDaysString($request->working_days);
        if(isset($request->logo) && $request->logo!=null){
            $application->logo = $this->handleFile($request['logo']);
        }
        $application->save();

        return redirect('/application')->with('success', trans('dashboard.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        $application->delete();

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

    private function getWorkingDaysString($working_days){
        $working_days_string = '';

        foreach($working_days as $key=>$value){
            if( $key!= 0 ) {
                $working_days_string .= ', ';
            }

            $working_days_string .= $value;
        }

        return $working_days_string;
    }
}
