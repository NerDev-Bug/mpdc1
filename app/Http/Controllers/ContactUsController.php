<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("citidine/Citadines3");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("citidine/Citadines3");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate user input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|email:rfc,dns',
            'cont_no' => 'required|numeric|digits:11',
            'unit_type' => 'required|string',
        ]);

        // Save to database
        ContactUs::create($validated);

        // Send Email
        Mail::send([], [], function ($message) use ($validated) {
            $message->to('inquiries@malvedaproperties.com') // Admin Email
                ->subject('New Contact Form Submission')
                ->html(
                    '<p><strong>Name:</strong> ' . $validated['name'] . '</p>' .
                    '<p><strong>Email:</strong> ' . $validated['email'] . '</p>' .
                    '<p><strong>Contact Number:</strong> ' . $validated['cont_no'] . '</p>' .
                    '<p><strong>Unit Type:</strong> ' . $validated['unit_type'] . '</p>'
                );
        });
        // Redirect with success message
        return redirect()->to(url('/citadines'))->with('message', 'Message sent successfully');
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
