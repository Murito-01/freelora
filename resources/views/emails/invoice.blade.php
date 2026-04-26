<h2>Invoice {{ $invoice->number }}</h2>

<p>Hello,</p>

<p>You have received an invoice for your project:</p>

<p><strong>{{ $invoice->project->name }}</strong></p>

<p>Amount: ${{ number_format($invoice->amount, 2) }}</p>

<p>Please see the attached PDF for details.</p>

<p>Thank you.</p>