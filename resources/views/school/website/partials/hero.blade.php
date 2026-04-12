<div class="container-xxl bg-primary hero-header py-4 mt-3">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            
            {{-- বাম পাশের অংশ --}}
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="text-white text-capitalize mb-2 animated slideInDown">
                    {{ $sliders->isNotEmpty() ? $sliders->first()->title : "Welcome to " . $school->name }}
                </h1>
                <p class="text-white pb-3 animated slideInDown">
                    {{ $sliders->isNotEmpty() ? $sliders->first()->subtitle : $school->address }}
                </p>
                
                {{-- রেজাল্ট সার্চ ফর্ম --}}
                <div class="position-relative w-100 mt-3 animated fadeInUp">
                    <form id="resultSearchForm">
                        @csrf
                        
                        <input name="student_id" id="student_id" class="form-control border-0 rounded-pill w-100 ps-4 pe-5" 
                            type="text" placeholder="Search Result by ID (e.g. STD-261001)..." 
                            style="height: 58px;" required>
                        <button type="submit" id="submitBtn" class="btn btn-primary rounded-pill py-2 px-4 shadow-none position-absolute top-0 end-0 m-2" style="height: 42px;">
                            <span class="btn-text">Check Result</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </form>
                </div>

                {{-- Update your modal div slightly to ensure it's on top --}}
                <div class="modal fade" id="resultModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header border-0 bg-light">
                                <h5 class="modal-title fw-bold">Examination Result</h5>
                                <button type="button" class="btn-close btn-close-red position-absolute top-0 end-0 m-3" 
                data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                            </div>
                            <div class="modal-body p-0" id="resultContent">
                                {{-- AJAX Content will be injected here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ডান পাশের অংশ (ইমেজ স্লাইডার) --}}
            <div class="col-lg-6 text-center text-lg-end pt-4">
                <div id="heroImageCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        @forelse($sliders as $key => $slider)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img class="img-fluid rounded animated zoomIn" 
                                     src="{{ asset($slider->image) }}" 
                                     alt="Slider Image" 
                                     style="max-height: 450px; width: 100%; object-fit: cover; border: 5px solid rgba(255,255,255,0.1);">
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img class="img-fluid rounded" src="{{ asset('main/img/hero.jpg') }}" alt="Default Hero">
                            </div>
                        @endforelse
                    </div>
                    
                    @if($sliders->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroImageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroImageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@section('customJs')
<script>
$(document).ready(function() {
    $('#resultSearchForm').on('submit', function(e) {
        e.preventDefault();
        
        let studentId = $('#student_id').val().trim();
        if(!studentId) {
            alert('Please enter a Student ID'); 
            return;
        }

        let submitBtn = $('#submitBtn');
        let spinner = submitBtn.find('.spinner-border');
        let btnText = submitBtn.find('.btn-text');

        // 1. Clear previous content so the modal doesn't show old data
        $('#resultContent').html('');

        // 2. UI Loading State
        submitBtn.prop('disabled', true);
        btnText.addClass('d-none');
        spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('frontend.search_result', ['tenant' => $tenant ?? $school->slug]) }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                student_id: studentId
            },
            success: function(response) {
                // Handle JSON object (preferred)
                if(typeof response === 'object') {
                    if(response.status) {
                        $('#resultContent').html(response.data);
                        $('#resultModal').modal('show');
                    } else {
                        alert(response.message || "Result not found.");
                    }
                } else {
                    // Fallback for direct HTML response
                    $('#resultContent').html(response);
                    $('#resultModal').modal('show');
                }
            },
            error: function(xhr) {
                let msg = "Something went wrong.";
                if(xhr.status === 404) {
                    msg = "Student ID or Result not found.";
                } else if(xhr.status === 419) {
                    msg = "Session expired. Refreshing page...";
                    location.reload();
                } else {
                    msg = "Error: " + xhr.status + ". Check Controller view path.";
                }
                alert(msg);
            },
            complete: function() {
                // 3. ALWAYS reset the button state, even on error
                submitBtn.prop('disabled', false);
                btnText.removeClass('d-none');
                spinner.addClass('d-none');
            }
        });
    });
});
</script>
@endsection