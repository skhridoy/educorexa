@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Active Schools</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-school me-2" style="color:#4f46e5;"></i> Active School Platforms</h2>
            <p class="edu-page-sub">Manage and verify active tenant institutions on the platform.</p>
        </div>
        <div class="badge-indigo" style="padding:8px 16px;">{{ $schools->count() }} Schools</div>
    </div>

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">Verified Institutions</h6>
        </div>
        <div class="edu-panel-bd">
            <div class="table-responsive">
                <table class="edu-table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>School Name</th>
                            <th>Admin / Contact</th>
                            <th>Platform Domain</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schools as $school)
                        <tr>
                            <td class="text-muted font-monospace" style="font-size:0.8rem;">#{{ $school->id }}</td>
                            <td>
                                <span style="font-weight:700; color:#1e293b;">{{ $school->name }}</span>
                            </td>
                            <td>
                                <div style="font-size:0.85rem; color:#475569;">{{ $school->admin->email ?? 'N/A' }}</div>
                                <div style="font-size:0.75rem; color:#94a3b8;">{{ $school->admin->phone ?? '' }}</div>
                            </td>
                            <td>
                                <a href="http://{{ $school->slug }}.{{ $mainDomain }}" target="_blank" class="badge-indigo" style="text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
                                    {{ $school->slug }}.{{ $mainDomain }} <i data-feather="external-link" style="width:12px;"></i>
                                </a>
                            </td>
                            <td>
                                @if($school->is_active)
                                    <span class="badge-green"><i data-feather="check" style="width:12px; margin-right:4px;"></i> Active</span>
                                @else
                                    <span class="badge-amber"><i data-feather="clock" style="width:12px; margin-right:4px;"></i> Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    @if(!$school->is_active)
                                        <form action="{{ route('super.schools.approve', $school->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="act-btn" title="Approve" style="color:#10b981; background:#ecfdf5;">
                                                <i data-feather="check-circle" style="width:14px;"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <button class="act-btn" title="View Details">
                                        <i data-feather="eye" style="width:14px;"></i>
                                    </button>
                                    <form action="{{ route('manage.schools.destroy', $school->id) }}" method="POST" onsubmit="return confirm('Remove this school?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="act-btn del" title="Delete">
                                            <i data-feather="trash-2" style="width:14px;"></i>
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
@endsection