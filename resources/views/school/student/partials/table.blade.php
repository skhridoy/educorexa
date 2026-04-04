<div class="table-responsive">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Roll</th>
                <th>Image</th>
                <th>Student Id</th>
                <th>Name</th>
                <th>Class</th>
                <th>Section</th>
                <th>Year</th>
                <th>Contact</th>
                <th>Father Name</th>
                <th>Admited By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->roll }}</td>
                    <td class="py-1">
                        @if($student->photo)
                            <img style="border: 2px solid gold" src="{{ asset($student->photo) }}" alt="image" class="profile">
                        @else
                            <img style="border: 2px solid gold" src="{{ asset('assets/images/profile.webp') }}" alt="image"
                                class="profile">
                        @endif
                    </td>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->class->name ?? 'N/A' }}</td>
                    <td>{{ $student->section->name ?? 'N/A' }}</td>
                    <td>{{ $student->academicYear->name ?? 'N/A' }}</td>
                    <td>{{ $student->contact_number }}</td>
                    <td>{{ $student->fathers_name ?? 'Not submit' }}</td>
                    <td>{{ $student->creator->name ?? 'Online' }}</td>
                    <td>
                        @if($student->status == 'active')
                            <span class="btn btn-sm btn-success badge">active</span>
                        @else
                            <span class="btn btn-sm btn-warning badge">rejected</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('students.edit', ['tenant' => auth()->user()->school->slug, 'student' => $student->id]) }}"
                            class="btn btn-sm btn-warning badge"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form
                            action="{{ route('students.destroy', ['tenant' => auth()->user()->school->slug, 'student' => $student->id]) }}"
                            method="POST" style="display:inline;">
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
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11">
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