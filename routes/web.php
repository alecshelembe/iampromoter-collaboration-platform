<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\OcrController;
use App\Http\Controllers\SpeechController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\PayfastController;
use App\Http\Controllers\TransactionPayfastController;
use App\Http\Controllers\PayfastITNController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\BusinessQuestionnaireController;


use Illuminate\Http\Request; 
use Laravel\Socialite\Facades\Socialite;
use App\Models\GoogleUser;
use Illuminate\Support\Facades\Auth;

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


// Google Callback
// Redirect to Google Login
Route::get('/auth/google', function () {
    return Socialite::driver('google')
        ->with(['prompt' => 'select_account']) // Force account selection
        ->redirect();
})->name('google.login');

// Google Callback
Route::get('/auth/google/callback', function (Request $request) {
    // Handle Google login callback
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Check if the user already exists or create one
    $user = GoogleUser::updateOrCreate([
        'google_id' => $googleUser->getId(),
    ], [
        'name' => $googleUser->getName(),
        'email' => $googleUser->getEmail(),
        'avatar' => $googleUser->getAvatar(),
    ]);

    // Log the user in using the 'google_users' guard
    Auth::guard('google_users')->login($user);

    // Regenerate session
    $request->session()->regenerate();

    // Redirect to home
    return redirect()->route('google-home');
});

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Named GET route

Route::get('/register', [UserController::class, 'create'])->name('users.create');

Route::get('/register-ref', [UserController::class, 'createRef'])->name('users.create.ref');

Route::post('/register-user', [UserController::class, 'store'])->name('users.store');
Route::get('/home', [CreateController::class, 'viewboth'])->name('home');

Route::get('/google-home', [GoogleController::class, 'googleviewboth'])->name('google-home');

Route::get('/map', [CreateController::class, 'showMap'])->name('show-map');

Route::get('/', [DirectorController::class, 'landing'])->name('landing');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('/qr-login', [LoginController::class, 'qrLogin'])->name('qr.login');

// Route::get('/calendar/google/events', [CalendarController::class, 'index'])->name('calendar.index');
// Route::get('/oauth2callback', [CalendarController::class, 'handleOAuthCallback'])->name('GoogleCanlendarHandleOAuthCallback');

Route::get('/QrCodeLogin', [LoginController::class, 'showLoginFormQrCode'])->name('login.qrcode');

Route::post('/login-user', [LoginController::class, 'login'])->name('users.the.login');
Route::get('/logout-user', [LoginController::class, 'logout'])->name('users.logout');

Route::post('/update-user', [UserController::class, 'profileStore'])->name('profile.store');

// Route::match(['get', 'post'], '/register-user', [UserController::class, 'register']);
// Route::get('/create', [CreateController::class, 'create'])->name('create.post');

Route::post('/process-image', [CreateController::class, 'processImage'])->name('process.image');

Route::get('/create-post', [CreateController::class, 'showPostForm'])->name('create.raw.post');

Route::post('/create-social-post', [CreateController::class, 'saveSocialPost'])->name('social.save.post');

Route::get('/view-social-posts', [CreateController::class, 'viewSocialPosts'])->name('social.view.posts');

Route::get('/google-view-social-posts', [GoogleController::class, 'googleviewSocialPosts'])->name('google.social.view.posts');

Route::get('/view-social-post/{id}', [CreateController::class, 'viewSocialPost'])->name('social.view.post');

Route::get('/google-view-social-post/{id}', [GoogleController::class, 'googleviewSocialPost'])->name('google.social.view.post');

Route::post('/save-social-post-note/{id}', [CreateController::class, 'saveSocialPostNote'])->name('social.save.post.note');

Route::post('/save-social-post-video-link/{id}', [CreateController::class, 'saveSocialPostVideoLink'])->name('social.save.post.link');

Route::get('/view-science-post/{id}', [CreateController::class, 'viewSciencePost'])->name('science.view.post');

Route::get('/create-mobile-post', [CreateController::class, 'showMobilePostForm'])->name('create.mobile.post');

Route::post('/create-post', [CreateController::class, 'savePost'])->name('save.raw.post');

Route::post('/generate-speech', [SpeechController::class, 'generateSpeech'])->name('returnSpeech');
Route::get('/text-to-speech', [SpeechController::class, 'showForm'])->name('getSpeech');

Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/events', [EventController::class, 'showAll'])->name('events.showAll');

Route::get('/search-with-text', [DirectorController::class, 'searchPlaces'])->name('layouts.search');
Route::get('/science-posts', [CreateController::class, 'sciencePosts'])->name('science.posts');

Route::get('/gallery', [DirectorController::class, 'showImages'])->name('gallery');
Route::post('/posts/{id}/hide', [CreateController::class, 'hide'])->name('posts.hide');
Route::post('/posts/{id}/show', [CreateController::class, 'show'])->name('posts.show');
Route::post('/science-posts/{id}/hide', [CreateController::class, 'scienceHide'])->name('science.posts.hide');

Route::get('/my-profile', [UserController::class, 'profile'])->name('my.profile');

Route::get('/my-social-posts', [CreateController::class, 'myposts'])->name('my.posts');

Route::get('/public-user-posts/{email}', [CreateController::class, 'viewPublicUserPosts'])->name('public.user.posts');
Route::get('/my-public-profile/{email}', [UserController::class, 'viewPublicprofile'])->name('my.public.profile');

Route::post('/social-posts/{id}/comments', [CreateController::class, 'storeComment'])->name('comments.store');
Route::post('/social-posts/{id}/clear-comments', [CreateController::class, 'clearComments'])->name('comments.clear');

Route::get('/pay', [PayfastController::class, 'createPayfastPayment'])->name('payfast.here');

Route::post('/book-now/{id}', [TransactionPayfastController::class, 'createPayfastPaymentforBookNow'])->name('payfast.book-now');

Route::get('/transaction-history/{email}', [TransactionPayfastController::class, 'history'])->name('history_transaction');

Route::get('/payfast-cancel-transaction', [TransactionPayfastController::class, 'cancel_url'])->name('cancel_url_transaction');
Route::get('/payfast-cancel', [PayfastController::class, 'cancel_url'])->name('cancel_url');
Route::get('/payfast-return-transaction', [TransactionPayfastController::class, 'return_url'])->name('return_url_transaction');
Route::get('/payfast-return', [PayfastController::class, 'return_url'])->name('return_url');
Route::post('/payfast-notify', [PayfastITNController::class, 'handleITN'])->name('notify_url');

Route::post('/payfast/process', [PayfastController::class, 'payfastPayment'])->name('payment.process');
Route::post('/payfast/transaction/process', [TransactionPayfastController::class, 'payfastPaymentTransations'])->name('payment.transaction.process');

Route::post('/generate', [OpenAIController::class, 'generate'])->name('generate');

Route::get('/test-generate', [DirectorController::class, 'generate'])->name('test.generate');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/search-for-posts', [SearchController::class, 'searchAddress'])->name('search_address');

Route::get('/marketing', [DirectorController::class, 'viewInfluencers'])->name('view_influencers');

Route::get('/refund-policy', [DirectorController::class, 'refunds'])->name('refund-policy');

Route::get('/support', [DirectorController::class, 'support'])->name('support');

Route::get('/promotions', [DirectorController::class, 'promotions'])->name('promotions');

Route::get('/terms-and-conditions', [DirectorController::class, 'termsandconditions'])->name('termsandconditions');

Route::get('/send-transaction-email/{id}', [TransactionPayfastController::class, 'notifyTransaction'])->name('transaction_send_email');

Route::post('/business/questionnaire/submit', [BusinessQuestionnaireController::class, 'store'])->name('business.questionnaire.submit');

Route::get('/business-questionnaire', [BusinessQuestionnaireController::class, 'businessQuestionnaire'])->name('business_questionnaire');

Route::get('/business-questionnaire-ref', [BusinessQuestionnaireController::class, 'createRef'])->name('business_questionnaire_ref');
