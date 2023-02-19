<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Client;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::latest()->get();
        return view('dashboard.notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notification = null;
        $clients = Client::where('type', 0)->latest()->get();
        return view('dashboard.notification.form', compact('notification', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request)
    {
        if (in_array("0", $request->client_ids))
        {
            $request->client_ids = Client::where('type', 0)->pluck('id');
        }

        foreach($request->client_ids as $client_id){
            $notification = new Notification();
            $notification->fill($request->except('client_ids'));
            $notification->client_id = $client_id;
            $notification->save();

            $this->sendNotification($request, $client_id);
        }

        return redirect('/notifications')->with('success', trans('dashboard.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        return view('dashboard.notification.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationRequest  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->back()->with('success', trans('dashboard.deleted_successfully'));
    }

    private function sendNotification($request, $client_id){
        $client = Client::where('id', $client_id)->first();
        
        if(isset($client) && $client!=null){
            send_notification($client->device_token, array(
                "title" => $request->title, 
                "body" => $request->body
              ));
        }

        return true;
    }
}
