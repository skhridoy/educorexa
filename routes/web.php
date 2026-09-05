<?php

use Illuminate\Support\Facades\Route;
use App\Models\School;
use App\Http\Controllers\{
    HomeController, SchoolRegisterController, SchoolWebsiteController,
    AuthController, DashboardController, AcademicYearController,
    SchoolCategoryController, StudentController, ClassesController,
    SectionController, SubjectController, AdmissionController,
    TeacherController, TeacherAssignSubjectController, ExamController,
    AssignClassController, MarkController, NewsletterController,
    ProfileController, NoticeController, AttendanceController,
    FeeHeadController, FeeAmountController, StudentFeeController, StudentFeeConcessionController,
    PaymentController, SliderController, AboutSectionController,
    FooterSettingController, SchoolOverviewController, LessonPlanController,
    HolidayController, ContactMessageController, SchoolSubCategoryController, 
    MainContactMsgController, ReviewController,
    RoutineController, SchoolSupportController, SchoolRoleController, SchoolStaffController,
    ExamRoutineController, InboundMessageController
};
use App\Http\Controllers\SuperAdmin\{
    FrontendSectionController, SuperAdminController, SettingController, RoleController, PermissionController,
    SubscriptionPackageController, TestimonialController, EmployeeController, EventController, SupportTicketController,
    BlogController, BlogCategoryController, IdCardDesignController
};

// Site Map 
Route::get('/sitemap.xml', function () {
    $baseUrl = rtrim(config('app.url'), '/');
    $mainDomain = config('app.main_domain');
    $schools = School::all();

    return response()->view('sitemap', compact('schools', 'baseUrl', 'mainDomain'))
        ->header('Content-Type', 'application/xml');
});
/*
|--------------------------------------------------------------------------
| Main Domain Routes
|--------------------------------------------------------------------------
*/
Route::domain(config('app.main_domain'))->group(function () {

    // --- Public Routes ---
    Route::get('/', [HomeController::class, 'index'])->name('main.home');
    Route::get('/features', [HomeController::class, 'features'])->name('main.features');
    Route::get('/why-us', [HomeController::class, 'whyUs'])->name('main.why-us');
    Route::get('/pricing', [HomeController::class, 'pricing'])->name('main.pricing');
    Route::get('/contact', [HomeController::class, 'contact'])->name('main.contact');
    
    Route::get('/about-details', function () {return view('frontend.page.about_details'); })->name('about.details');
    Route::get('/blogs', [HomeController::class, 'blogs'])->name('main.blogs');
    Route::get('/blog/{slug}', [HomeController::class, 'blogDetails'])->name('main.blog.details');
    Route::post('/contact-submit', [MainContactMsgController::class, 'store'])->name('contact.store');
    Route::get('/register-school', [SchoolRegisterController::class, 'create'])->name('school.register.form');
    Route::post('/register-school', [SchoolRegisterController::class, 'store'])->name('school.register.store');
    Route::get('/locations/divisions', [SchoolRegisterController::class, 'divisions'])->name('locations.divisions');
    Route::get('/locations/districts/{division}', [SchoolRegisterController::class, 'districts'])->name('locations.districts');
    Route::get('/locations/upazilas/{district}', [SchoolRegisterController::class, 'upazilas'])->name('locations.upazilas');
    Route::get('/forgot-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'resetPassword'])->name('password.update');

    Route::post('/main-newsletter-subscribe', [NewsletterController::class, 'mainSubscribe'])->name('main.newsletter.subscribe');
    Route::post('/webhooks/inbound-email', [InboundMessageController::class, 'webhook'])
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
        ->name('inbound.email.webhook');

    // Language Switcher Route
    Route::get('/set-locale/{lang}', function ($lang) {
        if (in_array($lang, ['en', 'bn'])) {
            session(['locale' => $lang]);
            cookie()->queue(cookie()->forever('locale', $lang));
        }
        return redirect()->back();
    })->name('set.locale');
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'mainLoginForm')->name('login.form'); 
        Route::post('/login', 'mainLogin')->name('login');        
        Route::match(['get', 'post'], '/logout', [AuthController::class, 'mainLogout'])->name('logout');     
    });

    // --- Dynamic Dashboard Redirector ---
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('super_admin') || $user->role === 'super_admin') {
            return redirect()->route('super.dashboard');
        } elseif ($user->hasRole('employee')) {
            return redirect()->route('employee.dashboard');
        } elseif ($user->hasRole('school_admin') || $user->role === 'school_admin') {
            $tenant = $user->school?->slug ?? '';
            return $tenant ? redirect()->route('school.dashboard', ['tenant' => $tenant]) : redirect('/');
        } elseif ($user->hasRole('teacher') || $user->role === 'teacher') {
            $tenant = $user->school?->slug ?? '';
            return $tenant ? redirect()->route('teacher.dashboard', ['tenant' => $tenant]) : redirect('/');
        } elseif ($user->hasRole('student') || $user->role === 'student') {
            $tenant = $user->school?->slug ?? '';
            return $tenant ? redirect()->route('student.dashboard', ['tenant' => $tenant]) : redirect('/');
        }
        return redirect('/');
    })->middleware('auth')->name('common.dashboard');

    Route::middleware(['auth', 'superadmin'])->group(function () {

        
        // --- Management Group (Prefix: manage, Name: manage.) ---
        Route::prefix('manage')->name('manage.')->group(function () {
            Route::get('/inbox', [InboundMessageController::class, 'superIndex'])->name('inbox.index');
            Route::get('/inbox/{id}', [InboundMessageController::class, 'show'])->name('inbox.show');
            Route::patch('/inbox/{id}', [InboundMessageController::class, 'update'])->name('inbox.update');
            Route::delete('/inbox/{id}', [InboundMessageController::class, 'destroy'])->name('inbox.destroy');
            
            // Schools Management
            Route::middleware(['permission:school.manage'])->group(function () {
                Route::get('/schools/all', [SuperAdminController::class, 'allSchools'])->name('schools.all');
                Route::get('/schools/pending', [SuperAdminController::class, 'pending'])->name('schools.pending');
                
                Route::middleware(['permission:school.create'])->group(function () {
                    Route::get('/schools/create', [SuperAdminController::class, 'createSchool'])->name('schools.create');
                    Route::post('/schools/create', [SuperAdminController::class, 'schoolStore'])->name('schools.store');
                });

                Route::middleware(['permission:school.delete'])->group(function () {
                    Route::delete('/schools/{school}', [SuperAdminController::class, 'destroy'])->name('schools.destroy');
                });
                Route::middleware(['permission:school.reject'])->group(function () {
                    Route::get('/schools/rejected', [SuperAdminController::class, 'rejected'])->name('schools.rejected');
                    Route::match(['post', 'delete'], '/schools/{school}/reject', [SuperAdminController::class, 'rejectSchool'])->name('schools.reject');
                });

                Route::middleware(['permission:school.approve'])->group(function () {
                    Route::match(['post', 'put'], '/schools/{school}/approve', [SuperAdminController::class, 'approve'])->name('schools.approve');
                });

                Route::post('/schools/{school}/change-package', [SuperAdminController::class, 'changePackage'])->name('schools.change-package');
            });

            // Contact Messages
            Route::middleware(['permission:contact.messages.view'])->group(function () {
                Route::get('/contact-messages', [MainContactMsgController::class, 'index'])->name('contact.index');
                Route::get('/contact-messages/{id}', [MainContactMsgController::class, 'show'])->name('contact.show');
                Route::delete('/contact-messages/{id}', [MainContactMsgController::class, 'destroy'])->name('contact.destroy');
            });

            // Professional Email Requests
            Route::get('/professional-emails', [SuperAdminController::class, 'emailRequests'])->name('pro-email.index');
            Route::post('/professional-emails/{school}/approve', [SuperAdminController::class, 'approveEmailRequest'])->name('pro-email.approve');
            Route::post('/professional-emails/{school}/reject', [SuperAdminController::class, 'rejectEmailRequest'])->name('pro-email.reject');
            Route::delete('/professional-emails/{school}/delete', [SuperAdminController::class, 'deleteEmailRequest'])->name('pro-email.delete');

            // Support Tickets
            Route::middleware(['permission:support.manage'])->group(function () {
                Route::get('/support-tickets', [SupportTicketController::class, 'index'])->name('support.index');
                Route::get('/support-tickets/{id}', [SupportTicketController::class, 'show'])->name('support.show');
                Route::post('/support-tickets/{id}/reply', [SupportTicketController::class, 'reply'])->name('support.reply');
                Route::get('/support-tickets/{id}/fetch-replies', [SupportTicketController::class, 'fetchReplies'])->name('support.fetch');
                Route::post('/support-tickets/{id}/status', [SupportTicketController::class, 'updateStatus'])->name('support.status');
            });

        });

        Route::middleware(['permission:settings.manage'])->group(function () {
            Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
            Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
            Route::get('/api-setup', [SettingController::class, 'apiSetup'])->name('settings.api');
            Route::post('/api-setup', [SettingController::class, 'updateApiSetup'])->name('settings.api.update');
            Route::get('/payment-setup', [SettingController::class, 'paymentSetup'])->name('settings.payment');
            Route::post('/payment-setup', [SettingController::class, 'updatePaymentSetup'])->name('settings.payment.update');
        });
        // Common Profile & Settings
        Route::get('/profile', [SuperAdminController::class, 'Profile'])->name('profile');
        Route::post('/profile/store', [SuperAdminController::class, 'ProfileStore'])->name('profile.store');

        Route::middleware(['permission:frontend.manage'])->prefix('manage/frontend')->name('manage.frontend.')->group(function () {
            // সেকশন লিস্ট দেখার জন্য
            Route::get('/manage-sections', [FrontendSectionController::class, 'index'])->name('index');
            
            // সেকশন স্ট্যাটাস আপডেট (AJAX)
            Route::post('/update-section-status', [FrontendSectionController::class, 'updateStatus'])->name('update.status');
            
            // সেকশন কন্টেন্ট এডিট করার জন্য (ঐচ্ছিক)
            Route::get('/edit-section/{id}', [FrontendSectionController::class, 'edit'])->name('edit');
            Route::post('/update-section/{id}', [FrontendSectionController::class, 'update'])->name('update');
        });
    });

    // --- 1. Super Admin ONLY Group ---
    Route::middleware(['auth', 'superadmin'])->prefix('super-admin')->name('super.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        
        // Roles & Employee Management (শুধু সুপার এডমিন পারবে)
        Route::middleware(['permission:super.roles.manage'])->group(function () {
            Route::resource('roles', RoleController::class);
            Route::resource('permissions', PermissionController::class);
        });
        Route::resource('employees', EmployeeController::class);
        Route::resource('subscription-packages', SubscriptionPackageController::class);
        Route::get('/subscription-payments', [\App\Http\Controllers\SuperAdmin\SchoolSubscriptionController::class, 'index'])->name('subscription-payments.index');
        Route::post('/subscription-payments/{subscription}/approve', [\App\Http\Controllers\SuperAdmin\SchoolSubscriptionController::class, 'approve'])->name('subscription-payments.approve');
        Route::post('/subscription-payments/{subscription}/reject', [\App\Http\Controllers\SuperAdmin\SchoolSubscriptionController::class, 'reject'])->name('subscription-payments.reject');
        Route::patch('testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggleStatus'])->name('testimonials.toggle');
        Route::resource('testimonials', TestimonialController::class);
        Route::resource('events', EventController::class);
        Route::patch('blogs/{blog}/toggle', [BlogController::class, 'toggleStatus'])->name('blogs.toggle');
        Route::resource('blogs', BlogController::class);
        Route::patch('blog-categories/{category}/toggle', [BlogCategoryController::class, 'toggleStatus'])->name('blog-categories.toggle');
        Route::resource('blog-categories', BlogCategoryController::class);

        // ID Card Designs
        Route::patch('id-card-designs/{idCardDesign}/toggle', [IdCardDesignController::class, 'toggleStatus'])->name('id-card-designs.toggle');
        Route::resource('id-card-designs', IdCardDesignController::class);
    });

    // --- 2. Employee ONLY Group ---
    Route::middleware(['auth'])->prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    });
});

/*
|--------------------------------------------------------------------------
| Tenant (School) Routes
|--------------------------------------------------------------------------
*/
// School Routes
Route::domain('{tenant}.' . config('app.main_domain'))
    ->middleware(['identify.school'])
    ->scopeBindings()
    ->group(function () {

            // Language Switcher for School Tenant
            Route::get('/set-locale/{lang}', function ($tenant, $lang) {
                if (in_array($lang, ['en', 'bn'])) {
                    session(['locale' => $lang]);
                    cookie()->queue(cookie()->forever('locale', $lang));
                }
                return redirect()->back();
            })->name('school.set.locale');

            Route::get('exam-routine/subjects-by-class/{classId}', [ExamRoutineController::class, 'subjectsByClass'])->name('exam.routine.subjects.by.class');
            Route::get('/', [SchoolWebsiteController::class, 'home'])->name('school.home');
            Route::get('/locations/divisions', [SchoolRegisterController::class, 'divisions'])->name('school.locations.divisions');
            Route::get('/locations/districts/{division}', [SchoolRegisterController::class, 'districts'])->name('school.locations.districts');
            Route::get('/locations/upazilas/{district}', [SchoolRegisterController::class, 'upazilas'])->name('school.locations.upazilas');
            // Duplicate DELETE route removed (handled in auth middleware group)

            // Login Form
            Route::get('/login', [AuthController::class, 'loginForm'])
                ->name('school.login.form');

            Route::post('/login', [AuthController::class, 'login'])->name('school.login');

            // Password Reset Routes
            Route::get('/forgot-password', [App\Http\Controllers\Auth\SchoolPasswordResetController::class, 'showForgotPasswordForm'])->name('school.password.request');
            Route::post('/forgot-password', [App\Http\Controllers\Auth\SchoolPasswordResetController::class, 'sendOtp'])->name('school.password.otp');
            Route::get('/verify-otp', [App\Http\Controllers\Auth\SchoolPasswordResetController::class, 'showVerifyOtpForm'])->name('school.password.verify.form');
            Route::post('/verify-otp', [App\Http\Controllers\Auth\SchoolPasswordResetController::class, 'verifyOtp'])->name('school.password.verify');
            Route::get('/reset-password', [App\Http\Controllers\Auth\SchoolPasswordResetController::class, 'showResetPasswordForm'])->name('school.password.reset');
            Route::post('/reset-password', [App\Http\Controllers\Auth\SchoolPasswordResetController::class, 'resetPassword'])->name('school.password.update');

            Route::get('/admission', [AdmissionController::class, 'create'])->name('admission.create');
            Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store');
            Route::get('/admission/pdf/{id}', [AdmissionController::class, 'downloadPdf'])->name('admissions.pdf');
            Route::get('/admission/search-by-phone', [AdmissionController::class, 'searchByPhone'])->name('admissions.searchByPhone');
            Route::post('/newsletter-subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

            Route::post('/contact/send', [SchoolWebsiteController::class, 'storeMessage'])->name('school.contact.store');
            // Result Route 
            Route::get('/result', [SchoolWebsiteController::class, 'resultPage'])->name('frontend.result_page');
            Route::get('/notice', [\App\Http\Controllers\NoticeController::class, 'publicIndex'])->name('frontend.notice');
            Route::post('/search-result', [MarkController::class, 'publicResult'])->name('frontend.search_result');
            Route::get('/download-marksheet/{studentId}/{classId}/{examId}', [MarkController::class, 'generateMarksheet'])->name('frontend.generate_marksheet');
            Route::get('/exams-by-category', [SchoolWebsiteController::class, 'examsByCategory'])->name('frontend.exams_by_category');
            Route::get('/classes-by-category', [SchoolWebsiteController::class, 'classesByCategory'])->name('frontend.classes_by_category');

            // Protected Routes
            Route::middleware(['auth'])->group(function () {
                // শিক্ষার্থীর জন্য নির্দিষ্ট রাউট
                Route::middleware(['is_student'])->group(function () {
                    // এই রাউটটিই আপনার তৈরি করা studentDashboard মেথডকে কল করবে
                    Route::get('/student/dashboard', [StudentController::class, 'studentDashboard'])
                        ->name('student.dashboard');
                });

                // শিক্ষকদের জন্য নির্দিষ্ট রাউট
                Route::middleware(['is_teacher'])->group(function () {
                    Route::get('/teacher/dashboard', [TeacherController::class, 'teacherDashboard'])
                        ->name('teacher.dashboard');
                });


                // বাকি কমন ড্যাশবোর্ড (অ্যাডমিন বা অন্যদের জন্য)
                Route::middleware(['is_admin'])->group(function () {
                    Route::get('admin/dashboard', [DashboardController::class, 'index'])
                        ->name('school.dashboard');
                    Route::get('admin/pricing', [DashboardController::class, 'pricing'])->name('school.pricing');
                    Route::get('admin/subscription-payment', [\App\Http\Controllers\SchoolSubscriptionController::class, 'create'])->name('school.subscription-payment.create');
                    Route::post('admin/subscription-payment', [\App\Http\Controllers\SchoolSubscriptionController::class, 'store'])->name('school.subscription-payment.store');
                    Route::post('admin/upgrade', [DashboardController::class, 'upgradeRequest'])->name('school.upgrade.request');
                    Route::get('admin/review/create', [ReviewController::class, 'create'])->name('school.review.create');
                    Route::post('admin/review/store', [ReviewController::class, 'store'])->name('school.review.store');
                    
                    // Contact Messages
                    Route::get('admin/messages', [ContactMessageController::class, 'index'])->name('admin.messages.index');
                    Route::get('admin/messages/{id}', [ContactMessageController::class, 'show'])->name('admin.messages.show');
                    Route::delete('admin/messages/{id}', [ContactMessageController::class, 'destroy'])->name('admin.messages.destroy');
                    Route::get('admin/inbox', [InboundMessageController::class, 'schoolIndex'])->name('school.inbox.index');
                    Route::get('admin/inbox/{id}', [InboundMessageController::class, 'show'])->name('school.inbox.show');
                    Route::patch('admin/inbox/{id}', [InboundMessageController::class, 'update'])->name('school.inbox.update');
                    Route::delete('admin/inbox/{id}', [InboundMessageController::class, 'destroy'])->name('school.inbox.destroy');
                    // Support Tickets
                    Route::get('admin/support', [SchoolSupportController::class, 'index'])->name('school.support.index');
                    Route::get('admin/support/create', [SchoolSupportController::class, 'create'])->name('school.support.create');
                    Route::post('admin/support/store', [SchoolSupportController::class, 'store'])->name('school.support.store');
                    Route::get('admin/support/{id}', [SchoolSupportController::class, 'show'])->name('school.support.show');
                    Route::post('admin/support/{id}/reply', [SchoolSupportController::class, 'reply'])->name('school.support.reply');
                    Route::get('admin/support/{id}/fetch-replies', [SchoolSupportController::class, 'fetchReplies'])->name('school.support.fetch');
                });
                Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
                Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('user.profile.update');

                Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('user.password.update');
                Route::get('/get-attendance-chart-data', [DashboardController::class, 'getAttendanceChartData'])->name('get.attendance.chart.data');
                Route::get('/fee-filter', [DashboardController::class, 'filterFee'])->name('school.fee.filter');
                Route::get('/get-unpaid-list', [DashboardController::class, 'getUnpaidList'])->name('school.unpaid.ajax');
                Route::post('/send-unpaid-reminder/{id}', [DashboardController::class, 'sendFeeReminder'])->name('school.unpaid.remind');


                Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('school.logout');
                Route::middleware(['auth', 'permission:system.settings'])->group(function () {
                    Route::get('/school-settings/school-info', [SchoolRegisterController::class, 'edit'])->name('admin.school.info-edit');
                    Route::post('/school-settings/info-update', [SchoolRegisterController::class, 'update'])->name('admin.school.info-update');
                    
                    // API Setup (Email & WhatsApp)
                    Route::get('/school-settings/api-setup', [App\Http\Controllers\SchoolSettingController::class, 'apiSetup'])->name('admin.school.api-setup');
                    Route::post('/school-settings/api-setup', [App\Http\Controllers\SchoolSettingController::class, 'updateApiSetup'])->name('admin.school.api-setup.update');
                    Route::post('/school-settings/pro-email-request', [App\Http\Controllers\SchoolSettingController::class, 'requestProfessionalEmail'])->name('admin.school.pro-email.request');
                    
                    // Communication Settings
                    Route::get('/school-settings/communication', [App\Http\Controllers\SchoolSettingController::class, 'communicationSetup'])->name('admin.school.communication');
                    Route::post('/school-settings/communication', [App\Http\Controllers\SchoolSettingController::class, 'updateCommunicationSetup'])->name('admin.school.communication.update');

                    // School Roles Management
                    Route::middleware(['permission:system.settings'])->group(function () {
                        Route::resource('roles', SchoolRoleController::class)->names('school.roles');
                    });
                });
                // Academic
                Route::middleware(['auth', 'permission:academic-year.manage', 'school_package:academic-year.manage'])->group(function () {

                    Route::resource('academic-year', AcademicYearController::class)->parameters([
                        'academic-year' => 'academic_year'
                    ])->names('academic-year');
                    Route::post('/academic-year/{academic_year}/toggle-active', [AcademicYearController::class, 'toggleActive'])
                        ->name('academic-year.toggleActive');
                    Route::post('/academic-year/{academic_year}/toggle-inactive', [AcademicYearController::class, 'toggleInactive'])
                        ->name('academic-year.toggleInactive');
                });

                // Routine
                Route::middleware(['auth', 'permission:class.routine', 'school_package:class.routine'])->group(function () {
                    Route::get('get-subjects/{classId}', [RoutineController::class, 'getSubjects'])->name('getSubjects');
                    Route::resource('routine', RoutineController::class);
                });

                // Categories
                Route::middleware(['permission:category.manage'])->group(function () {
                    Route::get('/categories', [SchoolCategoryController::class, 'index'])->name('categories.index');
                    Route::resource('categories', SchoolCategoryController::class);
                });
                // Sub Categories
                Route::middleware(['permission:sub-category.manage'])->group(function () {
                    
                    Route::resource('sub-categories', SchoolSubCategoryController::class);
                });
                // Newsletter 
    
                // Classes
                Route::middleware(['auth', 'permission:class.manage', 'school_package:class.manage'])->group(function () {

                    Route::resource('classes', ClassesController::class);
                });

                // Notice CRUD
                Route::middleware(['auth', 'permission:notice.manage', 'school_package:notice.manage'])->group(function () {
                    Route::resource('notices', NoticeController::class);
                    Route::post('notices/{id}/send', [NoticeController::class, 'sendToStudents'])->name('notices.send');
                });

                // Sections
                Route::middleware(['auth', 'permission:section.manage', 'school_package:section.manage'])->group(function () {
                    Route::resource('sections', SectionController::class);
                });

                // Subjects
                Route::middleware(['auth', 'permission:subject.manage', 'school_package:subject.manage'])->group(function () {
                    Route::get('/subjects-assign', [AssignClassController::class, 'index'])->name('subjects.assign');
                    Route::post('/subjects-assign', [AssignClassController::class, 'store'])->name('subjects.assign.store');
                    Route::delete('/subjects-assign/{assignment}', [AssignClassController::class, 'destroy'])->name('subjects.assign.destroy');
                    Route::get('/subjects-assign/{assignment}', [AssignClassController::class, 'edit'])->name('subjects.assign.edit');
                    Route::put('/subjects-assign/{assignment}', [AssignClassController::class, 'update'])->name('subjects.assign.update');
                    Route::get('/get-subjects-by-class/{classId}', [AssignClassController::class, 'getSubjectsByClass'])->name('get.subjects.by.class');
                    Route::resource('subjects', SubjectController::class);

                });

                // Students
                Route::middleware(['auth', 'permission:student.manage', 'school_package:student.manage'])->group(function () {
                    Route::get('get-subcategories/{categoryId}', [StudentController::class, 'getSubCategories'])->name('get.subcategories');
                    Route::get('students/import', [StudentController::class, 'importForm'])->name('students.importForm');
                    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
                    Route::get('students/export', [StudentController::class, 'exportForm'])->name('students.exportForm');
                    Route::post('students/export', [StudentController::class, 'export'])->name('students.export');
                    Route::get('students/download-template', [StudentController::class, 'downloadTemplate'])->name('students.downloadTemplate');
                    
                    Route::prefix('students/id-cards')->group(function () {
                        Route::middleware('permission:student.idcard')->group(function () {
                            Route::get('/', [StudentController::class, 'idCardIndex'])->name('students.idcard.index');
                            Route::get('/preview', [StudentController::class, 'idCardPreview'])->name('students.idcard.preview');
                            Route::get('/download/{class_id}', [StudentController::class, 'idCardDownload'])->name('students.idcard.download');
                        });
                    });
                    
                    Route::middleware('permission:student.promotion')->group(function () {
                    Route::get('/students/promotion', [MarkController::class, 'promotionForm'])->name('students.promotion');
                    Route::post('/students/promote', [MarkController::class, 'promoteStudents'])->name('students.promote');
                    });
                    Route::resource('students', StudentController::class);
                });

                // Admissions 
    
                Route::get('/admissions', [AdmissionController::class, 'index'])
                    ->name('admissions.index');
                Route::post('/admissions/update-settings', [AdmissionController::class, 'updateSettings'])->name('admissions.updateSettings');
                Route::post('/admissions/bulk-approve', [AdmissionController::class, 'bulkApprove'])->name('admissions.bulk-approve');
                Route::post('/admissions/{admission}/approve', [AdmissionController::class, 'approve'])->name('admissions.approve');
                Route::post(
                    '/admissions/{admission}/reject',
                    [AdmissionController::class, 'reject']
                )->name('admissions.reject');

                Route::delete(
                    '/admissions/{admission}',
                    [AdmissionController::class, 'destroy']
                )->name('admissions.destroy');

                // Teacher Routes (to be implemented)
    
                Route::middleware(['auth', 'permission:teacher.manage', 'school_package:teacher.manage'])->group(function () {
                    // Define teacher management routes here
                    Route::get('/teacher-assign', [TeacherAssignSubjectController::class, 'index'])->name('teacher.assign');

                    Route::post('/teacher-assign', [TeacherAssignSubjectController::class, 'store'])->name('teacher.assign.store');

                    Route::delete('/teacher-assign/{assignment}', [TeacherAssignSubjectController::class, 'destroy'])->name('teacher.assign.destroy');
                    Route::get('/teachers/demo-download', [TeacherController::class, 'downloadDemo'])->name('teachers.demo');
                    Route::post('/teachers/import-excel', [TeacherController::class, 'importExcel'])->name('teachers.import');
                    Route::resource('teachers', TeacherController::class);
                });

                Route::middleware(['auth', 'permission:employee.manage', 'school_package:employee.manage'])->group(function () {
                    Route::resource('staff', SchoolStaffController::class);
                });

                Route::middleware(['auth', 'permission:exam.manage', 'school_package:exam.manage'])->group(function () {
                    Route::post('exams/clone-year', [ExamController::class, 'cloneFromYear'])->name('exams.clone-year');
                    Route::post('exams/bulk-generate', [ExamController::class, 'bulkGenerate'])->name('exams.bulk-generate');
                    Route::get('exams/get-by-year/{yearId}', [ExamController::class, 'getExamsByYear'])->name('exams.by-year');
                    Route::post('exams/{exam}/status', [ExamController::class, 'toggleStatus'])->name('exams.status');
                    Route::get('exams/admit-card', [ExamController::class, 'generateAdmitIndex'])->name('exams.admit-card');
                    Route::get('exams/bulk-admit-card', [ExamController::class, 'bulkAdmitCard'])->name('exam.bulk_admit_card');
                    Route::post('/exams/{exam}/publish', [ExamController::class, 'publishResult'])->name('exams.publish');
                    Route::resource('exams', ExamController::class);

                    // Exam Routine
                    Route::get('exam-routine', [ExamRoutineController::class, 'index'])->name('exam.routine.index');
                    Route::post('exam-routine', [ExamRoutineController::class, 'store'])->name('exam.routine.store');
                    Route::post('exam-routine/delete-all', [ExamRoutineController::class, 'destroyAll'])->name('exam.routine.destroyAll');
                    Route::delete('exam-routine/{id?}', [ExamRoutineController::class, 'destroy'])->name('exam.routine.destroy');
                    Route::get('exam-routine/filter-data', [ExamRoutineController::class, 'getFilterData'])->name('exam.routine.filter.data');
                });

                Route::middleware(['auth', 'permission:mark.manage', 'school_package:mark.manage'])->group(function () {
                    Route::post('find-subject', [MarkController::class, 'findSubject'])->name('marks.findSubject');
                    Route::post('marks-autosave', [MarkController::class, 'autoSave'])->name('marks.autosave');
                    Route::post('marks-status', [MarkController::class, 'statusUpdate'])->name('marks.statusUpdate');

                    Route::get('marks-view', [MarkController::class, 'viewMarks'])->name('marks.view-marks');
                    Route::get('marksheet/{student}/{class}/{exam}',[MarkController::class, 'generateMarksheet'])->name('marks.marksheet');
                    Route::get('bulk-marksheet/{class}/{exam}', [MarkController::class, 'generateBulkMarksheet'])->name('marks.bulk-marksheet');
                    Route::get('download-result-sheet', [MarkController::class, 'downloadResultSheet'])->name('marks.download-sheet');
                    Route::get('exam-result-summary', [MarkController::class, 'downloadExamResultSummary'])->name('marks.result-summary');

                    // Mark Import routes
                    Route::get('marks-import',          [MarkController::class, 'importForm'])->name('marks.import.form');
                    Route::post('marks-import',         [MarkController::class, 'import'])->name('marks.import');
                    Route::get('marks-import/template', [MarkController::class, 'downloadMarkTemplate'])->name('marks.import.template');

                    // Result Search Panel
                    Route::get('result-search',         [MarkController::class, 'resultSearchIndex'])->name('marks.result-search');
                    Route::post('result-search',        [MarkController::class, 'resultSearchQuery'])->name('marks.result-search-query');

                    Route::resource('marks', MarkController::class);
                });

                
                // Lesson Plan
                // ১. এটি শিক্ষক বা যারা ডায়েরি ম্যানেজ করতে পারেন তাদের জন্য
                Route::middleware('permission:lesson.manage')->group(function () {
                    Route::get('/get-subjects/{class_id}', [LessonPlanController::class, 'getSubjects'])->name('get.subjects');
                    Route::resource('diary', LessonPlanController::class);
                });

                // ২. এটি স্টুডেন্ট বা যারা শুধু ডায়েরি দেখতে পাবেন তাদের জন্য
                // নোট: এটি অবশ্যই lesson.manage গ্রুপের বাইরে আলাদাভাবে থাকবে
                Route::middleware('permission:lesson.view')->group(function () {
                    Route::get('diary/view/student', [LessonPlanController::class, 'studentView'])->name('diary.student_view');
                });
                Route::middleware('permission:holiday.manage')->group(function(){
                    Route::get('holidays', [HolidayController::class, 'index'])->name('holidays.index');
                    Route::post('holidays', [HolidayController::class, 'store'])->name('holidays.store');
                    Route::delete('holidays/{id}', [HolidayController::class, 'destroy'])->name('holidays.destroy');
                });
                Route::middleware(['auth', 'permission:attendance.analytics|attendance.manage', 'school_package:attendance.manage'])->group(function () {
                    Route::get('/attendance/analytics', [AttendanceController::class, 'analytics'])->name('attendance.analytics');
                });
                Route::middleware(['auth', 'permission:attendance.manage', 'school_package:attendance.manage'])->group(function () {
                    // Route::get('students/search-ajax', [AttendanceController::class, 'searchAjax'])->name('students.search_ajax');
                    Route::get('/attendance/qr-scan', [AttendanceController::class, 'qrScan'])->name('attendance.qr.scan');
                    Route::post('/attendance/qr-scan/record', [AttendanceController::class, 'recordQrAttendance'])->name('attendance.qr.record');
                    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('student.attendance.report');
                    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendances.index');
                    Route::post('/attendance-save', [AttendanceController::class, 'store'])->name('attendances.store');
                });

                Route::middleware(['auth', 'permission:fee.manage', 'school_package:fee.manage'])->group(function () {
                    Route::resource('fee-heads', FeeHeadController::class);
                    Route::get('/get-sub-categories/{categoryId}', [FeeAmountController::class, 'getSubCategories'])->name('get-sub-categories');
                    Route::get('/get-classes-by-category', [FeeAmountController::class, 'getClassesByCategory'])->name('get-classes-by-category');
                    Route::resource('fee-amounts', FeeAmountController::class);
                    Route::get('student-fees/get-list', [StudentFeeController::class, 'getStudentList'])->name('student-fees.get-list');
                    Route::resource('student-fees', StudentFeeController::class);
                    Route::get('student-fee-concessions/search-student', [StudentFeeConcessionController::class, 'searchStudent'])->name('student-fee-concessions.search-student');
                    Route::resource('student-fee-concessions', StudentFeeConcessionController::class);
                });

                Route::middleware(['auth', 'permission:fee.collect', 'school_package:fee.collect'])->group(function () {
                    Route::get('collect-payment', [PaymentController::class, 'index'])->name('payment.index');
                    Route::post('collect-payment-multiple', [PaymentController::class, 'collectMultiple'])->name('payment.collectMultiple');
                    Route::post('collect-payment/{id}', [PaymentController::class, 'collect'])->name('payment.collect');
                    Route::get('payment-receipt-multiple/{receipt_no}', [PaymentController::class, 'downloadReceiptMultiple'])->name('payment.receiptMultiple');
                    Route::get('payment-receipt/{id}', [PaymentController::class, 'downloadReceipt'])->name('payment.receipt');
                });

                // Slider CRUD
                Route::middleware('permission:system.settings')->group(function () {

                    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
                    Route::post('/sliders', [SliderController::class, 'store'])->name('sliders.store');
                    Route::get('/sliders/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
                    Route::put('/sliders/{id}', [SliderController::class, 'update'])->name('sliders.update');
                    Route::delete('/sliders/{id}', [SliderController::class, 'destroy'])->name('sliders.destroy');
                    Route::get('/about-settings', [AboutSectionController::class, 'index'])->name('about.index');
                    Route::post('/about-settings', [AboutSectionController::class, 'update'])->name('about.update');
                    Route::get('/settings/footer', [FooterSettingController::class, 'edit'])->name('footer.edit');
                    Route::put('/settings/footer', [FooterSettingController::class, 'update'])->name('footer.update');

                });

                Route::middleware('permission:system.settings')->group(function () {
                    Route::resource('overview', SchoolOverviewController::class);
                });

                // Newsletter 
                Route::middleware('permission:newsletter.manage')->group(function () {

                    Route::get('/admin/newsletter', [NewsletterController::class, 'index'])->name('admin.newsletter.index');
                    Route::delete('/admin/newsletter/{id}', [NewsletterController::class, 'destroy'])->name('admin.newsletter.destroy');

                    Route::get('/admin/newsletter/send', [NewsletterController::class, 'createMail'])->name('admin.newsletter.send');
                    Route::post('/admin/newsletter/send', [NewsletterController::class, 'sendMail'])->name('admin.newsletter.store_mail');
                });
                // Newsletter 
                Route::middleware('permission:message.manage')->group(function () {

                    Route::get('/admin/message', [ContactMessageController::class, 'index'])->name('admin.message.index');
                    Route::delete('/admin/message/{id}', [ContactMessageController::class, 'destroy'])->name('admin.message.destroy');

                    
                });
            });

        // Upgrade Plan
        Route::get('/upgrade', function(School $currentSchool) {
            $packages = \App\Models\SubscriptionPackage::where('is_active', true)->orderBy('price', 'asc')->get();
            return view('school.upgrade', compact('packages', 'currentSchool'));
        })->name('school.upgrade');

        });

Route::get('/run-migration', function () {
    try {
        // 1. Run Standard Migrations
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();

        // 2. Manually ensure professional email columns exist (Force Fix for XAMPP issues)
        if (\Illuminate\Support\Facades\Schema::hasTable('schools')) {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('schools', 'pro_email_status')) {
                \Illuminate\Support\Facades\Schema::table('schools', function ($table) {
                    $table->enum('pro_email_status', ['none', 'pending', 'approved', 'rejected'])->default('none')->after('email');
                    $table->string('pro_email_address')->nullable()->after('pro_email_status');
                    $table->string('pro_email_password')->nullable()->after('pro_email_address');
                    $table->string('pro_email_prefix')->nullable()->after('pro_email_password');
                });
                $output .= "\n[SUCCESS] Manually added professional email columns to 'schools' table.";
            } else {
                $output .= "\n[INFO] Professional email columns already exist.";
            }
        } else {
            $output .= "\n[ERROR] 'schools' table not found. Please run full migration.";
        }

        return "<div style='padding:20px; font-family:monospace; background:#f4f4f4; border:1px solid #ddd;'><h3>Migration System Status</h3><pre>" . $output . "</pre><a href='/manage/professional-emails' style='color:blue;'>Go to Email Management</a></div>";
    } catch (\Exception $e) {
        return "Migration failed: " . $e->getMessage();
    }
});

Route::get('/view-logs', function () {
    $logFile = storage_path('logs/laravel.log');
    if (!file_exists($logFile)) {
        return 'No log file found.';
    }
    $lines = file($logFile);
    return implode('<br>', array_slice($lines, -100));
});

Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return 'All caches cleared successfully!';
});