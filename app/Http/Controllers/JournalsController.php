<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class JournalsController extends Controller
{
    public function create($client): View
    {
        $client = auth()->user()->clients()->findOrFail($client);

        return view('journals.create', ['client' => $client]);
    }

    public function store($client, Request $request): Response
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

        return response($journal->client->url, 201);
    }

    public function destroy($client, $journal): Response
    {
        $journal = auth()->user()->clients()->findOrFail($client)->journals()->findOrFail($journal);

        $journal->delete();

        return response('Deleted', 201);
    }
}
