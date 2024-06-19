<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function destroy($client, $booking)
    {
        $booking = auth()->user()->clients()->findOrFail($client)->bookings()->findOrFail($booking);

        $booking->delete();

        return 'Deleted';
    }
}
