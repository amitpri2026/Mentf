<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Mentor;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\CmsPagesController;
use App\Http\Controllers\EnrollController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about',           [CmsPagesController::class, 'about'])->name('about');
Route::get('/privacy',         [CmsPagesController::class, 'privacy'])->name('privacy');
Route::get('/contact',         [CmsPagesController::class, 'contact'])->name('contact');
Route::get('/blog',                  [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}',           [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/comments', [BlogCommentController::class, 'store'])->name('blog.comments.store');
Route::get('/mentors', [MentorController::class, 'index'])->name('mentors.index');
Route::get('/mentors/{slug}', [MentorController::class, 'show'])->name('mentors.show');
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Enrollment
Route::post('/packages/{package}/enroll', [EnrollController::class, 'store'])
    ->name('packages.enroll')
    ->middleware('auth');

// Dashboard routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'mentee'])->name('dashboard');
    Route::get('/dashboard/mentor', [DashboardController::class, 'mentor'])->name('dashboard.mentor');
});

// Mentor routes
Route::middleware('auth')->prefix('mentor')->name('mentor.')->group(function () {
    // Profile
    Route::get('/profile', [Mentor\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [Mentor\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [Mentor\ProfileController::class, 'updatePhoto'])->name('profile.photo');

    // Education
    Route::post('/education', [Mentor\EducationController::class, 'store'])->name('education.store');
    Route::put('/education/{education}', [Mentor\EducationController::class, 'update'])->name('education.update');
    Route::delete('/education/{education}', [Mentor\EducationController::class, 'destroy'])->name('education.destroy');

    // Professional
    Route::post('/professional', [Mentor\ProfessionalController::class, 'store'])->name('professional.store');
    Route::put('/professional/{professional}', [Mentor\ProfessionalController::class, 'update'])->name('professional.update');
    Route::delete('/professional/{professional}', [Mentor\ProfessionalController::class, 'destroy'])->name('professional.destroy');

    // Achievement
    Route::post('/achievement', [Mentor\AchievementController::class, 'store'])->name('achievement.store');
    Route::put('/achievement/{achievement}', [Mentor\AchievementController::class, 'update'])->name('achievement.update');
    Route::delete('/achievement/{achievement}', [Mentor\AchievementController::class, 'destroy'])->name('achievement.destroy');

    // Certificate
    Route::post('/certificate', [Mentor\CertificateController::class, 'store'])->name('certificate.store');
    Route::put('/certificate/{certificate}', [Mentor\CertificateController::class, 'update'])->name('certificate.update');
    Route::delete('/certificate/{certificate}', [Mentor\CertificateController::class, 'destroy'])->name('certificate.destroy');

    // Packages
    Route::get('/packages', [Mentor\PackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [Mentor\PackageController::class, 'create'])->name('packages.create');
    Route::post('/packages', [Mentor\PackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/edit', [Mentor\PackageController::class, 'edit'])->name('packages.edit');
    Route::post('/packages/{package}', [Mentor\PackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}', [Mentor\PackageController::class, 'destroy'])->name('packages.destroy');

    Route::post('/packages/{package}/topics', [Mentor\TopicController::class, 'store'])->name('topics.store');
    Route::put('/packages/{package}/topics/{topic}', [Mentor\TopicController::class, 'update'])->name('topics.update');
    Route::delete('/packages/{package}/topics/{topic}', [Mentor\TopicController::class, 'destroy'])->name('topics.destroy');
    Route::post('/packages/{package}/topics/reorder', [Mentor\TopicController::class, 'reorder'])->name('topics.reorder');
});

// Admin Inertia pages
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // The SPA catch-all - serves the Inertia admin layout
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}', [Admin\UserController::class, 'patch'])->name('users.patch');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [Admin\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [Admin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/packages', [Admin\PackageController::class, 'index'])->name('packages.index');
    Route::put('/packages/{package}', [Admin\PackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}', [Admin\PackageController::class, 'destroy'])->name('packages.destroy');

    Route::get('/enrollments', [Admin\EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::get('/settings',    [Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings',   [Admin\SettingsController::class, 'update'])->name('settings.update');

    Route::get('/cms',         [Admin\CmsController::class, 'index'])->name('cms.index');
    Route::post('/cms',        [Admin\CmsController::class, 'update'])->name('cms.update');

    Route::get('/blog',              [Admin\BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create',       [Admin\BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog',             [Admin\BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{post}/edit',  [Admin\BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}',       [Admin\BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}',    [Admin\BlogController::class, 'destroy'])->name('blog.destroy');
    Route::delete('/blog-comments/{comment}', [Admin\BlogCommentController::class, 'destroy'])->name('blog.comments.destroy');

    // Admin managing packages/topics on behalf of a specific mentor
    Route::prefix('mentors/{mentorId}')->name('mentors.')->group(function () {
        Route::get('/packages',                                          [Admin\MentorPackageController::class, 'index'])  ->name('packages.index');
        Route::get('/packages/create',                                   [Admin\MentorPackageController::class, 'create']) ->name('packages.create');
        Route::post('/packages',                                         [Admin\MentorPackageController::class, 'store'])  ->name('packages.store');
        Route::get('/packages/{package}/edit',                           [Admin\MentorPackageController::class, 'edit'])   ->name('packages.edit');
        Route::post('/packages/{package}',                               [Admin\MentorPackageController::class, 'update']) ->name('packages.update');
        Route::delete('/packages/{package}',                             [Admin\MentorPackageController::class, 'destroy'])->name('packages.destroy');

        Route::post('/packages/{package}/topics',                        [Admin\MentorTopicController::class, 'store'])   ->name('topics.store');
        Route::put('/packages/{package}/topics/{topic}',                 [Admin\MentorTopicController::class, 'update'])  ->name('topics.update');
        Route::delete('/packages/{package}/topics/{topic}',              [Admin\MentorTopicController::class, 'destroy']) ->name('topics.destroy');
        Route::post('/packages/{package}/topics/reorder',                [Admin\MentorTopicController::class, 'reorder']) ->name('topics.reorder');
    });
});
