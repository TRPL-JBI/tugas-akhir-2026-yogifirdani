<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $booking->tourPackage->package_name ?? $booking->tourPackage->getTranslation('package_name') ?? 'Kutamasya' }} - #{{ $booking->booking_code }}</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- html2pdf library for instant PDF generation & direct download with custom filename -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 40px 0;
            line-height: 1.5;
        }

        .invoice-wrapper {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 24px 30px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* Action bar for screen only */
        .action-bar {
            max-width: 850px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-print {
            background-color: rgb(87, 201, 209);
            color: white;
            box-shadow: 0 4px 12px rgba(87, 201, 209, 0.3);
        }

        .btn-print:hover {
            background-color: #45bdc7;
            transform: translateY(-1px);
        }

        .btn-back {
            background-color: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-back:hover {
            background-color: #f1f5f9;
        }

        /* Decorative Header Line */
        .top-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, rgb(87, 201, 209), #70d4de);
        }

        /* Letterhead Section */
        .letterhead {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px dashed #f1f5f9;
            padding-bottom: 18px;
            margin-bottom: 18px;
        }

        .logo-area {
            display: flex;
            flex-direction: column;
        }

        .logo-text {
            font-size: 26px;
            font-weight: 800;
            color: rgb(87, 201, 209);
            letter-spacing: -1px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logo-text span {
            color: #334155;
        }

        .logo-subtitle {
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
            margin-top: 2px;
        }

        .metadata-area {
            text-align: right;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: 800;
            color: #1e293b;
            margin: 0 0 5px 0;
            letter-spacing: -0.5px;
        }

        .metadata-row {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 3px;
        }

        .metadata-row strong {
            color: #334155;
        }

        /* Billing Parties */
        .billing-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .billing-card {
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 14px 18px;
            border: 1px solid #e2e8f0;
        }

        .billing-card h3 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin: 0 0 8px 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }

        .billing-name {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 5px 0;
        }

        .billing-detail {
            font-size: 12px;
            color: #475569;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .billing-detail i {
            color: rgb(87, 201, 209);
            width: 14px;
            text-align: center;
        }

        /* Transaction Summary Table */
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .item-table th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            padding: 10px 14px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }

        .item-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            vertical-align: middle;
        }

        .item-name {
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 4px 0;
        }

        .item-desc {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }

        /* Pricing Details section */
        .totals-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            border-top: 2px dashed #f1f5f9;
            padding-top: 18px;
            margin-bottom: 20px;
        }

        .payment-info-box {
            flex: 1.2;
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 14px 18px;
            border: 1px solid #e2e8f0;
        }

        .payment-info-box h4 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin: 0 0 8px 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .info-row span {
            color: #64748b;
        }

        .info-row strong {
            color: #334155;
        }

        .totals-box {
            flex: 0.8;
            min-width: 250px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #475569;
            padding: 6px 0;
        }

        .total-row.grand-total {
            border-top: 2px solid #e2e8f0;
            padding-top: 10px;
            margin-top: 6px;
            font-weight: 800;
            font-size: 16px;
            color: #1e293b;
        }

        .total-row.paid-amount {
            color: rgb(87, 201, 209);
            font-weight: 700;
        }

        .total-row.balance-due {
            color: #ef4444;
            font-weight: 700;
        }

        /* Beautiful watermark stamp */
        .stamp-container {
            position: absolute;
            top: 100px;
            right: 60px;
            transform: rotate(-12deg);
            opacity: 0.9;
            z-index: 10;
            pointer-events: none;
        }

        .invoice-stamp {
            border: 3px double;
            font-size: 16px;
            font-weight: 900;
            text-transform: uppercase;
            padding: 8px 16px;
            border-radius: 8px;
            letter-spacing: 2px;
            text-align: center;
            display: inline-block;
        }

        .stamp-paid {
            border-color: #10b981;
            color: #10b981;
            background-color: rgba(16, 185, 129, 0.05);
            text-shadow: 0 0 1px rgba(16, 185, 129, 0.1);
        }

        .stamp-dp {
            border-color: rgb(87, 201, 209);
            color: rgb(87, 201, 209);
            background-color: rgba(87, 201, 209, 0.05);
        }

        .stamp-unpaid {
            border-color: #f59e0b;
            color: #f59e0b;
            background-color: rgba(245, 158, 11, 0.05);
        }

        /* Notes Card */
        .notes-card {
            background-color: #fffbeb;
            border: 1px dashed #fef3c7;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 11px;
            color: #b45309;
            margin-bottom: 20px;
        }

        .notes-card strong {
            color: #92400e;
        }

        /* Invoice Footer message */
        .invoice-footer {
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
            margin-top: 20px;
            font-size: 12px;
            color: #64748b;
        }

        .footer-thanks {
            font-size: 14px;
            font-weight: 600;
            color: rgb(87, 201, 209);
            margin: 0 0 5px 0;
        }

        .footer-signature-area {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
            text-align: center;
        }

        .signature-box {
            width: 180px;
            font-size: 11px;
            color: #64748b;
        }

        .signature-line {
            height: 40px;
            border-bottom: 1px solid #cbd5e1;
            margin-bottom: 6px;
        }

        /* Printable stylesheet formatting */
        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm 12mm; /* Hides default browser header/footer (URL, date, page numbers) completely */
            }
            body {
                background-color: #ffffff;
                padding: 0;
                margin: 0;
                color: #000;
                font-size: 11px; /* Slightly tighter text sizing to guarantee perfect single-page layout */
            }

            .no-print {
                display: none !important;
            }

            .invoice-wrapper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }

            .letterhead {
                padding-bottom: 12px !important;
                margin-bottom: 15px !important;
            }

            .logo-text {
                font-size: 22px !important;
            }

            .invoice-title {
                font-size: 20px !important;
            }

            .billing-section {
                gap: 15px !important;
                margin-bottom: 15px !important;
            }

            .billing-card {
                padding: 12px 15px !important;
            }

            .billing-card h3 {
                margin: 0 0 6px 0 !important;
                padding-bottom: 4px !important;
            }

            .billing-name {
                font-size: 13px !important;
            }

            .billing-detail {
                font-size: 11px !important;
                margin-bottom: 2px !important;
            }

            .item-table {
                margin-bottom: 15px !important;
            }

            .item-table th {
                padding: 8px 10px !important;
                background-color: #f1f5f9 !important;
                border-bottom: 2px solid #94a3b8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .item-table td {
                padding: 8px 10px !important;
                font-size: 11px !important;
            }

            .item-name {
                font-size: 12px !important;
                margin-bottom: 2px !important;
            }

            .totals-section {
                padding-top: 15px !important;
                margin-bottom: 15px !important;
                gap: 20px !important;
            }

            .payment-info-box {
                padding: 12px 15px !important;
            }

            .payment-info-box h4 {
                margin: 0 0 8px 0 !important;
                padding-bottom: 4px !important;
            }

            .info-row {
                font-size: 11px !important;
                margin-bottom: 4px !important;
            }

            .totals-box {
                min-width: 220px !important;
            }

            .total-row {
                font-size: 11px !important;
                padding: 4px 0 !important;
            }

            .total-row.grand-total {
                padding-top: 6px !important;
                margin-top: 4px !important;
                font-size: 13px !important;
            }

            .stamp-container {
                top: 75px !important;
                right: 35px !important;
            }

            .invoice-stamp {
                font-size: 13px !important;
                padding: 5px 10px !important;
                border-width: 2px !important;
            }

            .notes-card {
                padding: 10px !important;
                font-size: 10px !important;
                margin-bottom: 15px !important;
            }

            .invoice-footer {
                padding-top: 12px !important;
                margin-top: 15px !important;
            }

            .footer-thanks {
                font-size: 12px !important;
            }

            .footer-signature-area {
                margin-top: 15px !important;
            }

            .signature-line {
                height: 35px !important;
            }
        }
    </style>
</head>
<body>

    <!-- Action Bar (Screen Only) -->
    <div class="action-bar no-print">
        <a href="{{ route('profile', ['locale' => app()->getLocale(), 'tab' => 'pesanan']) }}" class="btn-action btn-back">
            <i class="fa fa-arrow-left"></i> {{ __('messages.profile_back_to_profile') }}
        </a>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn-action btn-back" style="border: 1px solid rgba(87, 201, 209, 0.4); color: rgb(87, 201, 209);">
                <i class="fa fa-print"></i> {{ __('messages.print_page_btn') }}
            </button>
            <button onclick="downloadInvoicePDF()" class="btn-action btn-print">
                <i class="fa fa-download"></i> {{ __('messages.download_pdf_btn') }}
            </button>
        </div>
    </div>

    <!-- Main Printable Invoice Wrapper -->
    <div class="invoice-wrapper">
        <div class="top-bar"></div>

        <!-- Watermark stamp -->
        <div class="stamp-container">
            @if($booking->booking_status === 'pending')
                <div class="invoice-stamp stamp-unpaid">{{ __('messages.waiting_payment_stamp') }}</div>
            @elseif($booking->dp_amount > 0 && $booking->remaining_amount > 0)
                <div class="invoice-stamp stamp-dp">{{ __('messages.dp_paid_stamp') }}</div>
            @else
                <div class="invoice-stamp stamp-paid">{{ __('messages.paid_confirmed_stamp') }}</div>
            @endif
        </div>

        <!-- Letterhead -->
        <div class="letterhead">
            <div class="logo-area">
                <h1 class="logo-text">Kutamasya<span>.id</span></h1>
                <div class="logo-subtitle">{{ app()->getLocale() == 'id' ? 'Temukan Petualangan Terbaikmu di Banyuwangi' : 'Find Your Best Adventure in Banyuwangi' }}</div>
            </div>
            <div class="metadata-area">
                <h2 class="invoice-title">{{ __('messages.invoice_title') }}</h2>
                <div class="metadata-row">{{ __('messages.order_no_label') }} <strong>#{{ $booking->booking_code }}</strong></div>
                <div class="metadata-row">{{ __('messages.ordered_date_label') }} <strong>{{ ($booking->booking_date ?? $booking->created_at)->translatedFormat('d M Y') }}</strong></div>
                <div class="metadata-row">{{ __('messages.payment_method_label') }} <strong>{{ __('messages.midtrans_automatic_transfer') }}</strong></div>
            </div>
        </div>

        <!-- Billing Addresses -->
        <div class="billing-section">
            <!-- Operator Kutamasya.id -->
            <div class="billing-card">
                <h3>{{ __('messages.issued_by') }}</h3>
                <h4 class="billing-name">Kutamasya Tour & Travel</h4>
                <div class="billing-detail">
                    <i class="fa fa-globe"></i> kutamasya.id
                </div>
                <div class="billing-detail">
                    <i class="fa fa-map-marker"></i> Jl. Raya Watukebo, Kec. Blimbingsari
                </div>
                <div class="billing-detail">
                    <i class="fa fa-phone"></i> +62 823-4399-1298
                </div>
                <div class="billing-detail">
                    <i class="fa fa-envelope"></i> kutamasya@gmail.com
                </div>
            </div>

            <!-- Customer Details -->
            <div class="billing-card">
                <h3>{{ __('messages.received_by') }}</h3>
                <h4 class="billing-name">{{ $booking->customer_name }}</h4>
                <div class="billing-detail">
                    <i class="fa fa-envelope"></i> {{ $booking->customer_email }}
                </div>
                <div class="billing-detail">
                    <i class="fa fa-phone"></i> {{ $booking->customer_phone }}
                </div>
                @if($booking->notes)
                <div class="billing-detail" style="align-items: flex-start;">
                    <i class="fa fa-pencil" style="margin-top: 3px;"></i> 
                    <span>{{ __('messages.notes') }} "{{ $booking->notes }}"</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Table of Items -->
        <table class="item-table">
            <thead>
                <tr>
                    <th>{{ __('messages.package_details') }}</th>
                    <th style="text-align: center;">{{ __('messages.num_participants') }}</th>
                    <th style="text-align: right;">{{ __('messages.unit_price') }}</th>
                    <th style="text-align: right;">{{ __('messages.total_price') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="item-name">{{ $booking->tourPackage->package_name ?? $booking->tourPackage->getTranslation('package_name') ?? 'Paket Wisata Banyuwangi' }}</div>
                        <div class="item-desc" style="margin-top: 4px; line-height: 1.6;">
                            @if($booking->tourPackage && ($booking->tourPackage->category || $booking->tourPackage->packageType))
                                <div style="margin-bottom: 4px; display: flex; gap: 4px; flex-wrap: wrap;">
                                    @if($booking->tourPackage->category)
                                    <span style="background-color: rgba(87, 201, 209, 0.1); color: rgb(87, 201, 209); padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; display: inline-block;">
                                        {{ $booking->tourPackage->category->getTranslation('category_name') }}
                                    </span>
                                    @endif
                                    @if($booking->tourPackage->packageType)
                                    <span style="background-color: rgba(71, 85, 105, 0.1); color: #475569; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; display: inline-block;">
                                        {{ $booking->tourPackage->packageType->getTranslation('type_name') }}
                                    </span>
                                    @endif
                                </div>
                            @endif
                            <i class="fa fa-calendar"></i> {{ __('messages.trip_date') }}: {{ $booking->trip_date->translatedFormat('d F Y') }}
                        </div>
                    </td>
                    <td style="text-align: center; font-weight: 600;">
                        {{ trans_choice('messages.pax_count', $booking->num_participants, ['count' => $booking->num_participants]) }} (Pax)
                    </td>
                    <td style="text-align: right;">
                        Rp {{ number_format($booking->total_price / $booking->num_participants, 0, ',', '.') }}
                    </td>
                    <td style="text-align: right; font-weight: 700; color: #1e293b;">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pricing Summary Box & Payments Box -->
        <div class="totals-section">
            <!-- Payment Info -->
            <div class="payment-info-box">
                <h4>{{ __('messages.transaction_details') }}</h4>
                <div class="info-row">
                    <span>{{ __('messages.order_date') }}</span>
                    <strong>{{ ($booking->booking_date ?? $booking->created_at)->translatedFormat('d F Y') }}</strong>
                </div>
                <div class="info-row">
                    <span>{{ __('messages.billing_status') }}</span>
                    <strong>
                        @if($booking->booking_status === 'pending')
                            <span style="color: #f59e0b; font-weight: 700;">{{ __('messages.awaiting_payment_status') }}</span>
                        @elseif($booking->booking_status === 'confirmed' || $booking->payment_status === 'paid')
                            <span style="color: #10b981; font-weight: 700;">{{ __('messages.paid_cleared_status') }}</span>
                        @else
                            <span style="color: rgb(87, 201, 209); font-weight: 700;">{{ __('messages.confirmed_status') }}</span>
                        @endif
                    </strong>
                </div>
                <div class="info-row">
                    <span>{{ __('messages.payment_method') }}</span>
                    <strong>Midtrans Snap Sandbox</strong>
                </div>
                <div class="info-row">
                    <span>{{ __('messages.payment_type') }}</span>
                    <strong>{{ $booking->dp_amount > 0 ? __('messages.down_payment_30') : __('messages.full_payment_paid') }}</strong>
                </div>
                <div class="info-row">
                    <span>{{ __('messages.transaction_id') }}</span>
                    <strong style="font-family: monospace; font-size: 11px;">{{ strtoupper($booking->booking_code) }}</strong>
                </div>
            </div>

            <!-- Totals -->
            <div class="totals-box">
                <div class="total-row">
                    <span>{{ __('messages.subtotal_bill') }}</span>
                    <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                </div>
                
                @if($booking->booking_status === 'pending')
                    <div class="total-row paid-amount" style="color: #94a3b8;">
                        <span>{{ __('messages.amount_paid_label') }}</span>
                        <strong>Rp 0</strong>
                    </div>
                    <div class="total-row balance-due">
                        <span>{{ __('messages.must_be_paid_label') }}</span>
                        <strong>Rp {{ number_format($booking->dp_amount > 0 ? $booking->dp_amount : $booking->total_price, 0, ',', '.') }}</strong>
                    </div>
                @else
                    @if($booking->dp_amount > 0)
                        <div class="total-row paid-amount">
                            <span>{{ __('messages.amount_paid_dp') }}</span>
                            <strong>Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</strong>
                        </div>
                        <div class="total-row balance-due">
                            <span>{{ __('messages.remaining_balance_settlement') }}</span>
                            <strong>Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</strong>
                        </div>
                    @else
                        <div class="total-row paid-amount">
                            <span>{{ __('messages.amount_paid_full') }}</span>
                            <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                        </div>
                        <div class="total-row" style="color: #10b981; font-weight: 700;">
                            <span>{{ __('messages.remaining_balance_label') }}</span>
                            <strong>Rp 0</strong>
                        </div>
                    @endif
                @endif

                <div class="total-row grand-total">
                    <span>{{ __('messages.total_bill_label') }}:</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @if($booking->booking_status === 'pending')
        <!-- Notes warning for Unpaid bookings -->
        <div class="notes-card">
            <i class="fa fa-exclamation-triangle"></i> <strong>{{ __('messages.important_notice_title') }}</strong> {{ __('messages.booking_not_valid_yet') }}
        </div>
        @endif

        <!-- Footer -->
        <div class="invoice-footer">
            <h5 class="footer-thanks">{{ __('messages.thank_you_for_trust') }}</h5>
            <p style="margin: 0 0 10px 0;">{{ __('messages.official_receipt_disclaimer') }} <strong>kutamasya.id</strong></p>
            
            <div class="footer-signature-area">
                <div class="signature-box">
                    <p style="margin: 0 0 5px 0;">{{ __('messages.sincerely_yours') }}</p>
                    <div class="signature-line"></div>
                    <p style="margin: 0; font-weight: 700; color: #334155;">Kutamasya Operations</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadInvoicePDF() {
            const element = document.querySelector('.invoice-wrapper');
            
            // Dynamic package name and date for beautiful filename representation
            const rawPackageName = "{{ $booking->tourPackage->package_name ?? $booking->tourPackage->getTranslation('package_name') ?? 'Kutamasya' }}";
            // Clean up special characters from the filename to prevent illegal character blocks
            const packageName = rawPackageName.replace(/[\\/:*?"<>|]/g, '').trim();
            const bookingDate = "{{ ($booking->booking_date ?? $booking->created_at)->translatedFormat('d-M-Y') }}";
            const bookingCode = "{{ $booking->booking_code }}";
            
            const filename = `${bookingDate} - Invoice ${packageName} - ${bookingCode}.pdf`;

            const opt = {
                margin:       [5, 10, 5, 10], // Tighter margins to guarantee perfect single-page layout
                filename:     filename,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2.5, useCORS: true, letterRendering: true, logging: false },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            const downloadBtn = document.querySelector('.btn-print');
            const originalText = downloadBtn.innerHTML;
            downloadBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> {{ app()->getLocale() == "id" ? "Mengunduh..." : "Downloading..." }}';
            downloadBtn.disabled = true;

            html2pdf().set(opt).from(element).save().then(() => {
                downloadBtn.innerHTML = originalText;
                downloadBtn.disabled = false;
            }).catch(err => {
                console.error("PDF generation failed: ", err);
                downloadBtn.innerHTML = originalText;
                downloadBtn.disabled = false;
                // Fallback to native printing if script fails
                window.print();
            });
        }
    </script>
</body>
</html>
