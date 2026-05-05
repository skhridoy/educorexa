<div class="table-responsive">

    <table class="table data-table mb-0 align-middle">
        <thead>
            <tr>
                <th>Image</th>
                <th>Student Id</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td class="py-1">
                        @if($student->photo)
                            <img src="{{ asset($student->photo) }}" alt="image" class="profile rounded-circle border border-warning" style="width:42px;height:42px;object-fit:cover;">
                        @else
                            <img src="{{ asset('assets/images/profile.webp') }}" alt="image" class="profile rounded-circle border border-warning" style="width:42px;height:42px;object-fit:cover;">
                        @endif
                    </td>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>
                        <div style="display:inline-flex; align-items:center; gap:0.35rem; flex-wrap:wrap;">
                            <button type="button" class="btn btn-sm btn-info badge" data-bs-toggle="modal" data-bs-target="#studentModal{{ $student->id }}">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <a href="{{ route('students.edit', ['tenant' => auth()->user()->school->slug, 'student' => $student->id]) }}"
                                class="btn btn-sm btn-warning badge"><i class="fa-regular fa-pen-to-square"></i></a>
                            <form
                                action="{{ route('students.destroy', ['tenant' => auth()->user()->school->slug, 'student' => $student->id]) }}"
                                method="POST" style="display:inline-flex; align-items:center; gap:0.35rem;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger badge" onclick="confirmDelete(this)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            <a href="#"
                            class="btn btn-sm btn-info badge" target="_blank">
                            <i class="fa-solid fa-id-badge"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <div class="text-center py-5">
    
                            <div class="mb-3">
                                <i class="bi bi-search" style="font-size: 50px; opacity:0.5;"></i>
                            </div>
    
                            <h5 class="text-muted">No Students Found</h5>
                            <p class="text-muted small">
                                Try adjusting your search criteria.
                            </p>
    
                        </div>
                    </td>
                </tr>  
                
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3 d-flex justify-content-center">
    {{ $students->links() }}
</div>

@forelse($students as $student)
<!-- Student Details Modal -->
<div class="modal fade" id="studentModal{{ $student->id }}" tabindex="-1" aria-labelledby="studentModalLabel{{ $student->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel{{ $student->id }}">Student Details - {{ $student->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        @if($student->photo)
                            <img src="{{ asset($student->photo) }}" alt="image" class="img-fluid rounded-circle border border-warning" style="width:120px;height:120px;object-fit:cover;">
                        @else
                            <img src="{{ asset('assets/images/profile.webp') }}" alt="image" class="img-fluid rounded-circle border border-warning" style="width:120px;height:120px;object-fit:cover;">
                        @endif
                        <h6 class="mt-2">{{ $student->name }}</h6>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th>Student ID:</th>
                                    <td>{{ $student->student_id }}</td>
                                </tr>
                                <tr>
                                    <th>Roll:</th>
                                    <td>{{ $student->roll }}</td>
                                </tr>
                                <tr>
                                    <th>Class:</th>
                                    <td>{{ $student->class->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Group:</th>
                                    <td>{{ $student->group->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Section:</th>
                                    <td>{{ $student->section->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Academic Year:</th>
                                    <td>{{ $student->academicYear->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Contact:</th>
                                    <td>{{ $student->contact_number }}</td>
                                </tr>
                                <tr>
                                    <th>Father's Name:</th>
                                    <td>{{ $student->fathers_name ?? 'Not submit' }}</td>
                                </tr>
                                <tr>
                                    <th>Admitted By:</th>
                                    <td>{{ $student->creator->name ?? 'Online' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($student->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@empty
    {{-- খালি থাকলে মডাল তৈরির প্রয়োজন নেই --}}
@endforelse