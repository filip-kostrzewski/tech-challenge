<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ClientsController extends Controller
{
    public function index(): View
    {
        $clients = auth()->user()->clients()
            ->withCount('bookings')
            ->get();

        return view('clients.index', ['clients' => $clients]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function show(Request $request, $client): View
    {
        $request->validate([
            'booking_filter' => ['nullable', 'in:upcoming,past'],
        ]);

        $client = auth()->user()->clients()
            ->with(['journals'])
            ->with(['bookings' => function ($query) use ($request){
                $request->get('booking_filter') === 'upcoming' && $query->upcoming();
                $request->get('booking_filter') === 'past' && $query->past();
            }])
            ->findOrFail($client);

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'email' => ['required_without:phone', 'nullable', 'email:rfc,dns'],
            'phone' => ['required_without:email', 'nullable', 'regex:/^[\d\s\+]+$/'],
        ]);

        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->user_id = auth()->id();
        $client->save();

        return response($client, 201);
    }

    public function destroy($client): Response
    {
        auth()->user()->clients()->findOrFail($client)->delete();

        return response('Deleted', 201);
    }
}
