<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'view'])->name('home.view');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [\App\Http\Controllers\PageController::class, 'showProfileForm'])->name('user.profile.view');
    Route::post('/profile', [\App\Http\Controllers\UserController::class, 'changeProfile'])->name('user.profile.submit');

    Route::get('/profile/events/{time?}', [\App\Http\Controllers\PageController::class, 'profileEvents'])->name('user.events.view');
    Route::get('/profile/associations', [\App\Http\Controllers\PageController::class, 'profileAssociations'])->name('user.associations.view');

    Route::get('/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('user.logout');
    Route::get('registrator', [\App\Http\Controllers\PageController::class, 'registratorEvent']);

});

Route::get('/login', [\App\Http\Controllers\PageController::class, 'showLoginForm'])->name('login');

Route::post('/login', [\App\Http\Controllers\UserController::class, 'login'])->name('user.login.submit');

Route::get('/registration', [\App\Http\Controllers\PageController::class, 'showRegistrationForm'])->name('user.registration.view');
Route::post('/registration', [\App\Http\Controllers\UserController::class, 'registration'])->name('user.registration.submit');

Route::get('/reset-password', [\App\Http\Controllers\PageController::class, 'showResetPasswordForm'])->name('user.reset-password.view');
Route::post('/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword'])->name('user.reset-password.submit');

Route::get('associations', [\App\Http\Controllers\PageController::class, 'associations'])->name('page.associations.view');
Route::get('g/{slug}', [\App\Http\Controllers\PageController::class, 'oneAssociation'])->name('page.association.view');

Route::get('articles', [\App\Http\Controllers\PageController::class, 'articles'])->name('page.articles.view');
Route::get('article/{slug}', [\App\Http\Controllers\PageController::class, 'oneArticle'])->name('page.article.view');

Route::get('magazines', [\App\Http\Controllers\PageController::class, 'magazines'])->name('page.magazines.view');
Route::get('videolekcii', [\App\Http\Controllers\PageController::class, 'videolekcii'])->name('page.videolekcii.view');

Route::get('events', [\App\Http\Controllers\PageController::class, 'eventsAll']);
Route::get('events/{time?}', [\App\Http\Controllers\PageController::class, 'events'])->name('page.events.view');
Route::get('m/{slug}', [\App\Http\Controllers\PageController::class, 'oneEvent'])->name('page.event.view');
Route::get('m/{slug}/test', [\App\Http\Controllers\PageController::class, 'eventTest'])->name('event.test.view');
Route::get('m/{slug}/test-result', [\App\Http\Controllers\PageController::class, 'eventTestResult'])->name('event.test.result.view');



Route::post('/search-items', [\App\Http\Controllers\PageController::class, 'searchItems']);
Route::post('/filter-events', [\App\Http\Controllers\PageController::class, 'filterEvents']);
Route::post('/get-event-rooms', [\App\Http\Controllers\PageController::class, 'getEventRooms']);
Route::post('/get-event-video', [\App\Http\Controllers\PageController::class, 'getEventVideo']);
Route::post('/register-event', [\App\Http\Controllers\UserController::class, 'registerEvent']);
Route::post('/update-event-time', [\App\Http\Controllers\UserEventController::class, 'updateEventTime']);
Route::post('/record-popup', [\App\Http\Controllers\UserEventController::class, 'recordPopup']);
Route::post('/search-user', [\App\Http\Controllers\UserController::class, 'searchUser'])->name('user.search.submit');
Route::post('/user-registration-event', [\App\Http\Controllers\UserEventController::class, 'userRegistrationEvent'])->name('user.registration.event.submit');
Route::post('/registration-user-event', [\App\Http\Controllers\UserEventController::class, 'registrationUserEvent']);
Route::post('/send-user-test-answers', [\App\Http\Controllers\UserEventController::class, 'sendUserTestAnswers']);
Route::post('/send-call', [\App\Http\Controllers\PageController::class, 'sendCall'])->name('send.call');
Route::post('/delete-profile', [\App\Http\Controllers\UserController::class, 'delete'])->name('delete');



Route::get('{slug}', [\App\Http\Controllers\PageController::class, 'view'])->name('page.view');
