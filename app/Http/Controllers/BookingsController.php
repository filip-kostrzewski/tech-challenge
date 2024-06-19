<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class BookingsController extends Controller
{
    public function destroy($client, $booking): Response
    {
        $booking = auth()->user()->clients()->findOrFail($client)->bookings()->findOrFail($booking);

        $booking->delete();

        return response('Deleted', 201);
    }
}
