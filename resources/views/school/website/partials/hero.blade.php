<div class="container-fluid p-0 mb-5 shadow-sm" style="min-height: 600px; position: relative; z-index: 1;">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($sliders as $key => $slider)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img class="w-100" src="{{ asset($slider->image) }}" alt="Image" style="height: 600px; object-fit: cover;">
                    <div class="carousel-caption">
                        <div class="hero-box text-center">
                            <h6 class="text-white text-uppercase mb-3" style="letter-spacing: 2px; font-weight: 600;">{{ $slider->subtitle ?? 'The Best School in the Area' }}</h6>
                            <h1 class="display-4 text-white mb-4 fw-bold">{{ $slider->title ?? $school->name }}</h1>
                            
                            {{-- Result Search Box --}}
                            <div class="mx-auto mt-4" style="max-width: 500px;">
                                <form id="resultSearchForm" class="d-flex">
                                    @csrf
                                    <input type="text" name="student_id" id="student_id" class="form-control border-0 rounded-start py-3" placeholder="Enter Student ID (e.g. STD-261002)" required>
                                    <button type="submit" id="submitBtn" class="btn btn-gold rounded-end px-4 fw-bold">
                                        <span class="btn-text">Search</span>
                                        <span class="spinner-border spinner-border-sm d-none"></span>
                                    </button>
                                </form>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('admission.create', ['tenant' => $school->slug]) }}" class="btn btn-gold py-md-3 px-md-5 me-3 fw-bold">Apply Now</a>
                                <a href="#contact" class="btn btn-outline-light py-md-3 px-md-5 fw-bold">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('main/img/hero.jpg') }}" alt="Image" style="height: 600px; object-fit: cover;">
                    <div class="carousel-caption">
                        <div class="hero-box text-center">
                            <h6 class="text-white text-uppercase mb-3" style="letter-spacing: 2px; font-weight: 600;">Welcome to Our School</h6>
                            <h1 class="display-4 text-white mb-4 fw-bold">Welcome to {{ $school->name ?? 'Our School' }}</h1>
                            
                            {{-- Result Search Box --}}
                            <div class="mx-auto mt-4" style="max-width: 500px;">
                                <form id="resultSearchForm" class="d-flex">
                                    @csrf
                                    <input type="text" name="student_id" id="student_id" class="form-control border-0 rounded-start py-3" placeholder="Enter Student ID (e.g. STD-261002)" required>
                                    <button type="submit" id="submitBtn" class="btn btn-gold rounded-end px-4 fw-bold">
                                        <span class="btn-text">Search</span>
                                        <span class="spinner-border spinner-border-sm d-none"></span>
                                    </button>
                                </form>
                            </div>

                            <div class="mt-4">
                                <a href="#about" class="btn btn-gold py-md-3 px-md-5 fw-bold">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        @if($sliders->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif
    </div>
</div>

{{-- Result Modal --}}
<div class="modal fade" id="resultModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-navy text-white">
                <h5 class="modal-title fw-bold">Examination Result</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="resultContent"></div>
        </div>
    </div>
</div>

<style>
    .btn-gold { 
        background-color: #F9B800; 
        color: #002147; 
        border: none;
        transition: 0.3s;
    }
    .btn-gold:hover { 
        background-color: #e0a500; 
        color: #002147; 
        transform: translateY(-2px);
    }
    .btn-lg-square {
        width: 60px;
        height: 60px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .carousel-item {
        min-height: 600px;
        background-color: #002147;
    }
    .carousel-caption {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: none !important;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hero-box {
        background: rgba(0, 33, 71, 0.9) !important;
        padding: 60px 40px !important;
        border-radius: 20px !important;
        box-shadow: 0 0 50px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        max-width: 850px;
        margin: 15px;
    }
    .bg-navy { background-color: #002147 !important; }
    @media (max-width: 768px) {
        .display-4 {
            font-size: 1.8rem !important;
        }
        .hero-box {
            padding: 30px 20px !important;
        }
        .carousel-item {
            min-height: 500px !important;
        }
        #resultSearchForm {
            flex-direction: column;
        }
        #resultSearchForm input {
            border-radius: 5px !important;
            margin-bottom: 10px;
        }
        #resultSearchForm button {
            border-radius: 5px !important;
        }
    }
</style>

@push('customJs')
<script>
$(document).ready(function() {
    $('#resultSearchForm').on('submit', function(e) {
        e.preventDefault();
        let studentId = $('#student_id').val().trim();
        if(!studentId) return;

        let submitBtn = $('#submitBtn');
        let spinner = submitBtn.find('.spinner-border');
        let btnText = submitBtn.find('.btn-text');

        $('#resultContent').html('');
        submitBtn.prop('disabled', true);
        btnText.addClass('d-none');
        spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('frontend.search_result', ['tenant' => $tenant ?? $school->slug]) }}",
            method: "POST",
            data: { _token: "{{ csrf_token() }}", student_id: studentId },
            success: function(response) {
                if(typeof response === 'object') {
                    if(response.status) {
                        $('#resultContent').html(response.data);
                        $('#resultModal').modal('show');
                    } else {
                        alert(response.message || "Result not found.");
                    }
                } else {
                    $('#resultContent').html(response);
                    $('#resultModal').modal('show');
                }
            },
            error: function(xhr) { alert("Error: " + xhr.status); },
            complete: function() {
                submitBtn.prop('disabled', false);
                btnText.removeClass('d-none');
                spinner.addClass('d-none');
            }
        });
    });
});
</script>
@endpush