@extends('layouts.main')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Wishing Alert Logic --}}
        @php
            $hour = date('H');
            if ($hour >= 5 && $hour < 12) {
                $greeting = "Good Morning";
                $icon = "sun";
            } elseif ($hour >= 12 && $hour < 17) {
                $greeting = "Good Afternoon";
                $icon = "sunrise";
            } elseif ($hour >= 17 && $hour < 21) {
                $greeting = "Good Evening";
                $icon = "sunset";
            } else {
                $greeting = "Good Night";
                $icon = "moon";
            }
        @endphp

        {{-- Wishing Alert Display --}}
        <div class="d-flex align-items-center mb-4">
            <div class="me-3">
                <i data-feather="{{ $icon }}" class="text-warning" style="width: 30px; height: 30px;"></i>
            </div>
            <div>
                <h4 class="mb-0">{{ $greeting }}, {{ auth()->user()->name }}!</h4>
                <p class="text-muted">Welcome to the Super Admin Control Center.</p>
            </div>
        </div>

        {{-- Statistics Cards (School Dashboard Style) --}}
        <div class="row">
            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                            <div style="width: 55px; height: 55px; background-color: rgba(101, 113, 255, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-3">
                                <i class="fa-solid fa-school fs-3 text-primary"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">Total Schools</p>
                                <h3 class="mb-0 fw-bold text-primary">{{ $totalSchools }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                            <div style="width: 55px; height: 55px; background-color: rgba(255, 153, 0, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-3">
                                <i class="fa-solid fa-clock-rotate-left fs-3 text-warning"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">Pending Request</p>
                                <h3 class="mb-0 fw-bold text-warning">{{ $pendingSchools }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                            <div style="width: 55px; height: 55px; background-color: rgba(16, 185, 129, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-3">
                                <i class="fa-solid fa-sack-dollar fs-3 text-success"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">Revenue</p>
                                <h3 class="mb-0 fw-bold text-success">৳ 0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                            <div style="width: 55px; height: 55px; background-color: rgba(239, 68, 68, 0.1);" 
                                class="rounded-circle d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-3">
                                <i class="fa-solid fa-users-gear fs-3 text-danger"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 text-sm">System Users</p>
                                <h3 class="mb-0 fw-bold text-danger">Active</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Schools Table --}}
        <div class="row mt-4">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title">Recent School Registrations</h6>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School Name</th>
                                        <th>Subdomain/Slug</th>
                                        <th>Admin Email</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentSchools as $key => $school)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $school->name }}</td>
                                            <td>
                                                <span class="badge bg-light-primary text-primary">
                                                    {{ $school->slug }}.{{ $mainDomain ?? config('app.url') }}
                                                </span>
                                            </td>
                                            <td>{{ $school->email ?? 'No Admin Email' }}</td>
                                            <td> 
                                                @if($school->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('super.schools.all') }}" class="btn btn-xs btn-outline-primary">
                                                    <i data-feather="eye" class="icon-sm"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No recent registrations found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection