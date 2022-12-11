<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Models\Lending;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//ADMIN
Route::middleware( ['admin'])->group(function () {
    //books
    Route::get('/api/books/{id}', [BookController::class, 'show']);
    Route::post('/api/books', [BookController::class, 'store']);
    Route::put('/api/books/{id}', [BookController::class, 'update']);
    Route::delete('/api/books/{id}', [BookController::class, 'destroy']);
    //copies
    Route::apiResource('/api/copies', CopyController::class);
    //queries
    Route::get('/api/book_copies/{title}', [BookController::class, 'bookCopies']);
    //view - copy
    Route::get('/copy/new', [CopyController::class, 'newView']);
    Route::get('/copy/edit/{id}', [CopyController::class, 'editView']);
    Route::get('/copy/list', [CopyController::class, 'listView']); 

    Route::delete('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'destroy']);
    Route::delete('api/lendings/delete_old_reservs', [ReservationController::class, 'deleteOldReservs']);

    Route::delete('api/copies/adminTorolSelejt', [CopyController::class, 'adminTorolSelejt']);
    Route::delete('api/copies/adminTorolHard', [CopyController::class, 'adminTorolHard']);
});




//könyvtáros 
Route::middleware( ['librarian'])->group(function () {
    Route::apiResource('/users', UserController::class);



Route::get('/api/book_copies_count/{title}', [CopyController::class, 'bookCopyCount']);
Route::get('/api/hardcovered_copy_count/{hardcovered}', [CopyController::class, 'hardcoveredCopyCount']);
Route::get('/api/publication_copy_count/{publication}', [CopyController::class, 'publicationCopyCount']);
Route::apiResource('/api/copies', CopyController::class);
Route::get('/api/lendings', [LendingController::class, 'index']); 
Route::get('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'show']);
Route::put('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
Route::patch('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
Route::post('/api/lendings', [LendingController::class, 'store']);
Route::get('/api/pub_copy_count/{publication}/{book_id}', [CopyController::class, 'pubCopyCount']);
Route::get('/api/hatos_fel/{book_id}', [CopyController::class, 'hatosfel']);

Route::get('/api/elott', [CopyController::class, 'elott']);
Route::get('/api/osszElo', [ReservationController::class, 'osszElo']);

});

//SIMPLE USER
Route::middleware(['auth.basic'])->group(function () {
    
    //user   
    Route::apiResource('/api/users', UserController::class);
    Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
    //queries
    //user lendings
    Route::get('/api/user_lendings', [LendingController::class, 'userLendingsList']);
    Route::get('/api/user_lendings_count', [LendingController::class, 'userLendingsCount']);

    Route::get('/api/status_copy_count', [CopyController::class, 'statusCopyCount']);
    Route::get('/api/older{day}', [ReservationController::class, 'older']);
    Route::get('/api/reserve_count', [ReservationController::class, 'reserve_count']);
    Route::get('/api/authors_min/{number}', [BookController::class, 'authors_min']);
    Route::get('/api/authors_withB', [BookController::class, 'authors_withB']);
    Route::get('/api/reserve_db/{id}', [LendingController::class, 'reserve_db']);

    Route::get('api/my_books', [LendingController::class, 'my_books']);
});


Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);


//csak a tesztelés miatt van "kint"






//email küldés
Route::get('send-mail', [MailController::class, 'index']);

//file feltöltés
Route::get('file_upload', [FileController::class, 'index']);
Route::post('file_upload', [FileController::class, 'store'])->name('file.store');



require __DIR__.'/auth.php';
