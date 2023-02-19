<?php

namespace App\Http\Controllers;

use App\Models\Cloth;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\ReservationItem;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Notification;
use App\Models\Application;
use App\Models\Address;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reservations = Reservation::latest()->get();

        return view('dashboard.reservation.index', compact('reservations'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function show(Reservation $reservation)
    {
        $representatives = Client::where('type', 1)->latest()->get();

        return view('dashboard.reservation.show', compact('reservation', 'representatives'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function edit(Reservation $reservation)
    {
        $clients = Client::where('type', 0)->latest()->get();
        $representatives = Client::where('type', 1)->latest()->get();
        $addresses = Address::latest()->get();
        $services = Service::latest()->get();
        $clothes = Cloth::latest()->get();

        return view('dashboard.reservation.form', compact('reservation', 'clients', 'representatives', 'addresses', 'services', 'clothes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReservationRequest  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation->fill($request->only('client_id', 'representative_id', 'reception_address_id', 'reception_date', 'reception_time', 'sending_address_id', 'sending_date', 'sending_time', 'delivery_cost', 'status'));
        $reservation->pieces_price = $this->calPiecesPrice($request);
        $reservation->price_after_discount = $this->calPiecesPrice($request);
        $reservation->tax = $this->getTax();
        $reservation->tax_amount = $this->calTaxAmount($request->delivery_cost, $reservation->pieces_price, $reservation->tax);
        $reservation->total_price = $this->calTotalPrice($request->delivery_cost, $reservation->pieces_price, $reservation->tax);
        if ($reservation->save()) {
            $reservation->items()->delete();
            foreach ($request->service_ids as $key=>$service_id) {
                $cloth_service = Service::where('id', $service_id)->first()->clothes()->where('cloth_id', $request->cloth_ids[$key])->first();
                $item = new ReservationItem();
                $item->reservation_id = $reservation->id;
                $item->service_id = $service_id;
                $item->cloth_id = $request->cloth_ids[$key];
                $item->piece_cost = $cloth_service->pivot->cost;
                $item->pieces_number = $request->pieces_numbers[$key];
                $item->cost = ($request->pieces_numbers[$key]) * ($cloth_service->pivot->cost);
                $item->save();
            }
        }

        $this->updateReservationStatusNotification($reservation);

        return redirect('/reservations')->with('success', trans('dashboard.update_successfully'));
    }

    /**
     * CalPiecesPrice
     *
     * @param mixed $request
     * @return float|int
     */
    private function calPiecesPrice($request)
    {
        $total_price = 0;

        foreach ($request->service_ids as $key=>$service_id) {
            $cloth_service = Service::where('id', $service_id)->first()->clothes()->where('cloth_id', $request->cloth_ids[$key])->first();
            $total_price += ($request->pieces_numbers[$key]) * ($cloth_service->pivot->cost);
        }

        return $total_price;
    }

    /**
     * GetTax
     *
     * @return float|int
     */
    private function getTax()
    {
        $application = Application::first();

        return $application != null ? $application->tax : 0;
    }

    /**
     * CalTaxAmount
     *
     * @param mixed $delivery_cost
     * @param mixed $pieces_price
     * @param mixed $tax
     * @return float
     */
    private function calTaxAmount($delivery_cost, $pieces_price, $tax)
    {
        return ($delivery_cost + $pieces_price) * ($tax / 100);
    }

    /**
     * CalTotalPrice
     *
     * @param mixed $delivery_cost
     * @param mixed $pieces_price
     * @param mixed $tax
     * @return float
     */
    private function calTotalPrice($delivery_cost, $pieces_price, $tax)
    {
        return ($delivery_cost + $pieces_price) + (($delivery_cost + $pieces_price) * ($tax / 100));
    }

    private function updateReservationStatusNotification($reservation)
    {
        if ($reservation->status == 0) {
            $message = array(
                "title" => trans('notifications.reject_reservation'),
                "body" => trans('notifications.reject_reservation_body'),
            );
        } elseif ($reservation->status == 1) {
            $message = array(
                "title" => trans('notifications.pending_reservation'),
                "body" => trans('notifications.pending_reservation_body'),
            );
        } elseif ($reservation->status == 2) {
            $message = array(
                "title" => trans('notifications.in_receive_reservation'),
                "body" => trans('notifications.in_receive_reservation_body'),
            );
        } elseif ($reservation->status == 3) {
            $message = array(
                "title" => trans('notifications.received_reservation'),
                "body" => trans('notifications.received_reservation_body'),
            );
        } elseif ($reservation->status == 4) {
            $message = array(
                "title" => trans('notifications.washing_reservation'),
                "body" => trans('notifications.washing_reservation_body'),
            );
        } elseif ($reservation->status == 5) {
            $message = array(
                "title" => trans('notifications.in_delivery_reservation'),
                "body" => trans('notifications.in_delivery_reservation_body'),
            );
        } elseif ($reservation->status == 6) {
            $message = array(
                "title" => trans('notifications.delivered_reservation'),
                "body" => trans('notifications.delivered_reservation_body'),
            );
        }

        $this->saveNotification($reservation->client->id, $message);
        send_notification($reservation->client->device_token, $message);
    }

    public function representative(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->representative_id = $request->representative_id;
        $reservation->save();

        $this->representativeReservationNotification($reservation);

        return redirect()->back()->with('success', trans('dashboard.update_successfully'));
    }

    private function representativeReservationNotification($reservation)
    {
        send_notification($reservation->client->device_token, array(
            "title" => trans('notifications.client_representative_reservation'),
            "body" => trans('notifications.client_representative_reservation_body'),
        ));

        $this->saveNotification($reservation->client->id, [
            "title" => trans('notifications.client_representative_reservation'),
            "body" => trans('notifications.client_representative_reservation_body'),
        ]);

        send_notification($reservation->representative->device_token, array(
            "title" => trans('notifications.representative_reservation'),
            "body" => trans('notifications.representative_reservation_body'),
        ));

        $this->saveNotification($reservation->representative->id, [
            "title" => trans('notifications.representative_reservation'),
            "body" => trans('notifications.representative_reservation_body'),
        ]);
    }

    private function saveNotification($client_id, $message)
    {
        $notification = new Notification();
        $notification->client_id = $client_id;
        $notification->title = $message['title'];
        $notification->body = $message['body'];
        $notification->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->back()->with('success', trans('dashboard.deleted_successfully'));
    }

    public function invoice($id)
    {
        $reservation = Reservation::findOrFail($id);
        $services_price = $this->calServicesPrice($reservation);

        return view('dashboard.reservation.invoice', compact('reservation', 'services_price'));
    }

    private function newReservationMail($reservation)
    {
        $application = Application::first();

        if ($application != null) {
            \Mail::to($application->email_1)->send(new \App\Mail\NewReservationMail($reservation));
        }
    }
}
