<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $invoice->number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details table {
            width: 100%;
        }
        .invoice-details td {
            padding: 5px 0;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-top: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>INVOICE</h1>
        <h2>{{ $invoice->project->client->company ?? $invoice->project->client->name }}</h2>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td><strong>Invoice Number:</strong></td>
                <td>{{ $invoice->number }}</td>
            </tr>
            <tr>
                <td><strong>Project:</strong></td>
                <td>{{ $invoice->project->name }}</td>
            </tr>
            <tr>
                <td><strong>Issue Date:</strong></td>
                <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
            </tr>
            <tr>
                <td><strong>Due Date:</strong></td>
                <td>{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') : 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <hr>

    <div class="amount">
        Total Amount: Rp{{ number_format($invoice->amount, 2) }}
    </div>

    <div class="footer">
        Thank you for your business!
    </div>

</body>
</html>
