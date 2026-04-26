<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

class InvoiceController extends Controller {
    use AuthorizesRequests;

    public function store(Request $request, Project $project) {
        $this->authorize('update', $project);

        Invoice::create([
            'project_id' => $project->id,
            'number' => 'INV-' . str_pad(Invoice::count() + 1, 3, '0', STR_PAD_LEFT),
            'amount' => $request->amount,
            'due_date' => $request->due_date,
        ]);

        return back();
    }

    public function download(Invoice $invoice) {
        $this->authorize('view', $invoice->project);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download($invoice->number . '.pdf');
    }

    public function updateStatus(Request $request, Invoice $invoice) {
        $this->authorize('update', $invoice->project);

        $request->validate([
            'status' => 'required|in:unpaid,paid'
        ]);

        $invoice->update([
            'status' => $request->status
        ]);

        return back();
    }

    public function send(Invoice $invoice) {
        $client = $invoice->project->client;

        if (!$client->email) {
            return back()->with('error', 'Client has no email.');
        }

        Mail::to($client->email)->send(new InvoiceMail($invoice));

        return back()->with('success', 'Invoice sent!');
    }
}