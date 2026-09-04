@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        .feehead-hero {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #8b5cf6 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .feehead-hero::before {
            content:''; position:absolute; top:-40px; right:-40px;
            width:180px; height:180px; background:rgba(255,255,255,0.08); border-radius:50%;
        }
        .panel-modern {
            background: #ffffff;
            border-radius: 18px;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(15,23,42,0.05);
            overflow: hidden;
        }
        .panel-header-modern {
            padding: 18px 24px;
            background: #f8fafc;
            border-bottom: 1.5px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .fee-type-pill {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 11.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .type-monthly { background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; }
        .type-once { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .type-recurring { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }

        /* Action Buttons */
        .btn-action-edit {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #eff6ff;
            color: #2563eb !important;
            border: 1.5px solid #bfdbfe;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: all .2s ease;
            text-decoration: none;
        }
        .btn-action-edit:hover {
            background: #2563eb;
            color: #ffffff !important;
            border-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37,99,235,0.25);
        }

        .btn-action-delete {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #fef2f2;
            color: #ef4444 !important;
            border: 1.5px solid #fecaca;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: all .2s ease;
            cursor: pointer;
        }
        .btn-action-delete:hover {
            background: #ef4444;
            color: #ffffff !important;
            border-color: #ef4444;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239,68,68,0.25);
        }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ══ HERO HEADER ══ --}}
    <div class="feehead-hero">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3" style="position:relative;z-index:1;">
            <div class="d-flex align-items-center gap-3">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,0.3);">
                    <i class="fa-solid fa-list-check text-white" style="font-size:20px;"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1">{{ __('Fee Heads Management (ফি খাতসমূহ)') }}</h4>
                    <p class="mb-0" style="color:rgba(255,255,255,0.8);font-size:13px;">
                        {{ __('Define and manage academic fee heads (Tuition, Exam, Admission, etc.) and their billing frequency') }}
                    </p>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('fee-amounts.index', ['tenant' => auth()->user()->school->slug]) }}" 
                   class="btn" style="background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);color:#fff;border:1px solid rgba(255,255,255,0.4);border-radius:12px;font-weight:600;padding:9px 18px;font-size:13px;">
                    <i class="fa-solid fa-layer-group me-1"></i> {{ __('Fee Structure') }}
                </a>
                <a href="{{ route('student-fee-concessions.index', ['tenant' => auth()->user()->school->slug]) }}" 
                   class="btn" style="background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);color:#fff;border:1px solid rgba(255,255,255,0.4);border-radius:12px;font-weight:600;padding:9px 18px;font-size:13px;">
                    <i class="fa-solid fa-tags me-1"></i> {{ __('Fee Concessions') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- ── Left: Create Fee Head Form ── --}}
        <div class="col-lg-4">
            <div class="panel-modern h-100">
                <div class="panel-header-modern">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:32px;height:32px;border-radius:8px;background:#eef2ff;color:#4f46e5;display:flex;align-items:center;justify-content:center;font-size:14px;">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">{{ __('Create Fee Head') }}</h6>
                    </div>
                </div>
                <div class="p-4">
                    <form action="{{ route('fee-heads.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-dark small">{{ __('Fee Head Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg fs-14" id="name" name="name" placeholder="e.g. Tuition Fee / Exam Fee" required>
                            <small class="text-muted" style="font-size:11.5px;">Give a clear name for the fee category.</small>
                        </div>
                        <div class="mb-4">
                            <label for="type" class="form-label fw-bold text-dark small">{{ __('Billing Frequency') }} <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg fs-14" id="type" name="type" required>
                                <option value="" disabled selected>{{ __('Select billing frequency') }}</option>
                                <option value="monthly">📅 {{ __('Monthly (Every Month)') }}</option>
                                <option value="once">🎯 {{ __('Once (One-time payment)') }}</option>
                                <option value="recurring">🔄 {{ __('Recurring (Periodic / Termly)') }}</option>
                            </select>
                            <small class="text-muted" style="font-size:11.5px;">Select how often this fee is collected from students.</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius:12px;">
                            <i class="fa-solid fa-circle-plus me-1"></i> {{ __('Save Fee Head') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── Right: Defined Fee Heads Table ── --}}
        <div class="col-lg-8">
            <div class="panel-modern h-100">
                <div class="panel-header-modern">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:32px;height:32px;border-radius:8px;background:#f0fdf4;color:#16a34a;display:flex;align-items:center;justify-content:center;font-size:14px;">
                            <i class="fa-solid fa-list"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">{{ __('Defined Fee Heads') }}</h6>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2" style="border-radius:50px;font-size:12px;">
                        {{ $feeHeads->count() }} {{ __('Heads Defined') }}
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:13.5px;">
                        <thead style="background:#fafbfc;border-bottom:2px solid #f1f5f9;">
                            <tr>
                                <th class="ps-4 py-3 fw-bold text-uppercase" style="font-size:11px;color:#64748b;letter-spacing:.5px;width:60px;">#</th>
                                <th class="py-3 fw-bold text-uppercase" style="font-size:11px;color:#64748b;letter-spacing:.5px;">{{ __('Fee Head Name') }}</th>
                                <th class="py-3 fw-bold text-uppercase" style="font-size:11px;color:#64748b;letter-spacing:.5px;">{{ __('Billing Frequency') }}</th>
                                <th class="py-3 fw-bold text-uppercase text-center pe-4" style="font-size:11px;color:#64748b;letter-spacing:.5px;width:120px;">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feeHeads as $feeHead)
                            <tr style="border-bottom:1px solid #f8fafc;">
                                <td class="ps-4 text-muted fw-bold">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold text-dark fs-14">{{ $feeHead->name }}</div>
                                    <small class="text-muted" style="font-size:11px;">Created {{ $feeHead->created_at ? $feeHead->created_at->format('d M, Y') : '—' }}</small>
                                </td>
                                <td>
                                    <span class="fee-type-pill type-{{ $feeHead->type }}">
                                        @if($feeHead->type == 'monthly')
                                            <i class="fa-regular fa-calendar-days"></i> {{ __('Monthly') }}
                                        @elseif($feeHead->type == 'once')
                                            <i class="fa-solid fa-check-double"></i> {{ __('One Time') }}
                                        @else
                                            <i class="fa-solid fa-repeat"></i> {{ __('Recurring') }}
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('fee-heads.edit', ['tenant' => auth()->user()->school->slug, 'fee_head' => $feeHead->id]) }}"
                                           class="btn-action-edit" title="{{ __('Edit Fee Head') }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('fee-heads.destroy', ['tenant' => auth()->user()->school->slug, 'fee_head' => $feeHead->id]) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)"
                                                    class="btn-action-delete" title="{{ __('Delete Fee Head') }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <div style="width:54px;height:54px;background:#f8fafc;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                                        <i class="fa-regular fa-folder-open text-secondary fa-2x opacity-50"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">{{ __('No Fee Heads Defined Yet') }}</h6>
                                    <p class="small text-muted mb-0">{{ __('Create your first fee category from the left panel.') }}</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: '{{ __("Delete Fee Head?") }}',
            text: "{{ __('This will permanently delete this fee head and may affect fee amounts configuration!') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> {{ __("Yes, Delete") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            customClass: {
                confirmButton: 'rounded-pill px-4 py-2',
                cancelButton: 'rounded-pill px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: '{{ session('type', 'success') }}',
        title: '{{ session('type') == 'success' ? "Success!" : "Notice" }}',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif
    
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}'
    });
    @endif
</script>
@endsection