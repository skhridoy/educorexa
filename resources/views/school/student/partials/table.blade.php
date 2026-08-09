@if($students->count() > 0)
    {{-- DESKTOP VIEW: Clean Table (Visible on Tablets & Laptops >= md) --}}
    <div class="table-responsive d-none d-md-block">
        <table class="table edu-table align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Student Info</th>
                    <th>ID & Roll</th>
                    <th>Class & Section</th>
                    <th>Contact & Guardian</th>
                    <th class="text-center pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}" 
                                 alt="{{ $student->name }}" class="student-avatar-ring">
                            <div>
                                <div class="fw-bold text-dark">{{ $student->name }}</div>
                                <div class="small">
                                    @if($student->status == 'active')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-0.5" style="font-size:10px;">Active</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-0.5" style="font-size:10px;">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="student-id-badge mb-1">{{ $student->student_id }}</span>
                        <div class="small fw-semibold text-muted">Roll: {{ $student->roll ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="small fw-bold text-primary mb-0.5">
                            <i class="fa-solid fa-graduation-cap me-1 opacity-75"></i>{{ $student->class?->name ?? 'N/A' }}
                        </div>
                        <div class="small text-muted">
                            Sec: {{ $student->section?->name ?? 'N/A' }} {{ $student->group?->name ? '('.$student->group->name.')' : '' }}
                        </div>
                    </td>
                    <td>
                        @if($student->contact_number)
                            <div class="small mb-1"><a href="tel:{{ $student->contact_number }}" class="text-secondary text-decoration-none"><i class="fa-solid fa-phone me-1 text-success"></i> {{ $student->contact_number }}</a></div>
                        @endif
                        <div class="small text-muted"><i class="fa-solid fa-user me-1 opacity-50"></i> {{ $student->fathers_name ?? 'N/A' }}</div>
                    </td>
                    <td class="text-center pe-4">
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" class="btn btn-icon-sm btn-soft-primary" data-bs-toggle="modal" data-bs-target="#studentModal{{ $student->id }}" title="View Full Details">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <a href="{{ route('students.edit', ['tenant' => auth()->user()?->school?->slug, 'student' => $student->id]) }}" 
                               class="btn btn-icon-sm btn-soft-warning" title="Edit Student">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('students.destroy', ['tenant' => auth()->user()?->school?->slug, 'student' => $student->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="btn btn-icon-sm btn-soft-danger" title="Delete Student">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MOBILE VIEW: Ultra-Clean Spacious Card Grid (Visible on Mobile Screens < md) --}}
    <div class="d-block d-md-none p-3">
        <div class="row g-3">
            @foreach($students as $student)
            <div class="col-12">
                <div class="student-mobile-card">
                    {{-- Top Header Row: Photo, Name, ID Badge --}}
                    <div class="d-flex align-items-center justify-content-between mb-3 gap-2">
                        <div class="d-flex align-items-center gap-2.5 min-w-0" style="min-width: 0;">
                            <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}" 
                                 alt="{{ $student->name }}" class="student-avatar-ring flex-shrink-0">
                            <div class="min-w-0" style="min-width: 0;">
                                <h6 class="fw-bold mb-0 text-dark text-truncate" style="font-size:14.5px;">{{ $student->name }}</h6>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-0.5 mt-0.5" style="font-size:10px;">
                                    {{ $student->status == 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <span class="student-id-badge flex-shrink-0">{{ $student->student_id }}</span>
                    </div>

                    {{-- Middle Info Box: Class, Roll, Father's Name, Phone --}}
                    <div class="student-info-box">
                        {{-- Class & Section --}}
                        <div class="student-info-row">
                            <div class="student-info-label">
                                <i class="fa-solid fa-graduation-cap text-primary student-info-icon"></i>
                                <span>Class & Sec:</span>
                            </div>
                            <span class="student-info-value fw-semibold text-primary">
                                {{ $student->class?->name ?? 'N/A' }} - {{ $student->section?->name ?? 'N/A' }}
                            </span>
                        </div>

                        {{-- Roll Row --}}
                        <div class="student-info-row">
                            <div class="student-info-label">
                                <i class="fa-solid fa-list-ol text-info student-info-icon"></i>
                                <span>Roll No:</span>
                            </div>
                            <span class="student-info-value fw-medium text-dark">
                                {{ $student->roll ?? 'N/A' }}
                            </span>
                        </div>

                        {{-- Father's Name Row --}}
                        @if($student->fathers_name)
                            <div class="student-info-row">
                                <div class="student-info-label">
                                    <i class="fa-solid fa-user-tie text-secondary student-info-icon"></i>
                                    <span>Father's Name:</span>
                                </div>
                                <span class="student-info-value fw-medium text-dark">
                                    {{ $student->fathers_name }}
                                </span>
                            </div>
                        @endif

                        {{-- Phone Row --}}
                        @if($student->contact_number)
                            <div class="student-info-row">
                                <div class="student-info-label">
                                    <i class="fa-solid fa-phone text-success student-info-icon"></i>
                                    <span>Contact:</span>
                                </div>
                                <a href="tel:{{ $student->contact_number }}" class="student-info-value fw-medium text-dark text-decoration-none">
                                    {{ $student->contact_number }}
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Bottom Action Row --}}
                    <div class="d-flex align-items-center justify-content-between pt-2.5 border-top">
                        <span class="small text-muted fw-medium" style="font-size:11.5px;">Quick Actions</span>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-icon-sm btn-soft-primary" data-bs-toggle="modal" data-bs-target="#studentModal{{ $student->id }}" title="View Full Details">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <a href="{{ route('students.edit', ['tenant' => auth()->user()?->school?->slug, 'student' => $student->id]) }}" 
                               class="btn btn-icon-sm btn-soft-warning" title="Edit Student">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('students.destroy', ['tenant' => auth()->user()?->school?->slug, 'student' => $student->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="btn btn-icon-sm btn-soft-danger" title="Delete Student">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@else
    {{-- Empty State --}}
    <div class="text-center py-5 px-3">
        <div class="py-4">
            <div class="mb-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: rgba(79,70,229,0.1); color: #4f46e5;">
                    <i class="fa-solid fa-user-graduate fa-2x"></i>
                </span>
            </div>
            <h5 class="fw-bold text-dark mb-1">No Students Found</h5>
            <p class="text-muted small mb-3">
                No student records match your specified search criteria.
            </p>
            <a href="{{ route('students.create', ['tenant' => auth()->user()?->school?->slug]) }}" class="btn btn-sm btn-primary-modern rounded-pill px-4">
                <i class="fa-solid fa-plus me-1"></i> Add Student
            </a>
        </div>
    </div>
@endif

@if(method_exists($students, 'links'))
    <div class="px-4 py-3 border-top d-flex justify-content-center">
        {{ $students->links() }}
    </div>
@endif

{{-- Full Detailed Student Modals (Premium Design) --}}
@foreach($students as $student)
<div class="modal fade" id="studentModal{{ $student->id }}" tabindex="-1" aria-labelledby="studentModalLabel{{ $student->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius:20px;">

            {{-- ════════ GRADIENT HERO HEADER ════════ --}}
            <div class="position-relative" style="background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 50%,#a855f7 100%);min-height:140px;overflow:hidden;">
                {{-- Background decorative circles --}}
                <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
                <div style="position:absolute;bottom:-60px;left:-30px;width:160px;height:160px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>
                <div style="position:absolute;top:20px;left:50%;width:80px;height:80px;background:rgba(255,255,255,0.05);border-radius:50%;transform:translateX(-50%);"></div>

                {{-- Close button --}}
                <button type="button" class="btn-close btn-close-white position-absolute" data-bs-dismiss="modal"
                    style="top:16px;right:20px;opacity:.8;filter:brightness(2);"></button>

                {{-- Header Content --}}
                <div class="d-flex align-items-end gap-4 px-4" style="padding-top:24px;padding-bottom:20px;">
                    {{-- Avatar with ring --}}
                    <div class="flex-shrink-0 position-relative">
                        <div style="width:96px;height:96px;border-radius:50%;border:4px solid rgba(255,255,255,0.5);box-shadow:0 0 0 4px rgba(255,255,255,0.15),0 8px 32px rgba(0,0,0,0.25);overflow:hidden;background:#e8e0ff;">
                            <img src="{{ $student->photo ? asset($student->photo) : asset('assets/images/profile.webp') }}"
                                 alt="{{ $student->name }}" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        @if($student->status == 'active')
                            <span style="position:absolute;bottom:4px;right:4px;width:16px;height:16px;background:#10b981;border:3px solid white;border-radius:50%;box-shadow:0 2px 6px rgba(0,0,0,0.2);"></span>
                        @else
                            <span style="position:absolute;bottom:4px;right:4px;width:16px;height:16px;background:#f59e0b;border:3px solid white;border-radius:50%;box-shadow:0 2px 6px rgba(0,0,0,0.2);"></span>
                        @endif
                    </div>

                    {{-- Name & Quick Badges --}}
                    <div class="flex-grow-1 pb-1">
                        <h4 class="fw-bold text-white mb-1" style="text-shadow:0 1px 4px rgba(0,0,0,0.2);letter-spacing:-.3px;">{{ $student->name }}</h4>
                        <div class="d-flex flex-wrap gap-2 mt-1">
                            <span style="background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);color:#fff;font-size:11px;font-weight:700;padding:3px 12px;border-radius:50px;border:1px solid rgba(255,255,255,0.25);">
                                <i class="fa-solid fa-id-badge me-1 opacity-75"></i>{{ $student->student_id }}
                            </span>
                            @if($student->roll)
                            <span style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);color:#e0d9ff;font-size:11px;font-weight:600;padding:3px 12px;border-radius:50px;border:1px solid rgba(255,255,255,0.2);">
                                <i class="fa-solid fa-hashtag me-1 opacity-75"></i>Roll: {{ $student->roll }}
                            </span>
                            @endif
                            <span style="background:{{ $student->status == 'active' ? 'rgba(16,185,129,0.3)' : 'rgba(245,158,11,0.3)' }};backdrop-filter:blur(8px);color:{{ $student->status == 'active' ? '#d1fae5' : '#fef3c7' }};font-size:11px;font-weight:700;padding:3px 12px;border-radius:50px;border:1px solid {{ $student->status == 'active' ? 'rgba(16,185,129,0.4)' : 'rgba(245,158,11,0.4)' }};">
                                <i class="fa-solid fa-circle me-1" style="font-size:7px;vertical-align:middle;"></i>{{ ucfirst($student->status ?? 'Active') }}
                            </span>
                        </div>
                    </div>

                    {{-- Class/Section pill (top-right corner inside header) --}}
                    <div class="text-end d-none d-md-block pb-1">
                        <div style="background:rgba(255,255,255,0.18);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.25);border-radius:14px;padding:10px 18px;text-align:center;">
                            <div class="text-white fw-bold" style="font-size:18px;line-height:1.1;">{{ $student->class?->name ?? '—' }}</div>
                            <div style="color:rgba(255,255,255,0.75);font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">{{ $student->section?->name ?? '' }} Section</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════════ MODAL BODY ════════ --}}
            <div class="modal-body p-4" style="background:#f8fafc;">
                <div class="row g-4">

                    {{-- ── LEFT SIDEBAR ── --}}
                    <div class="col-lg-4">

                        {{-- Quick Info Card --}}
                        <div class="card border-0 mb-3 overflow-hidden" style="border-radius:16px;box-shadow:0 2px 16px rgba(79,70,229,0.08);">
                            <div class="card-header border-0 py-2 px-3" style="background:linear-gradient(90deg,#f0f4ff,#faf5ff);">
                                <span class="fw-bold text-dark" style="font-size:12px;text-transform:uppercase;letter-spacing:.7px;">
                                    <i class="fa-solid fa-bolt text-primary me-1"></i>Quick Info
                                </span>
                            </div>
                            <div class="card-body p-0">
                                @php
                                $quickItems = [
                                    ['icon'=>'fa-graduation-cap','color'=>'#4f46e5','label'=>'Class','val'=> $student->class?->name ?? 'N/A'],
                                    ['icon'=>'fa-layer-group','color'=>'#7c3aed','label'=>'Section','val'=> $student->section?->name ?? 'N/A'],
                                    ['icon'=>'fa-tags','color'=>'#0ea5e9','label'=>'Category','val'=> $student->category?->name ?? 'N/A'],
                                    ['icon'=>'fa-users','color'=>'#10b981','label'=>'Group','val'=> $student->group?->name ?? 'N/A'],
                                    ['icon'=>'fa-phone','color'=>'#f59e0b','label'=>'Phone','val'=> $student->contact_number ?? 'N/A'],
                                    ['icon'=>'fa-envelope','color'=>'#ec4899','label'=>'Email','val'=> $student->user?->email ?? 'N/A'],
                                ];
                                @endphp
                                @foreach($quickItems as $i => $item)
                                <div class="d-flex align-items-center gap-3 px-3 py-2 {{ $i < count($quickItems)-1 ? 'border-bottom' : '' }}" style="border-color:#f1f5f9 !important;">
                                    <div style="width:32px;height:32px;border-radius:10px;background:{{ $item['color'] }}18;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="fa-solid {{ $item['icon'] }}" style="color:{{ $item['color'] }};font-size:13px;"></i>
                                    </div>
                                    <div style="min-width:0;">
                                        <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">{{ $item['label'] }}</div>
                                        <div class="fw-semibold text-dark text-truncate" style="font-size:13px;">{{ $item['val'] }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Blood Group & Gender mini stats --}}
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="card border-0 text-center p-3" style="border-radius:14px;background:linear-gradient(135deg,#fff1f2,#ffe4e6);box-shadow:0 2px 10px rgba(239,68,68,0.08);">
                                    <div style="font-size:22px;font-weight:800;color:#ef4444;line-height:1;">{{ $student->blood_group ?? '—' }}</div>
                                    <div style="font-size:10px;color:#f87171;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;">Blood Group</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border-0 text-center p-3" style="border-radius:14px;background:linear-gradient(135deg,#f0f9ff,#e0f2fe);box-shadow:0 2px 10px rgba(14,165,233,0.08);">
                                    <div style="font-size:18px;color:#0ea5e9;">
                                        @if(strtolower($student->gender ?? '') == 'male')
                                            <i class="fa-solid fa-mars"></i>
                                        @elseif(strtolower($student->gender ?? '') == 'female')
                                            <i class="fa-solid fa-venus"></i>
                                        @else
                                            <i class="fa-solid fa-genderless"></i>
                                        @endif
                                    </div>
                                    <div style="font-size:11px;font-weight:700;color:#0284c7;margin-top:2px;">{{ ucfirst($student->gender ?? 'N/A') }}</div>
                                    <div style="font-size:10px;color:#7dd3fc;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Gender</div>
                                </div>
                            </div>
                            @if($student->date_of_birth)
                            <div class="col-12">
                                <div class="card border-0 text-center p-3" style="border-radius:14px;background:linear-gradient(135deg,#f0fdf4,#dcfce7);box-shadow:0 2px 10px rgba(16,185,129,0.08);">
                                    <div style="font-size:13px;font-weight:700;color:#059669;">{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d M, Y') }}</div>
                                    <div style="font-size:10px;color:#6ee7b7;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-top:2px;">
                                        <i class="fa-solid fa-cake-candles me-1"></i>Date of Birth
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- ── RIGHT CONTENT ── --}}
                    <div class="col-lg-8">

                        {{-- 1. Academic Details --}}
                        <div class="card border-0 mb-3" style="border-radius:16px;box-shadow:0 2px 16px rgba(79,70,229,0.07);">
                            <div class="card-header border-0 py-3 px-4 d-flex align-items-center gap-2" style="background:linear-gradient(90deg,#eef2ff,#f5f3ff);border-radius:16px 16px 0 0;">
                                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:flex;align-items:center;justify-content:center;">
                                    <i class="fa-solid fa-graduation-cap text-white" style="font-size:14px;"></i>
                                </div>
                                <span class="fw-bold text-dark" style="font-size:14px;">Academic Details</span>
                            </div>
                            <div class="card-body px-4 py-3">
                                <div class="row g-3">
                                    @php
                                    $acItems = [
                                        ['label'=>'Class','val'=> $student->class?->name ?? 'N/A'],
                                        ['label'=>'Section','val'=> $student->section?->name ?? 'N/A'],
                                        ['label'=>'Roll Number','val'=> $student->roll ?? 'N/A'],
                                        ['label'=>'Category','val'=> $student->category?->name ?? 'N/A'],
                                        ['label'=>'Group','val'=> $student->group?->name ?? 'N/A'],
                                        ['label'=>'Admission Date','val'=> $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d M, Y') : 'N/A'],
                                        ['label'=>'Previous School','val'=> $student->previous_school ?? 'N/A'],
                                        ['label'=>'Previous Class','val'=> $student->previous_class ?? 'N/A'],
                                    ];
                                    @endphp
                                    @foreach($acItems as $item)
                                    <div class="col-sm-6">
                                        <div style="background:#f8fafc;border-radius:10px;padding:10px 14px;">
                                            <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;margin-bottom:3px;">{{ $item['label'] }}</div>
                                            <div class="fw-semibold text-dark" style="font-size:13px;">{{ $item['val'] }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- 2. Personal & Guardian Details --}}
                        <div class="card border-0 mb-3" style="border-radius:16px;box-shadow:0 2px 16px rgba(14,165,233,0.07);">
                            <div class="card-header border-0 py-3 px-4 d-flex align-items-center gap-2" style="background:linear-gradient(90deg,#f0f9ff,#e0f2fe);border-radius:16px 16px 0 0;">
                                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#0ea5e9,#6366f1);display:flex;align-items:center;justify-content:center;">
                                    <i class="fa-solid fa-user-shield text-white" style="font-size:14px;"></i>
                                </div>
                                <span class="fw-bold text-dark" style="font-size:14px;">Personal & Guardian Details</span>
                            </div>
                            <div class="card-body px-4 py-3">
                                <div class="row g-3">
                                    {{-- Father --}}
                                    <div class="col-sm-6">
                                        <div style="background:#f0fdf4;border-radius:10px;padding:10px 14px;border-left:3px solid #10b981;">
                                            <div style="font-size:10px;color:#6ee7b7;font-weight:600;text-transform:uppercase;letter-spacing:.6px;">Father's Name</div>
                                            <div class="fw-semibold text-dark" style="font-size:13px;margin-top:2px;">{{ $student->fathers_name ?? 'N/A' }}</div>
                                            @if($student->father_nid)
                                            <div style="font-size:11px;color:#64748b;margin-top:2px;"><i class="fa-solid fa-id-card me-1 opacity-60"></i>NID: {{ $student->father_nid }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Mother --}}
                                    <div class="col-sm-6">
                                        <div style="background:#fdf4ff;border-radius:10px;padding:10px 14px;border-left:3px solid #a855f7;">
                                            <div style="font-size:10px;color:#d8b4fe;font-weight:600;text-transform:uppercase;letter-spacing:.6px;">Mother's Name</div>
                                            <div class="fw-semibold text-dark" style="font-size:13px;margin-top:2px;">{{ $student->mothers_name ?? 'N/A' }}</div>
                                            @if($student->mother_nid)
                                            <div style="font-size:11px;color:#64748b;margin-top:2px;"><i class="fa-solid fa-id-card me-1 opacity-60"></i>NID: {{ $student->mother_nid }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Birth Registration --}}
                                    <div class="col-sm-6">
                                        <div style="background:#f8fafc;border-radius:10px;padding:10px 14px;">
                                            <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;margin-bottom:3px;">Birth Registration / NID</div>
                                            <div class="fw-semibold" style="font-size:13px;color:{{ $student->student_birth_nid ? '#4f46e5' : '#cbd5e1' }};">{{ $student->student_birth_nid ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                    {{-- Religion --}}
                                    <div class="col-sm-6">
                                        <div style="background:#f8fafc;border-radius:10px;padding:10px 14px;">
                                            <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;margin-bottom:3px;">Religion</div>
                                            <div class="fw-semibold text-dark" style="font-size:13px;">{{ $student->religion ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Contact & Address --}}
                        <div class="card border-0" style="border-radius:16px;box-shadow:0 2px 16px rgba(16,185,129,0.07);">
                            <div class="card-header border-0 py-3 px-4 d-flex align-items-center gap-2" style="background:linear-gradient(90deg,#f0fdf4,#dcfce7);border-radius:16px 16px 0 0;">
                                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;">
                                    <i class="fa-solid fa-address-book text-white" style="font-size:14px;"></i>
                                </div>
                                <span class="fw-bold text-dark" style="font-size:14px;">Contact & Address</span>
                            </div>
                            <div class="card-body px-4 py-3">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div style="background:#f8fafc;border-radius:10px;padding:10px 14px;">
                                            <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;margin-bottom:3px;">Contact Number</div>
                                            @if($student->contact_number)
                                                <a href="tel:{{ $student->contact_number }}" class="fw-semibold text-decoration-none" style="font-size:13px;color:#10b981;">
                                                    <i class="fa-solid fa-phone me-1" style="font-size:11px;"></i>{{ $student->contact_number }}
                                                </a>
                                            @else
                                                <span class="text-secondary" style="font-size:13px;">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div style="background:#f8fafc;border-radius:10px;padding:10px 14px;">
                                            <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;margin-bottom:3px;">Email Address</div>
                                            @if($student->user?->email)
                                                <a href="mailto:{{ $student->user->email }}" class="fw-semibold text-decoration-none text-truncate d-block" style="font-size:13px;color:#4f46e5;">
                                                    <i class="fa-solid fa-envelope me-1" style="font-size:11px;"></i>{{ $student->user->email }}
                                                </a>
                                            @else
                                                <span class="text-secondary" style="font-size:13px;">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div style="background:#f8fafc;border-radius:10px;padding:10px 14px;">
                                            <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;margin-bottom:3px;">
                                                <i class="fa-solid fa-location-dot me-1"></i>Present / Permanent Address
                                            </div>
                                            <div class="fw-semibold text-dark" style="font-size:13px;">{{ $student->address ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /col right --}}
                </div>{{-- /row --}}
            </div>{{-- /modal-body --}}

            {{-- ════════ FOOTER ════════ --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-2" style="background:#f8fafc;">
                <a href="{{ route('students.edit', ['tenant' => auth()->user()?->school?->slug, 'student' => $student->id]) }}"
                   class="d-inline-flex align-items-center gap-2 me-auto text-decoration-none"
                   style="background:linear-gradient(135deg,#f59e0b 0%,#f97316 100%) !important;color:#fff !important;border:none;border-radius:10px;padding:7px 18px;font-size:13px;font-weight:600;letter-spacing:.2px;box-shadow:0 3px 12px rgba(245,158,11,0.35);transition:all .25s cubic-bezier(.4,0,.2,1);cursor:pointer;"
                   onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 18px rgba(245,158,11,0.5)'"
                   onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 3px 12px rgba(245,158,11,0.35)'">
                    <span style="width:22px;height:22px;background:rgba(255,255,255,0.25);border-radius:6px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-regular fa-pen-to-square" style="font-size:11px;"></i>
                    </span>
                    Edit Profile
                </a>
                <button type="button" data-bs-dismiss="modal"
                    class="d-inline-flex align-items-center gap-2"
                    style="background:linear-gradient(135deg,#e2e8f0 0%,#f1f5f9 100%) !important;color:#475569 !important;border:1.5px solid #cbd5e1 !important;border-radius:10px;padding:7px 18px;font-size:13px;font-weight:600;letter-spacing:.2px;box-shadow:0 2px 6px rgba(100,116,139,0.1);transition:all .25s cubic-bezier(.4,0,.2,1);cursor:pointer;"
                    onmouseover="this.style.background='linear-gradient(135deg,#cbd5e1 0%,#e2e8f0 100%)';this.style.color='#1e293b';this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.background='linear-gradient(135deg,#e2e8f0 0%,#f1f5f9 100%)';this.style.color='#475569';this.style.transform='translateY(0)'">
                    <span style="width:22px;height:22px;background:rgba(100,116,139,0.12);border-radius:6px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-xmark" style="font-size:11px;"></i>
                    </span>
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
@endforeach