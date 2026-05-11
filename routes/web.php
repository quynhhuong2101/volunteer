<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Student\EventController as StudentEventController;
use App\Http\Controllers\Student\CheckinController;
use App\Http\Controllers\Student\PortfolioController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']); // Đảm bảo route này tồn tại cho form action

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Social Login (Placeholders)
    Route::get('login/google', [AuthenticatedSessionController::class, 'socialLogin'])->name('login.google');
    Route::get('login/facebook', [AuthenticatedSessionController::class, 'socialLogin'])->name('login.facebook');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

// Admin Routes (Temporarily Open for Demo)
// Admin Routes (Temporarily Open for Demo)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('events', AdminEventController::class);
    Route::post('events/{event}/approve', [AdminEventController::class, 'approve'])->name('events.approve');
    Route::post('events/{event}/request-changes', [AdminEventController::class, 'requestChanges'])->name('events.request_changes');

    // Budgets
    Route::get('budgets', [App\Http\Controllers\Admin\BudgetController::class, 'index'])->name('budgets.index');
    Route::get('budgets/{id}', [App\Http\Controllers\Admin\BudgetController::class, 'show'])->name('budgets.show');
    Route::post('budgets/{id}/approve', [App\Http\Controllers\Admin\BudgetController::class, 'approve'])->name('budgets.approve');
    Route::post('budgets/{id}/reject', [App\Http\Controllers\Admin\BudgetController::class, 'reject'])->name('budgets.reject');

    // Disputes

    // Route::get('disputes', function() { return 'Disputes Manager (Coming Soon)'; })->name('disputes.index');
    Route::get('disputes', [App\Http\Controllers\Admin\DisputeController::class, 'index'])->name('disputes.index');
    Route::get('disputes/{id}', [App\Http\Controllers\Admin\DisputeController::class, 'show'])->name('disputes.show');
    Route::post('disputes/{id}/resolve', [App\Http\Controllers\Admin\DisputeController::class, 'resolve'])->name('disputes.resolve');

    // Users
    Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::post('users/{id}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::post('users/{id}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.resetPassword');
    Route::post('users/{id}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('users.approve');
    Route::post('users/{id}/reject', [App\Http\Controllers\Admin\UserController::class, 'reject'])->name('users.reject');
    Route::get('community', [\App\Http\Controllers\Admin\CommunityController::class, 'index'])->name('community.index');
    Route::get('community/{id}', [\App\Http\Controllers\Admin\CommunityController::class, 'show'])->name('community.show');
    Route::delete('community/{id}', [\App\Http\Controllers\Admin\CommunityController::class, 'destroy'])->name('community.destroy');

    // Advanced Features
    Route::post('disputes/{id}/reject', [\App\Http\Controllers\Admin\DisputeController::class, 'reject'])->name('disputes.reject');
    Route::resource('certificates', \App\Http\Controllers\Admin\CertificateController::class);
    Route::post('warnings', [\App\Http\Controllers\Admin\WarningController::class, 'store'])->name('warnings.store');

    // General Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/password', [\App\Http\Controllers\Admin\SettingsController::class, 'updatePassword'])->name('settings.password');
});

// Student Routes (Temporarily Open for Demo)
// Student Routes (Temporarily Open for Demo)
Route::prefix('student')->name('student.')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/events', [StudentEventController::class, 'index'])->name('events.index');
    Route::get('/events/registered', [StudentEventController::class, 'registered'])->name('events.registered');
    Route::get('/events/{id}', [StudentEventController::class, 'show'])->name('events.show');
    Route::get('/my-events/{id}', [StudentEventController::class, 'myEventDetail'])->name('my-events.show');
    
    // Registration Routes
    Route::get('/events/{id}/register', [\App\Http\Controllers\Student\RegistrationController::class, 'create'])->name('events.register');
    Route::post('/events/{id}/register', [StudentEventController::class, 'register'])->name('events.register.store');
    Route::post('/events/{id}/cancel', [StudentEventController::class, 'cancel'])->name('events.cancel');

    Route::post('/tasks/{id}', [\App\Http\Controllers\Student\TaskController::class, 'update'])->name('tasks.update');

    Route::get('/activities/schedule', [StudentEventController::class, 'schedule'])->name('activities.schedule');
    Route::get('/activities/history', [StudentEventController::class, 'history'])->name('activities.history');
    Route::get('/certificates/{event}', [\App\Http\Controllers\Student\CertificateController::class, 'show'])->name('certificates.show');

    Route::get('/checkin', [CheckinController::class, 'index'])->name('checkin.view');
    Route::post('/checkin', [CheckinController::class, 'store'])->name('checkin.store');

    Route::get('/reviews', [\App\Http\Controllers\Student\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [\App\Http\Controllers\Student\ReviewController::class, 'store'])->name('reviews.store');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/account', [\App\Http\Controllers\Student\SettingsController::class, 'account'])->name('account');
        Route::post('/account', [\App\Http\Controllers\Student\SettingsController::class, 'update'])->name('update');
        Route::get('/password', [\App\Http\Controllers\Student\SettingsController::class, 'password'])->name('password');
        Route::post('/password', [\App\Http\Controllers\Student\SettingsController::class, 'updatePassword'])->name('updatePassword');
    });

    Route::post('/safety/sos', [\App\Http\Controllers\Student\SafetyController::class, 'sos'])->name('safety.sos');
    Route::post('/safety/report', [\App\Http\Controllers\Student\SafetyController::class, 'report'])->name('safety.report');

    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/export', [PortfolioController::class, 'exportPdf'])->name('portfolio.export');

    // Report / Dispute Routes
    Route::get('/reports', [\App\Http\Controllers\Student\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [\App\Http\Controllers\Student\ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [\App\Http\Controllers\Student\ReportController::class, 'store'])->name('reports.store');

    // Community Routes
    Route::resource('community', \App\Http\Controllers\Student\CommunityController::class);
    Route::post('community/{id}/react', [\App\Http\Controllers\Student\CommunityController::class, 'react'])->name('community.react');
    Route::post('community/{id}/comment', [\App\Http\Controllers\Student\CommunityController::class, 'comment'])->name('community.comment');
    Route::post('community/{id}/comment/react', [\App\Http\Controllers\Student\CommunityController::class, 'reactComment'])->name('community.comment.react');
});

// Organization Routes
// Organization Routes
Route::prefix('organization')->name('organization.')->middleware(['auth', 'role:organizer'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Organization\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/warnings/{id}/read', [\App\Http\Controllers\Organization\DashboardController::class, 'markWarningRead'])->name('warnings.read');
    
    // Event Management
    Route::get('/events', [\App\Http\Controllers\Organization\EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [\App\Http\Controllers\Organization\EventController::class, 'create'])->name('events.create');
    Route::post('/events', [\App\Http\Controllers\Organization\EventController::class, 'store'])->name('events.store');
    Route::post('/events/{id}/cancel', [\App\Http\Controllers\Organization\EventController::class, 'cancel'])->name('events.cancel');
    Route::post('/events/{id}/publish', [\App\Http\Controllers\Organization\EventController::class, 'publish'])->name('events.publish');
    Route::post('/events/{id}/toggle-registration', [\App\Http\Controllers\Organization\EventController::class, 'toggleRegistration'])->name('events.toggleRegistration');
    Route::get('/events/{id}/edit', [\App\Http\Controllers\Organization\EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [\App\Http\Controllers\Organization\EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [\App\Http\Controllers\Organization\EventController::class, 'destroy'])->name('events.destroy');
    
    // Schedule Routes
    Route::get('/events/{id}/schedule', [\App\Http\Controllers\Organization\EventController::class, 'schedule'])->name('events.schedule');
    Route::post('/events/{id}/schedule', [\App\Http\Controllers\Organization\EventController::class, 'storeSchedule'])->name('events.storeSchedule');
    Route::delete('/events/{id}/schedule/{scheduleId}', [\App\Http\Controllers\Organization\EventController::class, 'destroySchedule'])->name('events.destroySchedule');
    
    // Recruitment Form Builder
    Route::get('/events/{id}/form', [\App\Http\Controllers\Organization\EventController::class, 'builder'])->name('events.builder');
    Route::post('/events/{id}/form', [\App\Http\Controllers\Organization\EventController::class, 'saveForm'])->name('events.saveForm');

    // Feedback/Review Form Builder (New)
    Route::get('/events/{id}/feedback-form', [\App\Http\Controllers\Organization\EventController::class, 'feedbackBuilder'])->name('events.feedbackBuilder');
    Route::post('/events/{id}/feedback-form', [\App\Http\Controllers\Organization\EventController::class, 'saveFeedbackForm'])->name('events.saveFeedbackForm');

    // Volunteer Management (HR)
    // Route::get('/volunteers', [\App\Http\Controllers\Organization\VolunteerController::class, 'index'])->name('volunteers.index'); // Keep for legacy if needed, but we use hr.approve now

    // HR Sub-modules
    Route::prefix('hr')->name('hr.')->group(function () {
        Route::get('/forms', [\App\Http\Controllers\Organization\EventController::class, 'formsList'])->name('forms');
        Route::get('/', [\App\Http\Controllers\Organization\VolunteerController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\Organization\VolunteerController::class, 'manage'])->name('manage');
        Route::post('/status', [\App\Http\Controllers\Organization\VolunteerController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/position', [\App\Http\Controllers\Organization\VolunteerController::class, 'updatePosition'])->name('updatePosition');
    });

    // Financial Management
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/plan', [\App\Http\Controllers\Organization\FinanceController::class, 'index'])->name('plan');
        Route::get('/plan/{id}', [\App\Http\Controllers\Organization\FinanceController::class, 'plan'])->name('plan.detail');
        Route::post('/plan/{id}', [\App\Http\Controllers\Organization\FinanceController::class, 'submitPlan'])->name('submitPlan');
        
        Route::get('/tracker', [\App\Http\Controllers\Organization\FinanceController::class, 'trackerList'])->name('tracker');
        Route::get('/tracker/{id}', [\App\Http\Controllers\Organization\FinanceController::class, 'trackerDetail'])->name('tracker.detail');
        Route::post('/expense', [\App\Http\Controllers\Organization\FinanceController::class, 'storeExpense'])->name('storeExpense');
        
        Route::get('/settlement', [\App\Http\Controllers\Organization\FinanceController::class, 'settlement'])->name('settlement');
        Route::get('/settlement/{id}', [\App\Http\Controllers\Organization\FinanceController::class, 'settlementDetail'])->name('settlement.detail');
    });

    // Smart Attendance
    Route::get('/attendance', [\App\Http\Controllers\Organization\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/{id}', [\App\Http\Controllers\Organization\AttendanceController::class, 'show'])->name('attendance.show');
    Route::post('/attendance/{id}', [\App\Http\Controllers\Organization\AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('/attendance/{id}/task', [\App\Http\Controllers\Organization\AttendanceController::class, 'storeTask'])->name('attendance.storeTask');
    Route::get('/attendance/{id}/task/{taskId}/details', [\App\Http\Controllers\Organization\AttendanceController::class, 'taskDetails'])->name('attendance.taskDetails');
    Route::put('/attendance/{id}/task/{taskId}', [\App\Http\Controllers\Organization\AttendanceController::class, 'updateTask'])->name('attendance.updateTask');

    // Reviews & Feedback
    Route::get('/reviews', [\App\Http\Controllers\Organization\ReviewController::class, 'index'])->name('reviews.index');

    // Profile Settings
    Route::get('/profile', [\App\Http\Controllers\Organization\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Organization\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\Organization\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Community Routes
    Route::resource('community', \App\Http\Controllers\Organization\CommunityController::class);
    Route::post('community/{id}/react', [\App\Http\Controllers\Organization\CommunityController::class, 'react'])->name('community.react');
    Route::post('community/{id}/comment', [\App\Http\Controllers\Organization\CommunityController::class, 'comment'])->name('community.comment');
    Route::post('community/{id}/comment/react', [\App\Http\Controllers\Organization\CommunityController::class, 'reactComment'])->name('community.comment.react');


});

// Chat System Routes (Shared for Org & Student)
Route::middleware(['auth'])->group(function () {
    Route::get('/events/{id}/chat', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/events/{id}/chat', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
    
    Route::get('/events/{id}/chat/fetch', [\App\Http\Controllers\ChatController::class, 'fetchNewMessages'])->name('chat.fetch');
    
    // Org specific actions for chat
    Route::post('/events/{id}/chat/create', [\App\Http\Controllers\ChatController::class, 'createGroup'])->name('chat.create');
    Route::delete('/events/{id}/chat', [\App\Http\Controllers\ChatController::class, 'destroy'])->name('chat.destroy');
});

// Chatbot Global Route
Route::post('/chatbot/respond', [\App\Http\Controllers\ChatbotController::class, 'respond'])
    ->name('chatbot.respond');
