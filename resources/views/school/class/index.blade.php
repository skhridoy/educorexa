@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-book me-2"></i> Classes Management</h1>
                <p style="margin: 0; opacity: 0.85;">Create and manage classes in your school</p>
            </div>
        </div>

        <div class="row">
            {{-- Form Column --}}
            <div class="col-lg-4 mb-4">
                <div class="form-card">
                    <h6 class="mb-4 fw-bold text-primary" id="form-title">
                        <i class="fa-solid fa-plus me-2"></i> Create Class
                    </h6>
                    <form id="class-form" action="{{ route('classes.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div id="method-field"></div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Class Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Class One, Grade 10" required>
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">Class Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="e.g., 101, A1">
                        </div>

                        <div class="mb-3">
                            <label for="school_category_id" class="form-label">Category</label>
                            <select id="school_category_id" name="school_category_id" class="form-select" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Enter description (optional)"></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-gradient w-100" id="submit-btn">
                                <i class="fa-solid fa-check me-1"></i> Create Class
                            </button>
                            <button type="button" class="btn btn-secondary d-none" id="cancel-btn" onclick="resetForm()">
                                <i class="fa-solid fa-times me-1"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Classes List Column --}}
            <div class="col-lg-8">
                <div class="data-table-card">
                    <div class="table-header">
                        <h5 class="table-title"><i class="fa-solid fa-list me-2"></i> Classes List</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table data-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classes as $class)
                                <tr>
                                    <td data-label="#" style="font-weight: 600;">{{ $loop->iteration }}</td>
                                    <td data-label="Name" style="font-weight: 600;">{{ $class->name }}</td>
                                    <td data-label="Code"><span style="background: #eef2ff; color: #4f46e5; padding: 4px 8px; border-radius: 6px; font-size: 0.85rem;">{{ $class->code }}</span></td>
                                    <td data-label="Category">{{ $class->category?->name ?? 'N/A' }}</td>
                                    <td data-label="Description"><small>{{ \Str::limit($class->description, 30) }}</small></td>
                                    <td data-label="Actions" class="text-center">
                                        <button type="button" class="btn btn-action btn-sm btn-outline-warning" 
                                            onclick="editClass('{{ $class->id }}', '{{ $class->name }}', '{{ $class->code }}', '{{ $class->school_category_id }}', '{{ $class->description }}')">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('classes.destroy', ['tenant' => auth()->user()->school->slug, 'class' => $class->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-action btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        <i class="fa-solid fa-book-open"></i>
                                        <p class="text-muted">No classes found.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $classes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customJs')
<script>
    function editClass(id, name, code, categoryId, description) {
        document.getElementById('form-title').innerHTML = '<i class="fa-solid fa-edit me-2"></i> Edit Class';
        document.getElementById('submit-btn').innerHTML = '<i class="fa-solid fa-check me-1"></i> Update Class';
        document.getElementById('cancel-btn').classList.remove('d-none');

        const form = document.getElementById('class-form');
        form.action = "{{ route('classes.update', ['tenant' => auth()->user()->school->slug, 'class' => ':id']) }}".replace(':id', id);
        
        const methodField = document.getElementById('method-field');
        methodField.innerHTML = '@method("PUT")';

        document.getElementById('name').value = name;
        document.getElementById('code').value = code;
        document.getElementById('school_category_id').value = categoryId;
        document.getElementById('description').value = description;

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('form-title').innerHTML = '<i class="fa-solid fa-plus me-2"></i> Create Class';
        document.getElementById('submit-btn').innerHTML = '<i class="fa-solid fa-check me-1"></i> Create Class';
        document.getElementById('cancel-btn').classList.add('d-none');

        const form = document.getElementById('class-form');
        form.action = "{{ route('classes.store', ['tenant' => auth()->user()->school->slug]) }}";
        form.reset();
        document.getElementById('method-field').innerHTML = '';
    }

    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this class?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        })
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
    });
    @endif
</script>
<script>
    // এডিট মোড চালু করার ফাংশন
    function editClass(id, name, code, categoryId, description) {
        // শুরুতে স্ল্যাশ এবং টেন্যান্ট স্লাগ দেওয়ার দরকার নেই যদি আপনি সাবডোমেইনে থাকেন
        // শুধু 'classes/id' দিলেই হবে
        let updateUrl = "classes/" + id; 

        // ফর্মের টেক্সট এবং টাইটেল পরিবর্তন
        $('#form-title').text('Update Class: ' + name);
        $('#submit-btn').text('Update Class');
        $('#cancel-btn').removeClass('d-none');
        
        // ফর্মের অ্যাকশন ইউআরএল এবং মেথড পরিবর্তন
        $('#class-form').attr('action', updateUrl);
        $('#method-field').html('<input type="hidden" name="_method" value="PUT">');

        // ফিল্ডগুলোতে ভ্যালু বসানো
        $('#name').val(name);
        $('#code').val(code);
        $('#school_category_id').val(categoryId);
        $('#description').val(description);

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ফর্ম রিসেট বা ক্যানসেল করার ফাংশন
    function resetForm() {
        // স্টোর করার জন্য শুধু 'classes' দিলেই হবে
        let storeUrl = "classes";

        $('#form-title').text('Create Class');
        $('#submit-btn').text('Create Class');
        $('#cancel-btn').addClass('d-none');
        
        $('#class-form').attr('action', storeUrl);
        $('#method-field').html('');
        $('#class-form')[0].reset();
    }

    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this class?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        })
    }

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#3085d6',
        });
    @endif

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 1500,
        showConfirmButton: false
    });
    @endif
</script>
@endsection