<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admission Form</title>
<style>
    @page { size: A4; margin: 10mm; }
    body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 13px; color: #000; line-height: 1.4; }
    .pdf-container { width: 100%; max-width: 210mm; margin: 0 auto; }
    
    /* Header Table */
    .header-table { width: 100%; margin-bottom: 15px; background-color: #d1f2eb; border: 2px solid #3498db; }
    .header-table td { padding: 10px; vertical-align: middle; text-align: center; }
    .logo-td { width: 15%; }
    .text-td { width: 70%; }
    .photo-td { width: 15%; }
    
    .header-table h1 { margin: 0; font-size: 20px; font-weight: bold; text-transform: uppercase; color: #2980b9; }
    .header-table p { margin: 2px 0; font-size: 12px; }
    
    .photo-box { border: 1px solid #333; width: 100px; height: 100px; margin: 0 auto; background: #fff; text-align: center; }
    .photo-box-text { display: block; margin-top: 35px; font-size: 10px; }
    .photo-box img { width: 100px; height: 100px; }
    
    /* Info Row Table */
    .info-table { width: 100%; margin-bottom: 15px; font-weight: bold; }
    .info-table td { vertical-align: middle; }
    .box-info { border: 2px solid #3498db; padding: 4px 10px; border-radius: 5px; display: inline-block;}
    .badge { background-color: #a3e4d7; border: 2px solid #27ae60; padding: 6px 20px; text-align: center; font-weight: bold; display: inline-block;}
    
    /* Field Table */
    .field-table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
    .field-table td { padding: 2px 0; vertical-align: bottom; }
    .label-td { white-space: nowrap; font-weight: normal; width: 1%; }
    .value-td { border-bottom: 1px dashed #333; font-weight: bold; padding-left: 5px; padding-bottom: 2px; margin-left:5px}
    
    .section-title-wrapper { text-align: center; margin: 15px 0; }
    .section-title { background-color: #a3e4d7; border: 1px solid #27ae60; padding: 4px 20px; font-weight: bold; display: inline-block; }
    
    /* Signature Table */
    .sig-table { width: 100%; margin-top: 40px; margin-bottom: 20px; }
    .sig-table td { width: 50%; vertical-align: bottom; }
    .sig-line { border-top: 1px solid #000; width: 150px; text-align: center; padding-top: 5px; font-size: 12px; }
    
    /* Cut Line */
    .cut-line { border-top: 1px dashed #000; margin: 30px 0 50px 0; text-align: center; position: relative; }
    .cut-line-text { background: #fff; position: relative; top: -10px; padding: 0 10px; font-size: 16px; }
    
    /* Admit Card Photo/QR */
    .qr-box {  width: 70px; height: 70px; margin: 0 auto; background: #fff; }
    .qr-box img { width: 70px; height: 70px; }
    
    /* Watermark */
    .watermark { position: absolute; left: 0; width: 100%; text-align: center; opacity: 0.08; z-index: -1; }
    .watermark-form { top: 250px; }
    .watermark-admit { top: 780px; }
</style>
</head>
<body>
<div class="pdf-container">
    
    @if(isset($school->logo))
        <!-- Watermark for Form -->
        <div class="watermark watermark-form">
            <img src="{{ public_path($school->logo) }}" style="width: 350px; height: 350px; border-radius: 50%;">
        </div>
        <!-- Watermark for Admit Card -->
        <div class="watermark watermark-admit">
            <img src="{{ public_path($school->logo) }}" style="width: 250px; height: 250px; border-radius: 50%;">
        </div>
    @endif
    
    <!-- ADMISSION FORM -->
    <table class="header-table">
        <tr>
            <td class="logo-td">
                @if(isset($school->logo))
                    <img src="{{ public_path($school->logo) }}" style="width: 70px; height: 70px; border-radius: 50%;">
                @else
                    <div style="width:70px; height:70px; border-radius:50%; background:#fff; border:1px solid #000; display:inline-block; line-height:70px;">Logo</div>
                @endif
            </td>
            <td class="text-td">
                <h1>{{ $school->name ?? 'SCHOOL NAME' }}</h1>
                <p>{{ $school->address ?? 'School Address' }}</p>
                <p>Phone: {{ $school->contact_number ?? '' }}</p>
            </td>
            <td class="photo-td">
                <div class="photo-box">
                    @if($admission->photo)
                        <img src="{{ public_path($admission->photo) }}" alt="Photo">
                    @else
                        <span class="photo-box-text">Passport<br>Size Photo</span>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td style="width: 30%; text-align: left;">
                <span class="box-info">Form No: {{ $admission->admission_number }}</span>
            </td>
            <td style="width: 40%; text-align: center;">
                <span class="badge">ADMISSION FORM</span>
            </td>
            <td style="width: 30%; text-align: right;">
                <span class="box-info">Date: {{ \Carbon\Carbon::parse($admission->created_at)->format('d/m/Y') }}</span>
            </td>
        </tr>
    </table>

    <table class="field-table">
        <tr>
            <td class="label-td">1. Student's Name:&nbsp;&nbsp;</td>
            <td class="value-td">{{ strtoupper($admission->name) }}</td>
        </tr>
    </table>
    
    <table class="field-table">
        <tr>
            <td class="label-td">2. Father's Name:&nbsp;&nbsp;</td>
            <td class="value-td" style="width: 45%;">{{ strtoupper($admission->fathers_name) }}</td>
            <td class="label-td" style="padding-left: 15px;">3. Mother's Name:&nbsp;&nbsp;</td>
            <td class="value-td">{{ strtoupper($admission->mothers_name) }}</td>
        </tr>
    </table>

    <table class="field-table">
        <tr>
            <td class="label-td">4. Class to Admit:&nbsp;&nbsp;</td>
            <td class="value-td" style="width: 45%;">{{ $admission->class->name ?? '' }}</td>
            <td class="label-td" style="padding-left: 15px;">5. Contact No:&nbsp;&nbsp;</td>
            <td class="value-td">{{ $admission->contact_number }}</td>
        </tr>
    </table>

    <table class="field-table">
        <tr>
            <td class="label-td">6. Email Address:&nbsp;&nbsp;</td>
            <td class="value-td">{{ $admission->email }}</td>
        </tr>
    </table>

    <table class="field-table">
        <tr>
            <td class="label-td">7. Date of Birth:&nbsp;&nbsp;</td>
            <td class="value-td" style="width: 45%;"></td>
            <td class="label-td" style="padding-left: 15px;">8. Religion:&nbsp;&nbsp;</td>
            <td class="value-td"></td>
        </tr>
    </table>

    <table class="field-table">
        <tr>
            <td class="label-td">9. Present Address:&nbsp;&nbsp;</td>
            <td class="value-td"></td>
        </tr>
    </table>

    <table class="field-table">
        <tr>
            <td class="label-td">10. Permanent Address:&nbsp;&nbsp;</td>
            <td class="value-td"></td>
        </tr>
    </table>

    <div class="section-title-wrapper">
        <span class="section-title">DECLARATION</span>
    </div>
    <p style="font-size: 11px; text-align: justify; margin: 0; line-height: 1.4;">
        I do hereby declare that all the information provided above is true. I promise to abide by all the rules and regulations of the school. If my child/ward violates any discipline, I will have no objection to any necessary disciplinary action taken by the school authority.
    </p>

    <table class="sig-table">
        <tr>
            <td style="text-align: left;">
                <div class="sig-line">Student's Signature</div>
            </td>
            <td style="text-align: right;">
                <div class="sig-line" style="float: right;">Guardian's Signature</div>
            </td>
        </tr>
    </table>

    <!-- CUT LINE -->
    <div class="cut-line">
        <span class="cut-line-text">- - - - - - - - - - - - - - - - Cut Here - - - - - - - - - - - - - - - -</span>
    </div>

    <!-- ADMIT CARD -->
    <table class="header-table" style="padding: 5px; margin-bottom: 10px;">
        <tr>
            <td class="logo-td">
                @if(isset($school->logo))
                    <img src="{{ public_path($school->logo) }}" style="width: 50px; height: 50px; border-radius: 50%;">
                @else
                    <div style="width:50px; height:50px; border-radius:50%; background:#fff; border:1px solid #000; display:inline-block; line-height:50px;">Logo</div>
                @endif
            </td>
            <td class="text-td">
                <h1 style="font-size: 16px;">{{ $school->name ?? 'SCHOOL NAME' }}</h1>
                <p style="font-size: 11px;">{{ $school->address ?? 'School Address' }}</p>
            </td>
            <td class="photo-td">
                <div class="qr-box">
                    <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
                </div>
            </td>
        </tr>
    </table>

    <table class="info-table" style="margin-bottom: 10px;">
        <tr>
            <td style="width: 30%; text-align: left;">
                <span class="box-info">Form No: {{ $admission->admission_number }}</span>
            </td>
            <td style="width: 40%; text-align: center;">
                <span class="badge">ADMIT CARD</span>
            </td>
            <td style="width: 30%; text-align: right;">
                <span class="box-info">Date: {{ \Carbon\Carbon::parse($admission->created_at)->format('d/m/Y') }}</span>
            </td>
        </tr>
    </table>

    <table class="field-table">
        <tr>
            <td class="label-td">Student's Name:&nbsp;&nbsp;</td>
            <td class="value-td" style="width: 50%;">{{ strtoupper($admission->name) }}</td>
            <td class="label-td" style="padding-left: 15px;">Class:&nbsp;&nbsp;</td>
            <td class="value-td">{{ $admission->class->name ?? '' }}</td>
        </tr>
    </table>

    <table class="field-table">
        <tr>
            <td class="label-td">Father's Name:&nbsp;&nbsp;</td>
            <td class="value-td" style="width: 50%;">{{ strtoupper($admission->fathers_name) }}</td>
            <td class="label-td" style="padding-left: 15px;">Exam Date:&nbsp;&nbsp;</td>
            <td class="value-td"></td>
        </tr>
    </table>

    <table class="sig-table" style="margin-top: 60px; margin-bottom: 0;">
        <tr>
            <td style="text-align: left;">
                <div class="sig-line" style="visibility: hidden;">Student's Signature</div>
            </td>
            <td style="text-align: right;">
                <div class="sig-line" style="float: right;">Headmaster's Signature</div>
            </td>
        </tr>
    </table>

</div>
</body>
</html>


