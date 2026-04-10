@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            {{-- Create/Edit Class Form --}}
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title text-primary fw-bold" id="form-title">Create Class</h6>
                        <hr>
                        <form id="class-form" action="{{ route('classes.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                            @csrf
                            <div id="method-field"></div> {{-- PUT মেথড ইনজেক্ট করার জন্য --}}
                            
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Name</label>
                                <input type="text" class="form-control border-primary" id="name" name="name" placeholder="Enter Class Name: [One, ...]" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="code" class="form-label fw-bold">Code</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="Enter Class Code: [101, ...]">
                            </div>
                            
                            <div class="mb-3">
                                <label for="school_category_id" class="form-label fw-bold">Category</label>
                                <select id="school_category_id" name="school_category_id" class="form-select border-info" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="2" placeholder="Enter description"></textarea>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100 fw-bold" id="submit-btn">Create Class</button>
                                <button type="button" class="btn btn-secondary d-none" id="cancel-btn" onclick="resetForm()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Classes List --}}
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title fw-bold text-secondary">Class List</h6>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classes as $class)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $class->name }}</td>
                                        <td><span class="badge bg-light text-dark">{{ $class->code }}</span></td>
                                        <td>{{ $class->category ? $class->category->name : 'N/A' }}</td>
                                        <td><small>{{ Str::limit($class->description, 30) }}</small></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                {{-- Edit Button --}}
                                                <button type="button" class="btn btn-sm btn-outline-warning" 
                                                    onclick="editClass('{{ $class->id }}', '{{ $class->name }}', '{{ $class->code }}', '{{ $class->school_category_id }}', '{{ $class->description }}')">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                {{-- Delete Form --}}
                                                <form action="{{ route('classes.destroy', ['tenant' => auth()->user()->school->slug, 'class' => $class->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)" class="btn btn-sm btn-outline-danger">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No classes found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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