<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Http\Requests\StoreContactMessageRequest;
use App\Http\Requests\UpdateContactMessageRequest;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact_messages = ContactMessage::latest()->get();
        return view('dashboard.contact_message.index', compact('contact_messages'));
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
     * @param  \App\Http\Requests\StoreContactMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactMessageRequest $request)
    {
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function show(ContactMessage $contactMessage)
    {
        $contact_message = $contactMessage;
        return view('dashboard.contact_message.show', compact('contact_message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactMessage $contactMessage)
    {
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactMessageRequest  $request
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactMessageRequest $request, ContactMessage $contactMessage)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactMessage  $contactMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactMessage $contactMessage)
    {
        return redirect()->back();
    }
}
