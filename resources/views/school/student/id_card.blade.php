<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Final ID Card - {{ $student->name }}</title>
    <style>
        /* A4 Page Setup */
        @page {
            size: A4;
            margin: 0.5in;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f0f0f0;
        }

        /* Container for side by side cards */
        .print-wrapper {
            display: flex;
            justify-content: center;
            gap: 8px;
            /* Space between front and back */
            padding: 20px;
        }

        /* Standard ID Card Size (CR80) */
        .card-container {
            width: 2.125in;
            height: 3.375in;
            background: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border: 0.5px solid #ddd;
            border-radius: 8px;
        }

        /* --- FRONT SIDE DESIGN --- */
        .name-badge {
            justify-content: center;
            text-align: center;
            position: relative;
            margin: 0 5px;
            padding: 2px 5px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .name {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            margin: 0 5px;
            text-transform: uppercase;
            border-radius: 10px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
            font-size: 10px;
            padding: 3px 8px;
            font-weight: bold;
            color: #f0f0f0;

            z-index: 2;
        }

    .dot-pattern { position: absolute; width: 100%; height: 100%; background-image: radial-gradient(rgba(106, 27, 154, 0.1) 1.5px, transparent 1.5px); background-size: 10px 10px; z-index: 0; }
    .top-header-shape { position: absolute; top: 0; left: 0; width: 100%; height: 140px; background: linear-gradient(135deg, #6a1b9a 0%, #ad1457 100%); clip-path: polygon(0 0, 100% 0, 100% 70%, 85% 75%, 75% 85%, 50% 100%, 25% 85%, 15% 75%, 0 70%); z-index: 1; }
    .header-content { position: relative; z-index: 3; text-align: center; color: white; padding-top: 10px; margin: 1px 10px;}
    .school-logo { width: 32px; margin-bottom: 2px; }
    .photo-border { position: absolute; top: 85px; left: 50%; transform: translateX(-50%); width: 75px; height: 75px; background: white; border-radius: 50%; padding: 3px; z-index: 3; border: 2px solid #6a1b9a; }
    .photo-border img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
    .details { position: absolute; top: 175px; width: 100%; padding: 0 12px; box-sizing: border-box; z-index: 2; }
    .row-info { display: flex; font-size: 10px; }
    .label { width: 42%; font-weight: bold; color: #6a1b9a; }
    .val { width: 58%; color: #000; font-weight: bold; }
    .front-signature { position: absolute; bottom: 20px; right: 15px; text-align: center; z-index: 2; }
    .front-signature img { width: 35px; margin-bottom: -10px; }
    .front-signature p { margin: 0; font-size: 6px; font-weight: bold; border-top: 0.5px solid #333; }
    .back-top-bar { width: 100%; height: 25px; background: linear-gradient(90deg, #6a1b9a, #ad1457); }
    .back-header { margin: 8px auto; width: 85%; background: rgba(106, 27, 154, 0.1); color: #6a1b9a; text-align: center; font-size: 8px; font-weight: bold; padding: 3px 0; border-radius: 3px; }
    .school-info-section { margin-top: 8px; padding: 0 15px; font-size: 9px; color: #333; line-height: 1.2;}
    .qr-section { text-align: center; margin-top: 10px; }
    .bottom-bar { position: absolute; bottom: 0; width: 100%; height: 10px; background: linear-gradient(90deg, #6a1b9a, #ad1457); }

        /* Print Settings */
        @media print {
            body {
                background: none;
            }

            .no-print {
                display: none;
            }

            .print-wrapper {
                padding: 0;
                margin-top: 0.5in;
            }

            .card-container {
                box-shadow: none;
                border: 1px solid #eee;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="text-align: center; padding: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #6a1b9a; color: white; border: none; cursor: pointer; border-radius: 5px; font-weight: bold;">
            PRINT ID CARD
        </button>
    </div>

    <div class="print-wrapper">
                <div class="card-container">
                    <div class="dot-pattern"></div>
                    <div class="top-header-shape"></div>
                    <div class="header-content">
                        <img src="{{ asset('assets/images/logo.png') }}" class="school-logo">
                        <h1 style="font-size: 13px; margin-top: -3px; text-transform:uppercase">{{ $student->school->name }}</h1>
                    </div>
                    <div class="photo-border">
                        <img src="{{ asset($student->photo) }}">
                    </div>
                    <div class="details">
                        <div class="row-info name-badge"><span class="name"> {{ $student->name }}</span></div>
                        <div class="row-info"><span class="label">Student ID</span><span class="val">:
                                {{ $student->student_id }}</span></div>
                        <div class="row-info"><span class="label">Guardians</span><span class="val">:
                                {{ $student->fathers_name }}</span></div>
                        <div class="row-info"><span class="label">Class</span><span class="val">: {{ $student->class->name }}</span>
                        </div>
                        <div class="row-info"><span class="label">Blood Group</span><span class="val">:
                                {{ $student->blood_group }}</span></div>
                        <div class="row-info"><span class="label">Emergency</span><span class="val">:
                                {{ $student->contact_number }}</span></div>
                    </div>
                    <div class="front-signature">
                        <img src="{{ asset('assets/images/signature.png') }}" alt="Sign">
                        <p>Principal</p>
                    </div>
                    <div class="bottom-bar"></div>
                </div>

                <div class="card-container">
                    <div class="dot-pattern"></div>
                        <div class="back-top-bar"
                            style="width: 100%; height: 25px; background: linear-gradient(90deg, #6a1b9a, #ad1457);"></div>

                        <div class="back-header"
                            style="margin: 12px auto; width: 85%; background: rgba(106, 27, 154, 0.3); color: #6a1b9a; text-align: center; font-size: 9px; font-weight: bold; padding: 4px 0; border-radius: 3px;">
                            TERMS AND CONDITIONS
                        </div>

                        <div class="terms-text" style="padding: 0 15px; font-size: 9px; color: #343232; line-height: 1;">
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <li style="margin-bottom: 3px;">• This card is the property of
                                    <strong>{{ $student->school->name }}</strong>.</li>
                                <li>• If found, please return to the school office immediately.</li>
                            </ul>
                        </div>

                        <div class="school-info-section" style="margin-top: 15px; padding: 0 20px; font-size: 9px; color: #333;">
                            <div style="margin-bottom: 2px; display: flex; align-items: center;">
                                <strong style="color: #6a1b9a; width: 45px;">Phone</strong> <span>:
                                    {{ $student->school->phone ?? '01XXX-XXXXXX' }}</span>
                            </div>
                            <div style="margin-bottom: 2px; display: flex; align-items: center;">
                                <strong style="color: #6a1b9a; width: 45px;">Email</strong> <span>: {{ $student->school->email ??
                                    'info@school.com' }}</span>
                            </div>
                            <div style="margin-bottom: 2px; display: flex; align-items: center;">
                                <strong style="color: #6a1b9a; width: 45px;">Website</strong> <span>:
                                    {{ $student->school->website ?? 'www.school.com' }}</span>
                            </div>
                            <div style="display: flex; align-items: flex-start;">
                                <strong style="color: #6a1b9a; width: 45px;">Address</strong>
                                <span style="width: 110px;">: {{ $student->school->address ?? 'Your School Address Here' }}</span>
                            </div>
                        </div>

                        <div class="qr-section" style="text-align: center; margin-top: 12px;">
                            <div style="display: inline-block; padding: 4px; border: 1px solid #eee; background: white;">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->color(106, 27, 154)->generate($student->student_id) !!}
                            </div>
                            <div style="font-size: 7px; margin-top: 4px; font-weight: bold; color: #6a1b9a;">
                                {{ $student->student_id }}</div>
                        </div>

                        <div class="bottom-bar"
                            style="position: absolute; bottom: 0; width: 100%; height: 12px; background: linear-gradient(90deg, #6a1b9a, #ad1457);">
                        </div>
                </div>
            </div>

</body>

</html>