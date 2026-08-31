@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .modal-dropzone {
            border: 2px dashed #818cf8;
            border-radius: 16px;
            background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 100%);
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            user-select: none;
        }
        .modal-dropzone:hover, .modal-dropzone.dz-over {
            border-color: #4f46e5;
            background: linear-gradient(135deg, #e0e7ff 0%, #eef2ff 100%);
            box-shadow: 0 8px 25px rgba(79,70,229,0.15);
        }
        .modal-dropzone.dz-selected {
            border-color: #4f46e5;
            border-style: solid;
            background: linear-gradient(135deg, #e0e7ff 0%, #eef2ff 100%);
        }
        .modal-dz-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg,#4f46e5,#7c3aed);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: #fff;
            margin: 0 auto 12px;
            box-shadow: 0 6px 16px rgba(79,70,229,0.3);
            transition: transform 0.2s ease;
        }
        .modal-dropzone:hover .modal-dz-icon { transform: translateY(-4px); }
        .modal-dz-title { font-weight: 700; font-size: 16px; color: #3730a3; margin-bottom: 4px; }
        .modal-dz-sub   { font-size: 12.5px; color: #64748b; margin: 0; }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-header-outline {
            background: transparent !important;
            color: #ffffff !important;
            border: 1.5px solid rgba(255, 255, 255, 0.45) !important;
            font-weight: 600 !important;
            font-size: 0.78rem !important;
            height: 32px !important;
            padding: 0 12px !important;
            border-radius: 5px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            box-shadow: none !important;
        }
        .btn-header-outline:hover {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: #ffffff !important;
            color: #ffffff !important;
            box-shadow: none !important;
            transform: none !important;
        }
        .btn-header-solid {
            background: transparent !important;
            color: #ffffff !important;
            border: 1.5px solid #818cf8 !important;
            font-weight: 600 !important;
            font-size: 0.78rem !important;
            height: 32px !important;
            padding: 0 12px !important;
            border-radius: 5px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
            box-shadow: none !important;
            text-decoration: none !important;
        }
        .btn-header-solid:hover {
            background: rgba(129, 140, 248, 0.18) !important;
            border-color: #a5b4fc !important;
            color: #ffffff !important;
            box-shadow: none !important;
            transform: none !important;
        }

        @media (max-width: 576px) {
            .header-actions {
                width: 100%;
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 8px !important;
            }
            .btn-header-outline, .btn-header-solid {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="page-header-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="page-header-content d-flex align-items-center gap-3">
                <div class="header-icon-box">
                    <i class="fa-solid fa-file-excel"></i>
                </div>
                <div>
                    <h1 class="page-title fs-4 mb-1">{{ __('Student Bulk Import') }}</h1>
                    <p class="page-subtitle mb-0 small" style="color: rgba(255,255,255,0.75);">{{ __('Upload an Excel or CSV file to import students into your school records') }}</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('students.downloadTemplate', ['tenant' => auth()->user()?->school?->slug]) }}"
                   class="btn-header-outline">
                    <i class="fa-solid fa-download me-1.5"></i> {{ __('Download Template') }}
                </a>
                <a href="{{ route('students.index', ['tenant' => auth()->user()?->school?->slug]) }}"
                   class="btn-header-solid">
                    <i class="fa-solid fa-user-graduate me-1.5"></i> {{ __('Student List') }}
                </a>
            </div>
        </div>

        {{-- Import Form Card --}}
        <div class="form-card mb-4">
            <form action="{{ route('students.import', ['tenant' => auth()->user()?->school?->slug]) }}" method="POST" enctype="multipart/form-data" id="student_import_form">
                @csrf

                <div id="stu_standalone_dropzone"
                     class="modal-dropzone"
                     onclick="document.getElementById('stu_standalone_file').click();"
                     ondragover="event.preventDefault(); this.classList.add('dz-over');"
                     ondragleave="this.classList.remove('dz-over');">
                    <div id="stu_standalone_dz_icon" class="modal-dz-icon">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <p class="modal-dz-title" id="stu_standalone_label">{{ __('Click or drag Excel/CSV file here to upload') }}</p>
                    <p class="modal-dz-sub">{{ __('Supports .xlsx, .xls, .csv files up to 5 MB') }}</p>
                    <input type="file" name="file" id="stu_standalone_file"
                           accept=".xlsx,.xls,.csv" class="d-none" required
                           onchange="previewStandaloneStuFile(this);">
                </div>

                {{-- Column Guide --}}
                <div class="mt-4 p-3 rounded-3 small" style="background:#f8fafc; border:1px solid #e2e8f0;">
                    <p class="fw-bold mb-2 text-dark">
                        <i class="fa-solid fa-circle-info me-1 text-primary"></i>{{ __('Required Columns Guide:') }}
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        @foreach(['class_code *','name *','group / sub_category','section','roll','fathers_name','mothers_name','contact_number','date_of_birth','gender','religion','blood_group','address'] as $col)
                            <span class="badge rounded-pill fw-normal px-2 py-1"
                                  style="background:{{ str_contains($col,'*') ? '#4f46e5' : '#64748b' }};color:#fff;font-size:11px;">
                                {{ $col }}
                            </span>
                        @endforeach
                    </div>
                    <p class="text-muted mb-0" style="font-size:11.5px;">
                        <span class="text-primary fw-bold">*</span> বাধ্যতামূলক কলাম &nbsp;|&nbsp;
                        <span class="fw-semibold">class_code</span> কলামে ক্লাস কোড (যেমন: 01, 06) বা নাম (যেমন: Six, Nine) &nbsp;|&nbsp;
                        <span class="fw-semibold">group</span> কলামে গ্রুপের নাম (যেমন: Science, Humanities) বা ID &nbsp;|&nbsp;
                        <span class="fw-semibold">section</span> কলামে সেকশনের <em>নাম</em> (যেমন: A, B, Padma) &nbsp;|&nbsp;
                        Default Password: <span class="badge bg-primary">12345678</span>
                    </p>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('students.index', ['tenant' => auth()->user()?->school?->slug]) }}"
                       class="btn btn-light rounded-pill px-4">{{ __('Cancel') }}</a>
                    <button type="submit" id="stu_import_submit_btn" class="btn btn-primary-modern rounded-pill px-5">
                        <i class="fa-solid fa-file-import me-1"></i> {{ __('Start Import') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Per-row Error Report --}}
        @if(session('import_errors') && count(session('import_errors')) > 0)
        <div class="form-card mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#ef4444,#dc2626);
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-triangle-exclamation text-white" style="font-size:15px;"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-danger">{{ __('Import Issue Report') }}</h6>
                    <small class="text-muted">{{ count(session('import_errors')) }} {{ __('rows had issues') }}</small>
                </div>
            </div>

            <div style="max-height:320px;overflow-y:auto;border:1px solid #fee2e2;border-radius:10px;">
                <table class="table table-sm mb-0" style="font-size:13px;">
                    <thead style="background:#fef2f2;position:sticky;top:0;z-index:1;">
                        <tr>
                            <th style="width:50px;color:#dc2626;padding:8px 12px;">#</th>
                            <th style="color:#dc2626;padding:8px 12px;">{{ __('Issue Details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('import_errors') as $i => $err)
                        <tr style="border-bottom:1px solid #fee2e2;">
                            <td style="padding:7px 12px;color:#6b7280;">{{ $i + 1 }}</td>
                            <td style="padding:7px 12px;color:#374151;">{{ $err }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(session('import_success_count'))
            <div class="mt-3 p-2 rounded-3 small d-flex align-items-center gap-2"
                 style="background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;">
                <i class="fa-solid fa-circle-check"></i>
                <span>
                    {{ session('import_success_count') }} {{ __('students imported successfully.') }}
                    {{ session('import_skip_count', 0) }} {{ __('rows skipped.') }}
                </span>
            </div>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection

@section('customJs')
<script>
    function previewStandaloneStuFile(input) {
        const file = input.files[0];
        const label = document.getElementById('stu_standalone_label');
        const icon  = document.getElementById('stu_standalone_dz_icon');

        if (!file) return;

        const allowed = ['xlsx', 'xls', 'csv'];
        const ext = file.name.split('.').pop().toLowerCase();

        if (!allowed.includes(ext)) {
            label.textContent = "❌ {{ __('Invalid file format! Please select .xlsx, .xls or .csv') }}";
            label.style.color = '#ef4444';
            return;
        }

        const size = file.size < 1024 * 1024
            ? (file.size / 1024).toFixed(1) + ' KB'
            : (file.size / (1024 * 1024)).toFixed(2) + ' MB';

        label.innerHTML = `<i class="fa-solid fa-file-excel me-2" style="color:#4f46e5;"></i><strong>${file.name}</strong> <span style="color:#64748b;font-weight:400;">(${size})</span>`;
        label.style.color = '#3730a3';
        icon.innerHTML = '<i class="fa-solid fa-circle-check" style="color:#fff;font-size:1.6rem;"></i>';
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: "{{ __('Success') }}",
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: "{{ __('Partially Successful') }}",
            text: '{{ session('warning') }}',
            footer: "{{ __('See details in table below') }}",
        });
    @endif

    @if(session('error') && !session('import_errors'))
        Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: '{{ session('error') }}',
        });
    @endif
</script>
@endsection