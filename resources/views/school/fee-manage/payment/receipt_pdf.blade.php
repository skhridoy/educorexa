<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 14px; }
        .invoice-box { border: 1px solid #eee; padding: 30px; max-width: 800px; margin: auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #333; }
        .table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .table th { background: #eee; border: 1px solid #ddd; padding: 8px; }
        .table td { border: 1px solid #ddd; padding: 8px; }
        .footer { margin-top: 50px; text-align: right; }
        .signature { border-top: 1px solid #000; display: inline-block; padding-top: 5px; }

       
   
        .taka-symbol {
            font-family: 'DejaVu Sans', sans-serif;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <h2>{{ $school->name }}</h2>
            <p>{{ $school->address }}<br>Contact: {{ $school->phone }}</p>
            <div style="margin: 10px auto; width: 200px;">
                <h4 style="background: #dac20b; padding: 5px 10px; color: white; border-radius: 10px; text-align: center; margin: 0;">
                    MONEY RECEIPT
                </h4>
            </div>
        </div>

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td><strong>Receipt No:</strong> #REC-{{ $fee->id }}</td>
                <td style="text-align: right;"><strong>Date:</strong> {{ date('d M, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Student Name:</strong> {{ $student->name }}</td>
                <td style="text-align: right;"><strong>Student ID:</strong> {{ $student->student_id }}</td>
            </tr>
            <tr>
                <td><strong>Class:</strong> {{ $student->class->name }}</td>
                <td style="text-align: right;"><strong>Month:</strong> {{ $fee->month }}</td>
            </tr>
            <tr>
                <td><strong>Payment Method:</strong> {{ ucfirst($fee->payment_method) }}</td>
                <td style="text-align: right;"><strong>Mobile:</strong> {{ $student->contact_number }}</td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $fee->feeHead->name }}</td>
                    <td style="text-align: right;">Tk {{ number_format($fee->amount, 2) }}</td>
                </tr>
    
                <tr>
                    <td style="text-align: right;"><strong>Total Paid:</strong></td>
                    <td style="text-align: right;"><strong>Tk {{ number_format($fee->amount, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <p style="margin-top: 20px;">
            <i>In Words: {{ ucfirst($amountInWords) }} Only.</i>
        </p>

        <div class="footer">
            <div class="signature">Accounts Signature</div>
        </div>
    </div>
</body>
</html>