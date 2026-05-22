<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\CourseCatalogController;
use App\Http\Controllers\CourseLearnController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\Admin\CourseVideoController;
use App\Http\Controllers\Admin\CourseVideoHubController;
use App\Http\Controllers\Admin\ChunkedVideoUploadController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\LiveSessionController as AdminLiveSessionController;
use App\Http\Controllers\Frontend\LiveSessionController as FrontendLiveSessionController;
use App\Http\Controllers\Frontend\LiveSessionCommentController;
use App\Http\Controllers\P2pController;


Route::get('/', function () {
    $slides = [
        [
            'image' => 'https://images.unsplash.com/photo-1639762681485-074b7f938ba0?w=1800&q=80',
            'badge' => 'Welcome to CryptoOnly',
            'headline' => 'The Future of Digital',
            'highlight' => 'Finance Is Here',
            'sub' => 'Trade, invest and grow your crypto portfolio with institutional-grade tools built for the modern investor.',
            'btn1_label' => 'Start Trading',
            'btn1_url' => '/register',
            'btn2_label' => 'Explore Markets',
            'btn2_url' => '/markets',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1621416894569-0f39ed31d247?w=1800&q=80',
            'badge' => 'Bitcoin & Beyond',
            'headline' => 'Secure Your Wealth in',
            'highlight' => 'Digital Gold',
            'sub' => 'Bitcoin remains the most trusted store of value in crypto history. Invest with confidence on our fully regulated platform.',
            'btn1_label' => 'Buy Bitcoin',
            'btn1_url' => '/bitcoin',
            'btn2_label' => 'Learn More',
            'btn2_url' => '/about',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1518186285589-2f7649de83e0?w=1800&q=80',
            'badge' => 'DeFi & Web3',
            'headline' => 'Decentralised Finance',
            'highlight' => 'Without Limits',
            'sub' => 'Access DeFi protocols, yield farming, and Web3 innovations — all managed from one unified, secure dashboard.',
            'btn1_label' => 'Explore DeFi',
            'btn1_url' => '/defi',
            'btn2_label' => 'View Portfolio',
            'btn2_url' => '/portfolio',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1800&q=80',
            'badge' => 'Real-Time Analytics',
            'headline' => 'Trade Smarter with',
            'highlight' => 'Live Market Data',
            'sub' => 'Real-time charts, AI-powered signals and deep market data give you the decisive edge in every trade you make.',
            'btn1_label' => 'Live Markets',
            'btn1_url' => '/markets',
            'btn2_label' => 'Get Started',
            'btn2_url' => '/register',
        ],
    ];

    return view('welcome', compact('slides'));
});

use App\Http\Controllers\Admin\AuthController;

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.Dashboard');
    })->name('admin.dashboard');

    Route::get('/premium-group', function () {
        return redirect()->route('enrollments.admin');
    });

    // P2P admin
    Route::get('/p2p',                         [P2pController::class, 'adminIndex'])->name('admin.p2p.index');
    Route::get('/p2p/{p2p}',                   [P2pController::class, 'adminShow'])->name('admin.p2p.show');
    Route::patch('/p2p/{p2p}/verify',          [P2pController::class, 'verify'])->name('admin.p2p.verify');
    Route::patch('/p2p/{p2p}/reject',          [P2pController::class, 'reject'])->name('admin.p2p.reject');
    Route::delete('/p2p/{p2p}',                [P2pController::class, 'destroy'])->name('admin.p2p.destroy');

    Route::get('/setup/storage-link', function () {
        if (! file_exists(public_path('storage'))) {
            Illuminate\Support\Facades\Artisan::call('storage:link');
            return '<h2 style="font-family:sans-serif;color:green">✓ Storage link created! Images should now load. <a href="/admin/dashboard">Back to dashboard</a></h2>';
        }
        return '<h2 style="font-family:sans-serif;color:#555">Storage link already exists. <a href="/admin/dashboard">Back to dashboard</a></h2>';
    })->name('admin.setup.storage-link');

    // Enrollments Management
    Route::get('/enrollments', [EnrollmentController::class, 'adminIndex'])->name('enrollments.admin');
    Route::patch('/enrollments/{enrollment}/verify', [EnrollmentController::class, 'verify'])->name('enrollments.verify');
    Route::patch('/enrollments/{enrollment}/reject', [EnrollmentController::class, 'reject'])->name('enrollments.reject');

    Route::get('/course-enrollments', [CourseEnrollmentController::class, 'adminIndex'])->name('course-enrollments.admin');
    Route::patch('/course-enrollments/{courseEnrollment}/verify', [CourseEnrollmentController::class, 'verify'])->name('course-enrollments.verify');
    Route::patch('/course-enrollments/{courseEnrollment}/reject', [CourseEnrollmentController::class, 'reject'])->name('course-enrollments.reject');

    // Course Management
    Route::resource('courses', CourseController::class);
    Route::get('course-videos', [CourseVideoHubController::class, 'index'])->name('admin.course-videos.index');
    Route::get('course-videos/{course}', [CourseVideoHubController::class, 'show'])->name('admin.course-videos.show');

    // Chunked video upload (bypasses PHP file size limits)
    Route::post('courses/{course}/videos/upload/init',     [ChunkedVideoUploadController::class, 'init'])->name('courses.videos.upload.init');
    Route::post('courses/{course}/videos/upload/chunk',    [ChunkedVideoUploadController::class, 'chunk'])->name('courses.videos.upload.chunk');
    Route::get('courses/{course}/videos/upload/status',    [ChunkedVideoUploadController::class, 'status'])->name('courses.videos.upload.status');
    Route::post('courses/{course}/videos/upload/finalize', [ChunkedVideoUploadController::class, 'finalize'])->name('courses.videos.upload.finalize');

    Route::post('courses/{course}/videos', [CourseVideoController::class, 'store'])->name('courses.videos.store');
    Route::delete('courses/{course}/videos/{video}', [CourseVideoController::class, 'destroy'])->name('courses.videos.destroy');

    Route::get('/live-session-enrollments', [AdminLiveSessionController::class, 'enrollmentsIndex'])->name('admin.live-session-enrollments.index');
    Route::post('/live-session-enrollments/{enrollmentId}/approve', [AdminLiveSessionController::class, 'approveEnrollmentDirect'])->name('admin.live-session-enrollments.approve');
    Route::post('/live-session-enrollments/{enrollmentId}/reject', [AdminLiveSessionController::class, 'rejectEnrollmentDirect'])->name('admin.live-session-enrollments.reject');

    Route::resource('live-sessions', AdminLiveSessionController::class)->parameters([
        'live-sessions' => 'id',
    ])->names([
        'index' => 'admin.live-sessions.index',
        'create' => 'admin.live-sessions.create',
        'store' => 'admin.live-sessions.store',
        'show' => 'admin.live-sessions.show',
        'edit' => 'admin.live-sessions.edit',
        'update' => 'admin.live-sessions.update',
        'destroy' => 'admin.live-sessions.destroy',
    ]);
    Route::post('live-sessions/{id}/go-live', [AdminLiveSessionController::class, 'goLive'])->name('admin.live-sessions.go-live');
    Route::get('live-sessions/{id}/broadcast', [AdminLiveSessionController::class, 'broadcast'])->name('admin.live-sessions.broadcast');
    Route::post('live-sessions/{id}/end', [AdminLiveSessionController::class, 'endSession'])->name('admin.live-sessions.end');
    Route::post('live-sessions/{id}/enrollments/{enrollmentId}/approve', [AdminLiveSessionController::class, 'approveEnrollment'])->name('admin.live-sessions.enrollments.approve');
    Route::post('live-sessions/{id}/enrollments/{enrollmentId}/reject', [AdminLiveSessionController::class, 'rejectEnrollment'])->name('admin.live-sessions.enrollments.reject');

    // Blog Management
    Route::resource('blogs', AdminBlogController::class)->names([
        'index'   => 'admin.blogs.index',
        'create'  => 'admin.blogs.create',
        'store'   => 'admin.blogs.store',
        'show'    => 'admin.blogs.show',
        'edit'    => 'admin.blogs.edit',
        'update'  => 'admin.blogs.update',
        'destroy' => 'admin.blogs.destroy',
    ]);
});
Route::get('/premium-group', function () {
    return view('frontend.premiumgroup');
})->name('premium.group');

Route::get('/enroll', [EnrollmentController::class, 'index'])->name('enrollment.index');
Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollment.store');
Route::get('/enroll/success', [EnrollmentController::class, 'success'])->name('enrollment.success');

// P2P frontend
Route::get('/p2p',         [P2pController::class, 'index'])->name('p2p.index');
Route::post('/p2p',        [P2pController::class, 'store'])->name('p2p.store');
Route::get('/p2p/success', [P2pController::class, 'success'])->name('p2p.success');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Frontend - Courses catalog, enrollment, student access
Route::get('/courses', [CourseCatalogController::class, 'index'])->name('courses.frontend');
Route::get('/courses/search', [CourseCatalogController::class, 'search'])->name('courses.search');

Route::get('/courses/{course:slug}/enroll', [CourseEnrollmentController::class, 'showEnroll'])->name('courses.enroll.show');
Route::post('/courses/{course:slug}/enroll', [CourseEnrollmentController::class, 'store'])->name('courses.enroll.store');
Route::get('/courses/{course:slug}/enroll/success', [CourseEnrollmentController::class, 'successPage'])->name('courses.enroll.success');

Route::middleware(['auth:student', 'verified.course'])->group(function () {
    Route::get('/courses/{course:slug}/learn', [CourseLearnController::class, 'show'])->name('courses.learn');
});

Route::get('/login', fn () => redirect()->route('student.login', request()->only('redirect')))->name('login');
Route::get('/student/login', [StudentAuthController::class, 'showLogin'])->name('student.login');
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login.submit');
Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
Route::redirect('/student/register', '/courses', 301)->name('student.register');

Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');
// Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Public Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');


// Frontend Live Session Routes — public (no auth required)
Route::prefix('live-sessions')->name('live-sessions.')->group(function () {
    Route::get('/', [FrontendLiveSessionController::class, 'index'])->name('index');
    Route::get('/{id}/register', [FrontendLiveSessionController::class, 'showRegister'])->name('register');
    Route::post('/{id}/register', [FrontendLiveSessionController::class, 'register'])->name('register.store');
    Route::get('/{id}/register/success', [FrontendLiveSessionController::class, 'registerSuccess'])->name('register.success');
    Route::get('/{id}', [FrontendLiveSessionController::class, 'show'])->name('show');
});

// Frontend Live Session Routes — auth required
Route::prefix('live-sessions')->middleware(['auth:student'])->name('live-sessions.')->group(function () {
    Route::post('/{id}/enroll', [FrontendLiveSessionController::class, 'enroll'])->name('enroll');
    Route::get('/{id}/join', [FrontendLiveSessionController::class, 'join'])
        ->middleware('enrollment.approved')
        ->name('join');
    Route::post('/{id}/comment', [LiveSessionCommentController::class, 'store'])->name('comment');
});
