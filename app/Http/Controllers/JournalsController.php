<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use Illuminate\Http\Request;

class JournalsController extends Controller
{
    public function index()
    {
        $clients = auth()->user()->clients;

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create($client)
    {
        $client = auth()->user()->clients()->findOrFail($client);

        return view('journals.create', ['client' => $client]);
    }

    public function show(Request $request, $client)
    {
        $request->validate([
            'booking_filter' => ['nullable', 'in:upcoming,past'],
        ]);

        $client = auth()->user()->clients()
            ->with(['bookings' => function ($query) use ($request){
                $query->orderByDesc('start');

                if ($request->get('booking_filter') === 'upcoming') {
                    $query->where('end', '>=', now());
                }

                if ($request->get('booking_filter') === 'past') {
                    $query->where('start', '<', now());
                }
            }])
            ->findOrFail($client);

        return view('clients.show', ['client' => $client]);
    }

    public function store($client, Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'content' => ['required', 'string', 'max:50000']
        ]);

        $journal = new Journal();
        $journal->date = $request->get('date');
        $journal->content = $request->get('content');
        $journal->client_id = $client;
        $journal->save();

        return $journal->client->url;
    }

    public function destroy($client, $journal)
    {
        $journal = auth()->user()->clients()->findOrFail($client)->journals()->findOrFail($journal);

        $journal->delete();

        return 'Deleted';
    }
}
