<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4 landscape; margin: 5px; }
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica', sans-serif; margin: 0; padding: 5px; background: white; color: #333; font-size: 10px; line-height: 1.3; }

        .master-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .receipt-col { width: 50%; padding: 5px; vertical-align: top; }

        .receipt-box {
            border: 1px solid #ccc;
            overflow: hidden;
            position: relative;
            background: #fff;
            height: 540px;
        }

        /* WATERMARK */
        .watermark {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%) rotate(-40deg);
            z-index: 0;
            opacity: 0.08;
        }
        .watermark img { width: 220px; height: auto; }

        .body-wrap { position: relative; z-index: 1; }

        /* ======= FIXED COMPACT HEADER DESIGN ======= */
        .hdr-container {
            width: 100%;
            height: 80px;
            background: #f37920; /* Base background orange */
            position: relative;
        }

        .hdr-left-navy {
            position: absolute;
            top: 0;
            left: 0;
            width: 60%; /* Controls where the slope starts */
            height: 80px;
            background: #2B3547;
            z-index: 2;
        }

        /* The master triangle connector */
        .hdr-slope-svg {
            position: absolute;
            top: 0;
            left: 60%;
            width: 40px;
            height: 80px;
            z-index: 2;
        }

        /* Text positioning inside the navy container */
        .hdr-content-table {
            width: 100%;
            height: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .hdr-orange-right {
            position: absolute;
            top: 0;
            right: 0;
            margin-top: -10px;
            width: 40%;
            height: 80px;
            text-align: right;
            z-index: 1;
            margin-right: 10px;
        }

        .school-name { color: #f37920; font-size: 12px; font-weight: bold; text-transform: uppercase; margin: 0 0 2px 0; }
        .copy-badge { color: #a8c8e8; font-size: 9px; text-transform: uppercase; margin: 0; }
        .invoice-title { 
            color: #2B3547; font-size: 20px; font-weight: 700; letter-spacing: 2px; display: inline-block; vertical-align: end; line-height: 70px; text-align:right; margin-top: -15px }

        /* ======= ADDRESS BAR WITH GOLD SHADOW ======= */
        .addr-container {
            position: relative;
            margin-top: -17px;
            width: 100%;

            z-index: 1;
            vertical-align: end;
        }

        /* নতুন টেবিল স্টাইল: অ্যাড্রেসকে INVOICE এর নিচে সমানভাবে এলাইন করার জন্য */
        
        .addr-text-box-right {
            padding: 6px 0;
            font-size: 9px;
            color: #444;
            line-height: 1.2;
            text-align: right; /* বামে এলাইন থাকবে কিন্তু কলামটি থাকবে ইনভয়েসের নিচে */
        }
        .addr-text-box-right b { color: #2B3547; }

        /* ======= INFO SECTION ======= */
        .info-section { padding: 8px 10px; }
        .label-tag {
            background: #f37920;
            color: #fff;
            padding: 3px 7px;
            font-size: 10px;
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
            width: fit-content;
            
        }
        .student-name { color: #f37920; font-size: 13px; font-weight: bold; margin: 0 0 4px 0; }
        .info-text { font-size: 10px; line-height: 1.5; color: #333; }

        /* ======= FEE TABLE ======= */
        .fee-table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 10px; }
        .fee-table th { background: #2B3547; color: #fff; padding: 5px 7px; text-align: left; border: 1px solid #2B3547; }
        .fee-table td { padding: 4px 7px; border: 1px solid #ddd; }
        .fee-table .c { text-align: center; }
        .fee-table .r { text-align: right; }

        /* ======= IN WORDS ======= */
        .inwords { padding: 6px 10px 0; }
        .inwords-text { font-style: italic; font-size: 10px; color: #555; margin-top: 3px; }

        /* ======= FOOTER ======= */
        .footer-row { width: 100%; border-collapse: collapse; margin-top: 18px; padding: 0 10px; }
        .sig-line { border-top: 1px solid #555; display: inline-block; padding-top: 3px; font-size: 10px; font-weight: bold; width: 120px; text-align: center; }

        /* ======= BOTTOM BAR ======= */
        .bottom-bar {
            background: #2B3547; color: #fff; text-align: center;
            padding: 5px; font-size: 9px;
            position: absolute; bottom: 0; left: 0; width: 100%;
        }
    </style>
</head>
<body>
@php
    $firstFee = $fees->first();
@endphp

<table class="master-table">
    <tr>
        @foreach(['OFFICE COPY', 'STUDENT COPY'] as $copyType)
        <td class="receipt-col">
            <div class="receipt-box">

                <div class="watermark">
                    <img src="{{ asset($schoolLogo) }}" alt="Logo"> 
                </div>

                <div class="body-wrap">

                    <div class="hdr-container">
                        <div class="hdr-left-navy">
                            <table class="hdr-content-table">
                                <tr>
                                    <td style="width:52px; vertical-align:middle; padding-left:12px;">
                                        <img src="{{ asset($schoolLogo) }}" alt="Logo" style="width:46px; height:46px; border-radius:50%; padding:2px;">
                                    </td>
                                    <td style="vertical-align:middle; padding-left:8px;">
                                        <div class="school-name">{{ $school->name }}</div>
                                        <div class="copy-badge">{{ $copyType }}</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <svg class="hdr-slope-svg" viewBox="0 0 40 75" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="0,0 40,0 0,75" fill="#2B3547"/>
                        </svg>

                        <div class="hdr-orange-right">
                            <div class="invoice-title">INVOICE</div>
                            <div class="addr-container">
                                <div class="addr-text-box-right">
                                    <b>Address:</b> {{ $school->address ?? '' }} <br>
                                    <b>Phone:</b> {{ $school->phone ?? '' }} <br>
                                    <b>Email:</b> {{ $school->email ?? '' }}
                                </div>
                                        
                            </div>
                        </div>
                    </div>


                    <div class="info-section">
                        <table style="width:100%; border-collapse:collapse;">
                            <tr>
                                <td style="width:50%; vertical-align:top; padding-right:8px;">
                                    <div class="label-tag">Receipt To</div>
                                    <div class="student-name">{{ $student->name }}</div>
                                    <div class="info-text">
                                        <b>Phone :</b> {{ $student->contact_number }}<br>
                                        <b>Student ID :</b> {{ $student->student_id }}<br>
                                        <b>Class :</b> {{ $student->class->name }}&nbsp;|&nbsp;<b>Roll :</b> {{ $student->roll }}
                                    </div>
                                </td>
                                <td style="width:50%; vertical-align:top; padding-left:8px;">
                                    <div class="label-tag" >Receipt No : {{ $receiptNo }}</div>
                                    <div class="info-text" style="margin-bottom:8px; padding-left:2px;">
                                        <b>Receipt Date :</b> {{ date('d/m/Y') }}
                                    </div>
                                    <div class="label-tag">Payment Method</div>
                                    <div class="info-text">
                                        <b>Method:</b> {{ ucfirst($firstFee->payment_method ?? 'Cash') }}<br>
                                        <b>Collected By:</b> {{ $firstFee->collector->name ?? 'Admin' }}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table class="fee-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th class="c" style="width:22%;">Month</th>
                                    <th class="r" style="width:25%;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalAmount = 0; @endphp
                                @foreach($fees as $f)
                                <tr>
                                    <td>{{ $f->feeHead->name }}</td>
                                    <td class="c">{{ $f->month }}</td>
                                    <td class="r">Tk {{ number_format($f->amount, 2) }}</td>
                                </tr>
                                @php $totalAmount += $f->amount; @endphp
                                @endforeach
                                <tr>
                                    <td colspan="2" class="r" style="font-weight:bold;">Sub Total :</td>
                                    <td class="r">Tk {{ number_format($totalAmount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="r" style="font-weight:bold; font-size:11px;">Grand Total :</td>
                                    <td class="r" style="font-weight:bold; font-size:11px; color:#2B3547;">Tk {{ number_format($totalAmount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="inwords">
                        <span class="label-tag" style="display:inline-block; width:auto;">In Words</span>
                        <div class="inwords-text">{{ ucfirst($amountInWords) }} Only</div>
                    </div>

                    <table class="footer-row">
                        <tr>
                            <td style="font-size:10px; font-weight:bold; color:#444; vertical-align:bottom;">Thanks For Your Payment</td>
                            <td style="text-align:right; vertical-align:bottom;">
                                <div class="sig-line">Authorize Signature</div>
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="bottom-bar">
                    {{ $school->name }} &nbsp;|&nbsp; This Receipt is generated by Educorexa 1.0.0
                </div>

            </div>
        </td>
        @endforeach
    </tr>
</table>

</body>
</html>