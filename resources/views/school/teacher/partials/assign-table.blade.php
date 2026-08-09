@if($assignments->count() > 0)
    {{-- Desktop Table View --}}
    <div class="table-responsive assign-desktop-table">
        <table class="table edu-table align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Teacher Name</th>
                    <th>Class & Section</th>
                    <th>Assigned Subject</th>
                    <th style="width: 100px;" class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                    <tr>
                        <td class="text-muted fw-bold">
                            {{ $loop->iteration + ($assignments->currentPage() - 1) * $assignments->perPage() }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if(!empty($assignment->teacher->photo) && file_exists(public_path($assignment->teacher->photo)))
                                    <img src="{{ asset($assignment->teacher->photo) }}" alt="{{ $assignment->teacher->name }}" class="rounded-circle shadow-sm me-2" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e2e8f0;">
                                @else
                                    <div class="avatar-circle font-weight-bold text-white shadow-sm me-2" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; font-weight: 700; flex-shrink: 0;">
                                        {{ strtoupper(substr($assignment->teacher->name ?? 'T', 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark fs-6 mb-0">{{ $assignment->teacher->name ?? 'N/A' }}</div>
                                    @if(!empty($assignment->teacher->designation))
                                        <div class="text-muted small" style="font-size: 0.78rem;">{{ $assignment->teacher->designation }}</div>
                                    @elseif(!empty($assignment->teacher->phone))
                                        <div class="text-muted small" style="font-size: 0.78rem;"><i class="fa-solid fa-phone me-1"></i>{{ $assignment->teacher->phone }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1.5 flex-wrap">
                                <span class="badge bg-soft-primary text-primary px-2.5 py-1.5 rounded-3 fw-semibold">
                                    <i class="fa-solid fa-school me-1"></i> {{ $assignment->class->name ?? 'N/A' }}
                                </span>
                                @if($assignment->section)
                                    <span class="badge bg-soft-info text-info px-2.5 py-1.5 rounded-3 fw-semibold">
                                        <i class="fa-solid fa-layer-group me-1"></i> {{ $assignment->section->name }}
                                    </span>
                                @else
                                    <span class="badge bg-soft-secondary text-secondary px-2 py-1 rounded-3 small">
                                        All Sections
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-soft-success text-success px-3 py-1.5 rounded-3 fw-bold text-capitalize" style="font-size: 0.83rem;">
                                <i class="fa-solid fa-book-open me-1"></i> {{ $assignment->subject->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex align-items-center justify-content-end gap-1">
                                <form action="{{ route('teacher.assign.destroy', ['tenant' => auth()->user()?->school?->slug, 'assignment' => $assignment->id]) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" 
                                            class="btn btn-soft-danger btn-icon-sm" 
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Assignment">
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

    {{-- Mobile Premium Cards View --}}
    <div class="assign-mobile-cards">
        @foreach($assignments as $assignment)
            <div class="assign-mobile-card">
                <div class="assign-mobile-card-header">
                    <div class="d-flex align-items-center gap-3">
                        @if(!empty($assignment->teacher->photo) && file_exists(public_path($assignment->teacher->photo)))
                            <img src="{{ asset($assignment->teacher->photo) }}" alt="{{ $assignment->teacher->name }}" class="rounded-circle shadow-sm me-3" style="width: 44px; height: 44px; object-fit: cover; border: 2px solid #e2e8f0; margin-right: 12px;">
                        @else
                            <div class="avatar-circle font-weight-bold text-white shadow-sm me-3" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: 700; flex-shrink: 0; margin-right: 12px;">
                                {{ strtoupper(substr($assignment->teacher->name ?? 'T', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="fw-bold text-dark fs-6 mb-0">{{ $assignment->teacher->name ?? 'N/A' }}</div>
                            @if(!empty($assignment->teacher->designation))
                                <div class="text-muted small" style="font-size: 0.78rem;">{{ $assignment->teacher->designation }}</div>
                            @elseif(!empty($assignment->teacher->phone))
                                <div class="text-muted small" style="font-size: 0.78rem;"><i class="fa-solid fa-phone me-1"></i>{{ $assignment->teacher->phone }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light text-secondary rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.75rem;">
                            #{{ $loop->iteration + ($assignments->currentPage() - 1) * $assignments->perPage() }}
                        </span>
                        <form action="{{ route('teacher.assign.destroy', ['tenant' => auth()->user()?->school?->slug, 'assignment' => $assignment->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete(this)" class="btn btn-soft-danger btn-icon-sm" title="Remove Assignment">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="assign-mobile-card-body">
                    <div class="d-flex align-items-center gap-1.5 flex-wrap">
                        <span class="badge bg-soft-primary text-primary px-2.5 py-1.5 rounded-3 fw-semibold" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-school me-1"></i> {{ $assignment->class->name ?? 'N/A' }}
                        </span>
                        @if($assignment->section)
                            <span class="badge bg-soft-info text-info px-2.5 py-1.5 rounded-3 fw-semibold" style="font-size: 0.8rem;">
                                <i class="fa-solid fa-layer-group me-1"></i> {{ $assignment->section->name }}
                            </span>
                        @else
                            <span class="badge bg-soft-secondary text-secondary px-2 py-1 rounded-3 small" style="font-size: 0.78rem;">
                                All Sections
                            </span>
                        @endif
                    </div>
                    <div>
                        <span class="badge bg-soft-success text-success px-3 py-1.5 rounded-3 fw-bold text-capitalize" style="font-size: 0.82rem;">
                            <i class="fa-solid fa-book-open me-1"></i> {{ $assignment->subject->name ?? 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($assignments->hasPages())
        <div class="px-4 py-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="text-muted small">
                Showing {{ $assignments->firstItem() }} to {{ $assignments->lastItem() }} of {{ $assignments->total() }} assignments
            </div>
            <div>
                {{ $assignments->links() }}
            </div>
        </div>
    @endif
@else
    <div class="text-center py-5 px-3">
        <div class="avatar-icon bg-soft-primary text-primary rounded-circle mx-auto mb-3" style="width: 70px; height: 70px; font-size: 2rem; display: flex; align-items: center; justify-content: center;">
            <i class="fa-solid fa-folder-open"></i>
        </div>
        <h5 class="fw-bold text-dark mb-1">No Teacher Assignments Found</h5>
        <p class="text-muted small mb-3" style="max-width: 400px; margin: 0 auto;">No subject allocations match your current search or filter criteria. Select options from the left form to assign a teacher.</p>
    </div>
@endif