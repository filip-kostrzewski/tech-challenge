<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = auth()->user()->clients;

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($client)
    {
        $client = auth()->user()->clients()
            ->with('bookings:id,start,end,notes,client_id')
            ->findOrFail($client);

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->adress = $request->get('adress');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->user_id = auth()->id();
        $client->save();

        return $client;
    }

    public function destroy($client)
    {
        auth()->user()->clients()->findOrFail($client)->delete();

        return 'Deleted';
    }
}
