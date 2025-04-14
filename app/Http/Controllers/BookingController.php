<?php

namespace App\Http\Controllers;

use App\Mail\BookingMail;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255', // Updated field
                'last_name' => 'required|string|max:255',  // Added field
                'email' => 'required|email|max:255',
                'contact_number' => 'required|string|max:20',
                'date' => 'required|date',
                'time' => 'required',
            ]);

            // Save to database
            $booking = Booking::create($validated);

            // Format date and time for email
            $formattedDateTime = Carbon::parse($booking->date)->format('F d, Y') . ' at ' . Carbon::parse($booking->time)->format('g:i A'); // Example: March 21, 2025 at 3:30 PM

            // Send Email
            Mail::send([], [], function ($message) use ($validated, $formattedDateTime) {
                $message->to('inquiries@malvedaproperties.com') // Admin Email
                    ->subject('ACCREDITATION/PARTNER')
                    ->html(
                        $message = '<p><strong>NAME:</strong> ' . $validated['first_name'] . ' ' . $validated['last_name'] . '</p>'.
                        '<p><strong>EMAIL:</strong> ' . e($validated['email']) . '</p>' .
                        '<p><strong>CONTACT NO.:</strong> ' . e($validated['contact_number']) . '</p>' .
                        '<p><strong>DATE & TIME:</strong> ' . e($formattedDateTime) . '</p>'
                    );
            });

            // Redirect with success message
            return redirect()->to(url('/for-partners-and-brokers'))->with('message', 'Message sent successfully');
        } catch (Exception $e) {
            return redirect()->to(url('/for-partners-and-brokers'))->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
