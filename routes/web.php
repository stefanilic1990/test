<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\AcceptAnswersController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\VoteQuestionController;
use App\Http\Controllers\VoteAnswerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('questions',QuestionsController::class)->except('show');
Route::get('/questions/{slug}',[QuestionsController::class,'show'])->name('questions.show');

Route::resource('questions.answers',AnswersController::class)->only(['store','edit','update','destroy','index']);
//Route::post('/questions/{question}/answers',[AnswersController::class, 'store'])->name('answers.store');

Route::post('answers/{answer}/accept',AcceptAnswersController::class)->name('answers.accept');

Route::post('questions/{question}/favorite',[FavoritesController::class,'store'])->name('questions.favorite');
Route::delete('questions/{question}/favorite',[FavoritesController::class,'destroy'])->name('questions.unfavorite');

Route::post('questions/{question}/vote',VoteQuestionController::class);
Route::post('answers/{answer}/vote',VoteAnswerController::class);
