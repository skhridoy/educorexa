<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        /* PDF সেটিংস: মার্জিন কমানো হয়েছে ব্ল্যাঙ্ক পেজ রোধ করতে */
        @page { size: A4 landscape; margin: 0; }
        body { font-family: 'Helvetica', sans-serif; margin: 0; padding: 10px; background-color: white; color: #333; line-height: 1.2; }
        
        .master-container { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .receipt-column { width: 50%; padding: 8px; vertical-align: top; }
        
        /* বর্ডার এবং জলছাপ কন্টেইনার */
        .receipt-border { 
            border: 1px dashed #ccc; 
            border-radius: 8px; 
            overflow: hidden; 
            position: relative;
            height: 730px; /* ফিক্সড হাইট যাতে ব্ল্যাঙ্ক পেজ না আসে */
        }

        .watermark {
            position: absolute;
            top: 55%; left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            z-index: -1;
            opacity: 15%;
            width: 100%;
            text-align: center;
        }
        .watermark img{
            width: 250px;
            height: auto;

        }

        /* হেডার */
        .header-table { width: 100%; background-color: #1a2a4e; color: white; padding: 15px; border-collapse: collapse; }
        .school-logo-cell { width: 60px; vertical-align: middle; }
        .logo-box img { width: 50px; height: 50px; border-radius: 5px; }
        
        .school-info-cell { vertical-align: middle; padding-left: 10px; }
        .school-name { margin: 0; font-size: 16px; text-transform: uppercase; font-weight: bold; }
        .school-addr { margin: 2px 0 0; font-size: 12px; color: #ccc; }
        
        .rec-meta-cell { text-align: right; vertical-align: middle; }
        .copy-tag { background: #e2a03f; color: #1a2a4e; font-size: 9px; font-weight: bold; padding: 2px 8px; border-radius: 4px; display: inline-block; text-transform: uppercase; }
        .rec-no { font-size: 16px; font-weight: bold; margin: 5px 0 0; }
        .date { font-size: 14px; color: #bbb; }

        .banner { background-color: #00a65a; color: white; text-align: center; padding: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase; }

        .content { padding: 10px; line-height: 20px;}
        .section-title { color: #888; font-size: 13px; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #eee; padding-bottom: 4px; margin-bottom: 10px; }
        
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; table-layout: fixed; }
        .info-table td { width: 33.33%; padding-bottom: 8px; vertical-align: top; }
        .info-label { display: block; font-size: 12px; color: #888; text-transform: uppercase; }
        .info-value { display: block; font-size: 13px; font-weight: bold; color: #1a2a4e; margin-top: 1px; }

        .payment-table { width: 100%; border-collapse: collapse; }
        .payment-table thead th { background-color: #1a2a4e; color: white; font-size: 12px; padding: 6px; text-align: left; }
        .payment-table tbody td { padding: 8px 6px; border-bottom: 1px solid #eee; font-size: 13px; }
        
        .total-row td { background-color: #1a2a4e; color: white; font-weight: bold; font-size: 14px; }
        .tk-symbol { color: #e2a03f; }

        .in-words-box { border: 1px solid #00a65a; border-left: 4px solid #00a65a; padding: 6px; margin-top: 10px; border-radius: 4px; font-style: italic; font-size: 12px; color: #555; }

        .footer-sigs-table { width: 100%; border-collapse: collapse; margin-top: 40px; }
        .sig-cell { width: 50%; text-align: center; vertical-align: top; padding: 0 20px; }
        .sig-line { border-top: 1px solid #ccc; font-size: 12px; color: #777; padding-top: 3px; }
        
        .comp-gen { text-align: center; font-size: 10px; color: #a7a3a3; padding-top: 25px; }
    </style>
</head>
<body>

<table class="master-container">
    <tr>
        @foreach(['OFFICE COPY', 'STUDENT COPY'] as $copyType)
        <td class="receipt-column">
            <div class="receipt-border">
                <div class="watermark">
                    <img src="{{ $schoolLogo }}" alt=""></div>
                
                <table class="header-table">
                    <tr>
                        <td class="school-logo-cell">
                            <div class="logo-box">
                                <img src="{{ $schoolLogo }}" alt="Logo">
                            </div> 
                        </td>
                        <td class="school-info-cell">
                            <h2 class="school-name">{{ $school->name }}</h2>
                            <p class="school-addr">{{ $school->address ?? 'Address' }} , {{ $school->phone ?? '01700000000'}}</p>
                        </td>
                        <td class="rec-meta-cell">
                            <div class="copy-tag" style="{{ $copyType == 'STUDENT COPY' ? 'background: #00a65a; color: #fff;' : '' }}">
                                {{ $copyType }}
                            </div>
                            <p class="rec-no">#REC-{{ $fee->id }}</p>
                            <p class="date">{{ date('d M, Y') }}</p>
                        </td>
                    </tr>
                </table>

                <div class="banner">Official Payment Receipt</div>

                <div class="content">
                    <div class="section-title">Student Information</div>
                    <table class="info-table">
                        <tr>
                            <td><span class="info-label">Full name</span><span class="info-value">{{ $student->name }}</span></td>
                            <td><span class="info-label">Student ID</span><span class="info-value">{{ $student->student_id }}</span></td>
                            <td><span class="info-label">Class Roll</span><span class="info-value">{{ $student->roll }}</span></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Collected By</span><span class="info-value">{{ $fee->collector->name ?? 'Admin' }}</span></td>
                            <td><span class="info-label">Class Name</span><span class="info-value">{{ $student->class->name }}</span></td>
                            <td><span class="info-label">Method</span><span class="info-value">{{ ucfirst($fee->payment_method) }}</span></td>
                        </tr>
                        <tr>
                            <td><span class="info-label">Month</span><span class="info-value">{{ $fee->month }}</span></td>
                            <td><span class="info-label">Mobile</span><span class="info-value">{{ $student->contact_number }}</span></td>
                        </tr>
                    </table>

                    <div class="section-title">Payment Details</div>
                    <table class="payment-table">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th width="65%">DESCRIPTION</th>
                                <th width="25%" style="text-align: right;">AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ $fee->feeHead->name }}</td>
                                <td style="text-align: right;">Tk {{ number_format($fee->amount, 2) }}</td>
                            </tr>
                            <tr class="total-row">
                                <td colspan="2">TOTAL PAID</td>
                                <td style="text-align: right;"><span class="tk-symbol">Tk</span> {{ number_format($fee->amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="in-words-box">
                        <strong>"</strong> In words: {{ ucfirst($amountInWords) }} Only <strong>"</strong>
                    </div>
                </div>

                <table class="footer-sigs-table">
                    <tr>
                        <td class="sig-cell"><div class="sig-line">Accounts Signature</div></td>
                        <td class="sig-cell"><div class="sig-line">Authorized Signature</div></td>
                    </tr>
                </table>
                
                <div class="comp-gen">
                    <strong>{{ $school->name }}</strong><br>
                    This recipt Software generated by <strong>EduCorexa</strong>
                </div>
            </div>
        </td>
        @endforeach
    </tr>
</table>

</body>
</html>