@extends('school.website.layouts.app')

@section('customCSS')
<style>
    .result-section {
        background: linear-gradient(135deg, #002147 0%, #003366 100%);
        min-height: 250px;
        color: white;
        border-bottom-left-radius: 40px;
        border-bottom-right-radius: 40px;
    }
    .result-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.03);
        margin-top: -80px;
        z-index: 10;
        position: relative;
    }
    .premium-input {
        background: #f8fafc !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: none !important;
        transition: all 0.3s ease;
        padding: 15px 20px !important;
        font-size: 16px;
    }
    .premium-input:focus {
        background: #ffffff !important;
        border-color: #F9B800 !important;
        box-shadow: 0 0 0 4px rgba(249, 184, 0, 0.1) !important;
    }
    .premium-btn {
        background: #F9B800;
        color: #002147;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        padding: 15px 30px;
        font-size: 16px;
    }
    .premium-btn:hover {
        background: #e0a500;
        color: #002147;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(249, 184, 0, 0.2);
    }
    .result-box-container {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
</style>
@endsection

@section('content')
<!-- Header Area -->
<div class="container-fluid result-section py-5 d-flex align-items-center">
    <div class="container text-center pt-5">
        <h1 class="display-5 text-white fw-bold wow fadeInUp" data-wow-delay="0.1s" style="font-family: 'Outfit', sans-serif;">Check Examination Results</h1>
        <p class="text-white-50 fs-5 mb-0 wow fadeInUp" data-wow-delay="0.2s">Get instant access to your academic transcripts and mark sheets online</p>
    </div>
</div>

<!-- Form & Results Area -->
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="result-card p-4 p-md-5 wow fadeInUp" data-wow-delay="0.3s">
                <div class="text-center mb-4">
                    <span class="badge bg-gold text-navy px-3 py-2 rounded-pill fw-bold text-uppercase" style="letter-spacing: 1px;">Search Panel</span>
                </div>

                <form id="resultSearchFormPage" class="row g-3 align-items-center">
                    @csrf
                    <div class="col-md-9">
                        <div class="form-floating">
                            <input type="text" name="student_id" class="form-control premium-input" id="student_id_val" placeholder="Student ID (e.g. STD-261002)" required>
                            <label for="student_id_val"><i class="fas fa-id-card me-2 text-muted"></i>Student ID (e.g. STD-261002)</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn premium-btn w-100 py-3 text-uppercase" type="submit" id="submitBtnPage">
                            <span class="btn-text"><i class="fas fa-search me-2"></i>Search</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>

                <!-- Result Content placeholder -->
                <div class="mt-5 d-none" id="resultDisplayArea">
                    <div id="resultContainer">
                        <!-- Result view will load here -->
                    </div>
                </div>

                <!-- Info Alert if not searched -->
                <div class="alert alert-light border-0 py-4 text-center mt-5" id="initialSearchAlert" style="background: #f8fafc; border-radius: 15px;">
                    <i class="fas fa-info-circle fa-2x text-muted mb-3"></i>
                    <p class="mb-0 text-muted fw-semibold">অনুগ্রহ করে শিক্ষার্থীর আইডি নম্বরটি দিয়ে উপরের বক্সে সার্চ করুন।</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
$(document).ready(function() {
    $('#resultSearchFormPage').on('submit', function(e) {
        e.preventDefault();
        let studentId = $('#student_id_val').val().trim();
        if(!studentId) return;

        let submitBtn = $('#submitBtnPage');
        let spinner = submitBtn.find('.spinner-border');
        let btnText = submitBtn.find('.btn-text');
        
        let initialAlert = $('#initialSearchAlert');
        let displayArea = $('#resultDisplayArea');
        let container = $('#resultContainer');

        submitBtn.prop('disabled', true);
        btnText.addClass('d-none');
        spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('frontend.search_result', ['tenant' => $school->slug]) }}",
            method: "POST",
            data: { _token: "{{ csrf_token() }}", student_id: studentId },
            success: function(response) {
                if(typeof response === 'object') {
                    if(response.status) {
                        container.html(response.data);
                        initialAlert.addClass('d-none');
                        displayArea.removeClass('d-none');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || "Result not found.",
                        });
                    }
                } else {
                    container.html(response);
                    initialAlert.addClass('d-none');
                    displayArea.removeClass('d-none');
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Search Failed',
                    text: 'ক্ষমা করবেন! এই আইডি দিয়ে কোনো ফলাফল পাওয়া যায়নি। অনুগ্রহ করে সঠিক আইডি দিয়ে চেষ্টা করুন।'
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                btnText.removeClass('d-none');
                spinner.addClass('d-none');
            }
        });
    });
});
</script>
<!-- Include SweetAlert2 from CDN for premium alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
