<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function index() {

    $user = auth()->user();
    $totalClients = $user->clients()->count();

    return view('dashboard', compact('totalClients'));
}
}
