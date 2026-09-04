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
                    <i class="fa-solid fa-pen-to-square text-white" style="font-size:20px;"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1">{{ __('Edit Fee Head (ফি খাত সম্পাদনা)') }}</h4>
                    <p class="mb-0" style="color:rgba(255,255,255,0.8);font-size:13px;">
                        {{ __('Update the fee category title or change its billing frequency') }}
                    </p>
                </div>
            </div>
            <a href="{{ route('fee-heads.index', ['tenant' => auth()->user()->school->slug]) }}" 
               class="btn" style="background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);color:#fff;border:1px solid rgba(255,255,255,0.4);border-radius:12px;font-weight:600;padding:9px 18px;font-size:13px;">
                <i class="fa-solid fa-arrow-left me-1"></i> {{ __('Back to Fee Heads') }}
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- ── Left: Edit Fee Head Form ── --}}
        <div class="col-lg-4">
            <div class="panel-modern h-100">
                <div class="panel-header-modern">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:32px;height:32px;border-radius:8px;background:#fef3c7;color:#d97706;display:flex;align-items:center;justify-content:center;font-size:14px;">
                            <i class="fa-solid fa-pen"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">{{ __('Update Fee Head') }}</h6>
                    </div>
                </div>
                <div class="p-4">
                    <form action="{{ route('fee-heads.update', ['tenant' => auth()->user()->school->slug, 'fee_head' => $fee_head->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-dark small">{{ __('Fee Head Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg fs-14" id="name" name="name" 
                                   placeholder="e.g. Admission Fee" value="{{ $fee_head->name }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="type" class="form-label fw-bold text-dark small">{{ __('Billing Frequency') }} <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg fs-14" id="type" name="type" required>
                                <option value="" disabled>{{ __('Select billing frequency') }}</option>
                                <option value="monthly" {{ $fee_head->type == 'monthly' ? 'selected' : '' }}>📅 {{ __('Monthly (Every Month)') }}</option>
                                <option value="once" {{ $fee_head->type == 'once' ? 'selected' : '' }}>🎯 {{ __('Once (One-time payment)') }}</option>
                                <option value="recurring" {{ $fee_head->type == 'recurring' ? 'selected' : '' }}>🔄 {{ __('Recurring (Periodic / Termly)') }}</option>
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('fee-heads.index', ['tenant' => auth()->user()->school->slug]) }}" 
                               class="btn btn-light w-50 py-2 fw-semibold" style="border-radius:12px;">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary w-50 py-2 fw-bold" style="border-radius:12px;">
                                <i class="fa-solid fa-check me-1"></i> {{ __('Update') }}
                            </button>
                        </div>
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
                            @foreach($feeHeads as $head)
                            <tr style="border-bottom:1px solid #f8fafc;" class="{{ $head->id == $fee_head->id ? 'table-primary-subtle' : '' }}">
                                <td class="ps-4 text-muted fw-bold">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold text-dark fs-14">
                                        {{ $head->name }}
                                        @if($head->id == $fee_head->id)
                                            <span class="badge bg-warning text-dark ms-1" style="font-size:10px;">{{ __('Editing') }}</span>
                                        @endif
                                    </div>
                                    <small class="text-muted" style="font-size:11px;">Created {{ $head->created_at ? $head->created_at->format('d M, Y') : '—' }}</small>
                                </td>
                                <td>
                                    <span class="fee-type-pill type-{{ $head->type }}">
                                        @if($head->type == 'monthly')
                                            <i class="fa-regular fa-calendar-days"></i> {{ __('Monthly') }}
                                        @elseif($head->type == 'once')
                                            <i class="fa-solid fa-check-double"></i> {{ __('One Time') }}
                                        @else
                                            <i class="fa-solid fa-repeat"></i> {{ __('Recurring') }}
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('fee-heads.edit', ['tenant' => auth()->user()->school->slug, 'fee_head' => $head->id]) }}"
                                           class="btn-action-edit {{ $head->id == $fee_head->id ? 'active' : '' }}" title="{{ __('Edit Fee Head') }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('fee-heads.destroy', ['tenant' => auth()->user()->school->slug, 'fee_head' => $head->id]) }}"
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
                            @endforeach
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