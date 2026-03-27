<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Фактура') }} #{{ $invoice->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
            color: #333;
        }

        .invoice-container {
            background: white;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .company-info h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .company-info p {
            font-size: 12px;
            color: #666;
            line-height: 1.6;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h1 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .invoice-number {
            font-size: 14px;
            color: #666;
        }

        .invoice-dates {
            display: flex;
            gap: 40px;
            margin-bottom: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
        }

        .date-field {
            flex: 1;
        }

        .date-field label {
            display: block;
            font-weight: bold;
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .date-field p {
            font-size: 16px;
            color: #333;
        }

        .party-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .party-section h3 {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
        }

        .party-section p {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        .details-table {
            width: 100%;
            margin: 30px 0;
            border-collapse: collapse;
        }

        .details-table th {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #2c3e50;
        }

        .details-table td {
            padding: 15px;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        .details-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .details-table tr:last-child td {
            font-weight: bold;
            background: #f0f0f0;
        }

        .amount-column {
            text-align: right;
            width: 150px;
        }

        .tour-info {
            font-size: 12px;
            color: #666;
        }

        .type-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            width: 70px;
        }

        .type-inbound {
            background: #ffebee;
            color: #c62828;
        }

        .type-outbound {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            width: 80px;
        }

        .status-paid {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-pending {
            background: #fff8e1;
            color: #f57f17;
        }

        .summary-section {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .summary-box {
            width: 400px;
        }

        .summary-row {
            display: grid;
            grid-template-columns: 1fr auto;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .summary-row.total {
            border-bottom: 2px solid #333;
            border-top: 2px solid #333;
            padding: 12px 0;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .summary-label {
            color: #666;
        }

        .summary-value {
            text-align: right;
            font-weight: bold;
            color: #333;
        }

        .notes-section {
            margin-top: 40px;
            padding: 20px;
            background: #f9f9f9;
            border-left: 4px solid #2c3e50;
            border-radius: 3px;
        }

        .notes-section h3 {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 10px;
        }

        .notes-section p {
            font-size: 13px;
            color: #333;
            line-height: 1.5;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #999;
            font-size: 11px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .print-button {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .print-button:hover {
            background: #1a2332;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                max-width: 100%;
            }

            .print-button {
                display: none;
            }

            .no-print {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .invoice-container {
                padding: 20px;
            }

            .party-info {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .invoice-dates {
                flex-direction: column;
                gap: 15px;
            }

            .summary-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="padding: 20px; text-align: center;">
        <button class="print-button" onclick="window.print()">
            🖨️ {{ __('Печати') }}
        </button>
    </div>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h2>{{ $invoice->company->name ?? __('Компанија') }}</h2>
                @if($invoice->company)
                    <p>{{ $invoice->company->headquarters ?? '' }}</p>
                    @if($invoice->company->phone)
                        <p>{{ __('Телефон') }}: {{ $invoice->company->phone }}</p>
                    @endif
                    @if($invoice->company->email)
                        <p>{{ __('Имејл') }}: {{ $invoice->company->email }}</p>
                    @endif
                @endif
            </div>
            <div class="invoice-title">
                <h1>{{ __('Фактура') }}</h1>
                <p class="invoice-number">#{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Dates -->
        <div class="invoice-dates">
            <div class="date-field">
                <label>{{ __('Датум на издавање') }}</label>
                <p>{{ $invoice->issue_date->format('d.m.Y') }}</p>
            </div>
            <div class="date-field">
                <label>{{ __('Краен датум') }}</label>
                <p>{{ $invoice->due_date?->format('d.m.Y') ?? '-' }}</p>
            </div>
            <div class="date-field">
                <label>{{ __('Тип') }}</label>
                <p>
                    @if($invoice->type === 'inbound')
                        <span class="type-badge type-inbound">{{ __('Влезна') }}</span>
                    @else
                        <span class="type-badge type-outbound">{{ __('Излезна') }}</span>
                    @endif
                </p>
            </div>
            <div class="date-field">
                <label>{{ __('Статус') }}</label>
                <p>
                    @if($invoice->status === 'paid')
                        <span class="status-badge status-paid">{{ __('Плачено') }}</span>
                    @else
                        <span class="status-badge status-pending">{{ __('Во исплата') }}</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Party Info -->
        <div class="party-info">
            <div class="party-section">
                <h3>{{ __('Од') }}</h3>
                <p><strong>{{ $invoice->company->name ?? __('Компанија') }}</strong></p>
                <p>{{ $invoice->company->headquarters ?? '' }}</p>
                @if($invoice->company?->phone)
                    <p>{{ __('Телефон') }}: {{ $invoice->company->phone }}</p>
                @endif
            </div>
            <div class="party-section">
                <h3>{{ __('За') }}</h3>
                <p><strong>{{ $invoice->client_or_supplier_name }}</strong></p>
                @if($invoice->tour)
                    <p class="tour-info">
                        {{ __('Поврзано со тура') }}: 
                        <strong>#{{ $invoice->tour->id }}</strong>
                    </p>
                    <p class="tour-info">
                        {{ $invoice->tour->start_location }} → {{ $invoice->tour->end_location }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Details Table -->
        <table class="details-table">
            <thead>
                <tr>
                    <th>{{ __('Опис') }}</th>
                    <th class="amount-column">{{ __('Износ (ден)') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @if($invoice->type === 'inbound')
                            {{ __('Влезна фактура') }} 
                        @else
                            {{ __('Излезна фактура') }}
                        @endif
                        @if($invoice->tour)
                            <br><span class="tour-info">{{ __('Тура') }} #{{ $invoice->tour->id }}: {{ $invoice->tour->start_location }} → {{ $invoice->tour->end_location }}</span>
                        @endif
                    </td>
                    <td class="amount-column">{{ number_format($invoice->amount, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right; font-weight: bold;">{{ __('ВКУПНО') }}:</td>
                    <td class="amount-column" style="font-weight: bold; font-size: 14px;">{{ number_format($invoice->amount, 2) }} ден</td>
                </tr>
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary-section">
            <div class="summary-box">
                <div class="summary-row">
                    <span class="summary-label">{{ __('Вкупен износ') }}:</span>
                    <span class="summary-value">{{ number_format($invoice->amount, 2) }} ден</span>
                </div>
                <div class="summary-row total">
                    <span class="summary-label">{{ __('За плаќање') }}:</span>
                    <span class="summary-value">{{ number_format($invoice->amount, 2) }} ден</span>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($invoice->notes)
        <div class="notes-section">
            <h3>{{ __('Забелешка') }}</h3>
            <p>{{ nl2br(e($invoice->notes)) }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>{{ __('Оваа фактура е генерирана од системот управување со флота') }}</p>
            <p>{{ __('Датум на печатење') }}: {{ now()->format('d.m.Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
