<?php

namespace App\Http\Controllers;

use App\Models\Inquiry1;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Exception;

class Inquiry1Controller extends Controller
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
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|email:rfc,dns',
                'contact' => 'required|string|max:12',
                'unit_type' => 'required|string',
                'message' => 'nullable|string',
                'agree_to_privacy' => 'required|boolean',
            ]);

            // Save to database
            Inquiry1::create($validated);

            // Send Email
            Mail::send([], [], function ($message) use ($validated) {
                $message->to('inquiries@malvedaproperties.com') // Admin Email
                    ->subject('Private Residences request computation')
                    ->html(
                        $message = '<p><strong>INQUIRER NAME:</strong> ' . $validated['first_name'] . ' ' . $validated['last_name'] . '</p>'.
                        '<p><strong>INQUIRER EMAIL:</strong> ' . $validated['email'] . '</p>' .
                        '<p><strong>INQUIRER CONTACT NO.:</strong> ' . $validated['contact'] . '</p>' .
                        '<p><strong>PRIVATE RESIDENCE:</strong> ' . $validated['unit_type'] . '</p>' .
                        (!empty($validated['message']) ? '<p><strong>INQUIRER MESSAGE:</strong> ' . $validated['message'] . '</p>' : '')
                    );
            });

            return redirect()->to(url('/private-residence'))->with('message', 'Message sent successfully');
        } catch (Exception $e) {
            return redirect()->to(url('/private-residence'))->with('error', 'Something went wrong. Please try again later.');
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
