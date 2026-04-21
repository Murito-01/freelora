<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $clients = auth()->user()->clients()->get();

        return view('clients.index', compact('clients'));
        
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
    public function store(Request $request) {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'company' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
    
        $data['user_id'] = Auth::id();
    
        Client::create($data);
    
        return redirect()->back()->with('success', 'Client created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client) {

        return view('clients.edit', compact('client'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client) {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'company' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $client->update($data);

        return redirect()->route('clients.index')->with('success', 'Client updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client) {

        $client->delete();
    
        return redirect()->back()->with('success', 'Client deleted');

    }
}
