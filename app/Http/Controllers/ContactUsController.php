<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|email:rfc,dns',
            'cont_no' => 'required|numeric|digits:11',
            'unit_type' => 'required|string',
        ]);

        ContactUs::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'cont_no' => $request->cont_no,
            'unit_type' => $request->unit_type,
        ]);

        return redirect()->to('/citadines')->with('message', 'Message sent successfully');
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
