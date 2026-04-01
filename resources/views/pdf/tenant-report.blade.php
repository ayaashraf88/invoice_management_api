<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tenant Report - {{ $tenantName }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .section-title { background: #f4f4f4; padding: 8px; font-weight: bold; margin-top: 20px; border-bottom: 2px solid #ddd; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #eee; padding: 8px; text-align: left; }
        th { background-color: #f9f9f9; }
        .total-row { font-weight: bold; background-color: #eee; }
        .text-right { text-align: right; }
        .balance-box { margin-top: 30px; padding: 15px; border: 2px solid #333; display: inline-block; float: right; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Tenant Financial Report</h1>
        <p><strong>Tenant:</strong> {{ $tenantName }}</p>
        <p><strong>Generated on:</strong> {{ now()->format('Y-m-d H:i') }}</p>
    </div>

    <div class="section-title">Active Contracts</div>
    <table>
        <thead>
            <tr>
                <th>Reference</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
                <tr>
                    <td>Contract #{{ $contract->id }}</td>
                    <td>{{ $contract->start_date->format('Y-m-d') }}</td>
                    <td>{{ $contract->end_date->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($contract->status ?? 'Active') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Invoices</div>
    <table>
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Date</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                    <td class="text-right">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Payment History</div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Method</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($payment->method ?? 'Transfer') }}</td>
                    <td class="text-right">${{ number_format($payment->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="balance-box">
        <strong>Total Outstanding Balance:</strong> 
        <span style="color: {{ $totalBalance > 0 ? 'red' : 'green' }}">
            ${{ number_format($totalBalance, 2) }}
        </span>
    </div>

</body>
</html>