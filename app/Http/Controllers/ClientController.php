<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClientController extends Controller {
    /**
     * Display a listing of the resource.
     */

    use AuthorizesRequests;

    public function index(Request $request) {
        $query = auth()->user()->clients();
    
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('company', 'like', '%' . $request->search . '%');
            });
        }
    
        $clients = $query->latest()->paginate(5)->withQueryString();
    
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
    public function edit($id) {
        $client = auth()->user()->clients()->findOrFail($id);
    
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $client = auth()->user()->clients()->findOrFail($id);
    
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
    public function destroy($id) {
        $client = auth()->user()->clients()->findOrFail($id);
    
        $client->delete();
    
        return redirect()->back()->with('success', 'Client deleted');
    }
}
