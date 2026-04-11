<?php

use App\Http\Controllers\SchoolSubCategoryController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    HomeController,
    SchoolRegisterController,
    SchoolWebsiteController,
    AuthController,
    DashboardController,
    AcademicYearController,
    SchoolCategoryController,
    StudentController,
    ClassesController,
    SectionController,
    SubjectController,
    AdmissionController,
    TeacherController,
    TeacherAssignSubjectController,
    ExamController,
    AssignClassController,
    MarkController,
    NewsletterController,
    ProfileController,
    NoticeController,
    AttendanceController,
    FeeHeadController,
    FeeAmountController,
    StudentFeeController,
    PaymentController,
    SliderController,
    AboutSectionController,
    FooterSettingController,
    SchoolOverviewController,
    LessonPlanController,
    HolidayController
};
use App\Http\Controllers\SuperAdmin\{
    SuperAdminController,
    RoleController,
    PermissionController,
    SettingController
};

Route::domain(config('app.main_domain'))->group(function () {

    /*
    |----------------------------------
    | Public Routes
    |----------------------------------
    */
    Route::get('/', [HomeController::class, 'index'])->name('main.home');

    Route::get('/register-school', [SchoolRegisterController::class, 'create'])
        ->name('school.register.form');

    Route::post('/register-school', [SchoolRegisterController::class, 'store'])
        ->name('school.register.store');


    /*
    |----------------------------------
    | Super Admin Routes
    |----------------------------------
    */
    Route::prefix('super-admin')
        ->name('super.')
        ->group(function () {

            // Auth
            Route::controller(AuthController::class)->group(function () {
                Route::get('/login', 'superLoginForm')->name('login.form');
                Route::post('/login', 'superLogin')->name('login');
                Route::post('/logout', 'superLogout')->name('logout');
            });

            // Protected Routes
            Route::middleware(['auth', 'superadmin'])->group(function () {

                Route::controller(SuperAdminController::class)->group(function () {

                    Route::get('/dashboard', 'dashboard')->name('dashboard');

                    Route::prefix('schools')->name('schools.')->group(function () {

                        Route::get('/create', 'createSchool')->name('create');
                        Route::post('/create', 'schoolStore')->name('store');
                        Route::get('/pending', 'pending')->name('pending');
                        Route::put('/{school}/approve', 'approve')->name('approve');
                        Route::get('/rejected', 'rejected')->name('rejected');
                        Route::post('/{school}/reject', 'rejectSchool')->name('reject');
                        Route::delete('/{school}', 'destroy')->name('destroy');
                        Route::get('/all-school', 'allSchools')->name('all');
                    });
                    Route::get('/notifications/read-all', [SuperAdminController::class, 'markNotificationsRead'])->name('notifications.readAll');
                    Route::resource('roles', RoleController::class);
                    Route::resource('permissions', PermissionController::class);
                });

                Route::get('profile', [SuperAdminController::class, 'Profile'])->name('profile');
                Route::post('profile/store', [SuperAdminController::class, 'ProfileStore'])->name('profile.store');

                Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
                Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

                
            });
        });


    // School Routes
    Route::domain('{tenant}.' . config('app.main_domain'))
        ->middleware(['identify.school'])
        ->scopeBindings()
        ->group(function () {

            Route::get('/', [SchoolWebsiteController::class, 'home'])->name('school.home');
            Route::get('/about-us', [SchoolWebsiteController::class, 'about'])->name('school.about');

            // Login Form
            Route::get('/login', [AuthController::class, 'loginForm'])
                ->name('school.login.form');

            Route::post('/login', [AuthController::class, 'login'])->name('school.login');

            Route::get('/admission', [AdmissionController::class, 'create'])->name('admission.create');

            Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store');
            Route::post('/newsletter-subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

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
                });
                Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
                Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('user.profile.update');

                Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('user.password.update');
                Route::get('/get-attendance-chart-data', [DashboardController::class, 'getAttendanceChartData'])->name('get.attendance.chart.data');
                Route::get('/fee-filter', [DashboardController::class, 'filterFee'])->name('school.fee.filter');
                Route::get('/get-unpaid-list', [DashboardController::class, 'getUnpaidList'])->name('school.unpaid.ajax');


                Route::get('/logout', [AuthController::class, 'logout'])->name('school.logout');
                Route::middleware(['auth', 'permission:system.settings'])->group(function () {
                    Route::get('/school-settings/school-info', [SchoolRegisterController::class, 'edit'])->name('admin.school.info-edit');
                    // আপডেট করার জন্য
                    Route::post('/school-settings/info-update', [SchoolRegisterController::class, 'update'])->name('admin.school.info-update');
                });
                // Academic
                Route::middleware(['auth', 'permission:academic-year.manage'])->group(function () {

                    Route::resource('academic-year', AcademicYearController::class)->parameters([
                        'academic-year' => 'academic_year'
                    ])->names('academic-year');
                    Route::post('/academic-year/{academic_year}/toggle-active', [AcademicYearController::class, 'toggleActive'])
                        ->name('academic-year.toggleActive');
                    Route::post('/academic-year/{academic_year}/toggle-inactive', [AcademicYearController::class, 'toggleInactive'])
                        ->name('academic-year.toggleInactive');
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
                Route::middleware('permission:class.manage')->group(function () {

                    Route::resource('classes', ClassesController::class);
                });

                // Notice CRUD
                Route::middleware('permission:notice.manage')->group(function () {

                    Route::resource('notices', NoticeController::class);
                });

                // Sections
                Route::middleware('permission:section.manage')->group(function () {
                    Route::resource('sections', SectionController::class);
                });

                // Subjects
                Route::middleware('permission:subject.manage')->group(function () {
                    Route::get('/subjects-assign', [AssignClassController::class, 'index'])->name('subjects.assign');
                    Route::post('/subjects-assign', [AssignClassController::class, 'store'])->name('subjects.assign.store');
                    Route::delete('/subjects-assign/{assignment}', [AssignClassController::class, 'destroy'])->name('subjects.assign.destroy');
                    Route::get('/subjects-assign/{assignment}', [AssignClassController::class, 'edit'])->name('subjects.assign.edit');
                    Route::put('/subjects-assign/{assignment}', [AssignClassController::class, 'update'])->name('subjects.assign.update');
                    Route::resource('subjects', SubjectController::class);

                });

                // Students
                Route::middleware('permission:student.manage')->group(function () {
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
                            Route::get('/print/{class_id}', [StudentController::class, 'idCardPrint'])->name('students.idcard.print');
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
    
                Route::middleware('permission:teacher.manage')->group(function () {
                    // Define teacher management routes here
                    Route::get('/teacher-assign', [TeacherAssignSubjectController::class, 'index'])->name('teacher.assign');

                    Route::post('/teacher-assign', [TeacherAssignSubjectController::class, 'store'])->name('teacher.assign.store');

                    Route::delete('/teacher-assign/{assignment}', [TeacherAssignSubjectController::class, 'destroy'])->name('teacher.assign.destroy');
                    Route::resource('teachers', TeacherController::class);
                });

                Route::middleware('permission:exam.manage')->group(function () {
                    Route::post('exams/{exam}/status', [ExamController::class, 'toggleStatus'])->name('exams.status');
                    Route::get('exams/admit-card', [ExamController::class, 'generateAdmitIndex'])->name('exams.admit-card');
                    Route::get('exams/bulk-admit-card', [ExamController::class, 'bulkAdmitCard'])->name('exam.bulk_admit_card');
                    Route::post('/exams/{exam}/publish', [ExamController::class, 'publishResult'])->name('exams.publish');
                    Route::resource('exams', ExamController::class);
                });

                Route::middleware('permission:mark.manage')->group(function () {
                    Route::post('find-subject', [MarkController::class, 'findSubject'])->name('marks.findSubject');
                    Route::post('marks-autosave', [MarkController::class, 'autoSave'])->name('marks.autosave');
                    Route::post('marks-status', [MarkController::class, 'statusUpdate'])->name('marks.statusUpdate');

                    Route::get('marks-view', [MarkController::class, 'viewMarks'])->name('marks.view-marks');
                    Route::get('marksheet/{student}/{class}/{exam}',[MarkController::class, 'generateMarksheet'])->name('marks.marksheet');
                    Route::get('download-result-sheet', [MarkController::class, 'downloadResultSheet'])->name('marks.download-sheet');
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
                Route::middleware('permission:attendance.manage')->group(function () {
                    Route::get('students/search-ajax', [AttendanceController::class, 'searchAjax'])->name('students.search_ajax');
                    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('student.attendance.report');
                    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendances.index');
                    Route::post('/attendance-save', [AttendanceController::class, 'store'])->name('attendances.store');
                });

                Route::middleware('permission:fee.manage')->group(function () {
                    Route::resource('fee-heads', FeeHeadController::class);
                });

                Route::middleware('permission:fee.manage')->group(function () {
                    Route::get('/get-sub-categories/{categoryId}', [FeeAmountController::class, 'getSubCategories'])->name('get-sub-categories'); 
                    Route::get('/get-classes-by-category', [FeeAmountController::class, 'getClassesByCategory'])->name('get-classes-by-category');
                    Route::resource('fee-amounts', FeeAmountController::class);
                });
                Route::middleware('permission:fee.manage')->group(function () {
                    Route::get('/get-sub-categories/{categoryId}', [StudentFeeController::class, 'getSubCategories'])->name('get-sub-categories');
                    Route::get('student-fees/get-list', [StudentFeeController::class, 'getStudentList'])->name('student-fees.get-list');
                    Route::resource('student-fees', StudentFeeController::class);
                });

                Route::middleware(['auth', 'permission:fee.collect'])->group(function () {
                    Route::get('collect-payment', [PaymentController::class, 'index'])->name('payment.index');
                    Route::post('collect-payment/{id}', [PaymentController::class, 'collect'])->name('payment.collect');
                    Route::get('payment-receipt/{id}', [PaymentController::class, 'downloadReceipt'])->name('payment.receipt');
                });

                // Slider CRUD
                Route::middleware('permission:system.settings')->group(function () {

                    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
                    Route::post('/sliders', [SliderController::class, 'store'])->name('sliders.store');
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
            });

        });
});


