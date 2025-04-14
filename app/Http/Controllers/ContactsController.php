<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contacts;
use Exception;
class ContactsController extends Controller
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
                'inquiry_type' => 'required|string',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'country_code' => 'required|string',
                'mobile' => 'required|string',
                'project' => 'required|string',
                'description' => 'required|string',
                'agree_terms' => 'required|boolean',
            ]);

            // Save to database
            Contacts::create($validated);

            // Send Email
            Mail::send([], [], function ($message) use ($validated) {
                $message->to('inquiries@malvedaproperties.com') // Admin Email
                    ->subject('CONTACT US')
                    ->html(
                        '<p><strong>INQUIRY TYPE:</strong> ' . e($validated['inquiry_type']) . '</p>' .
                        $message = '<p><strong>INQUIRER NAME:</strong> ' . $validated['first_name'] . ' ' . $validated['last_name'] . '</p>'.
                        '<p><strong>INQUIRER EMAIL:</strong> ' . e($validated['email']) . '</p>' .
                        '<p><strong>INQUIRER MOBILE:</strong> ' . e($validated['mobile']) . '</p>' .
                        '<p><strong>PROJECT INQUIRED:</strong> ' . e($validated['project']) . '</p>' .
                        '<p><strong>DESCRIPTION:</strong> ' . nl2br(e($validated['description'])) . '</p>'
                    );
            });

            return redirect()->to(url('/contact-us'))->with('message', 'Message sent successfully');
        } catch (Exception $e) {
            return redirect()->to(url('/contact-us'))->with('error', 'Something went wrong. Please try again later.');
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
