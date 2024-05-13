<?php

use Illuminate\Support\Facades\Route;
// Default
Route::get('/', function () {
    return view('welcome');
});
// Basic
Route::get('/greeting', function() {
    return 'Hello World';
});
// Required Parameters
Route::get('/book/{id}', function(string $id){
    return 'Book Id: '.$id;
});
// Optional Parameters
Route::get('/book-title/{title?}', function(?string $title = 'Bumi Manusia'){
    return 'Book title: '.$title;
});
// Name Routes
Route::get('/book-profile', function(){
    return 'Book Profile Page: ';
})->name('book-profile');
// Route Prefixes
Route::prefix('admin')->group(function(){
    Route::get('/book', function(){
        // Sama dengan "/admin/books" URL
        return 'Semua buku dari halaman admin';
    });
    Route::get('/authors', function(){
        // Sama dengan "/admin/authors" URL
        return 'Semua author dari halaman admin';
    });
});

Route::get('book-simple', function(){
    return view('book_simple', ['title'=> 'Bumi Manusia']);
});

use App\Models\Book;
use Illuminate\Http\Request;

// Route untuk menampilkan index view dengan data buku
Route::get('/books', function(){
    $books = Book::all();
    return view('books.index', ['books' => $books]);
})->name('books.index');

// Route untuk menampilkan form tambah buku
Route::get('/books/create', function(){
    return view('books.create');
})->name('books.create');

// Route untuk menyimpan data buku yang baru ditambahkan
Route::post('/books', function(Request $request){
    $validatedData = $request->validate([
        'title'=>'required',
        'author'=>'required',
        'year'=>'required|numeric',
    ]);

    $book = new Book();
    $book->title = $validatedData['title'];
    $book->author = $validatedData['author'];
    $book->year = $validatedData['year'];
    $book->save();

    return redirect()->route('books.index');
})->name('books.store');

// Route untuk menampilkan form edit buku
Route::get('/books/{id}/edit', function ($id){
    $book = Book::findOrFail($id); // Mengambil data Buku bedasarkan ID
    return view('books.edit', ['book' => $book]);
})->name('books.edit');

// Route untuk menyimpan data buku yang telah diubah
Route::put('/book/{id}', function (Request $request, $id){
    $validatedData = $request->validate([
        'title'=>'required',
        'author'=>'required',
        'year'=>'required|numeric',
    ]);

    $book = Book::findOrFail($id); // Mengambil data buku berdasarkan ID
    $book->title = $validatedData['title'];
    $book->author = $validatedData['author'];
    $book->year = $validatedData['year'];
    $book->save();

    return redirect()->route('books.index');
})->name('books.update');

// Route untuk menghapus data
Route::delete('/books/{id}', function ($id){
    $book = Book::findOrFail($id); // Mengambil data buku berdasarkan ID
    $book->delete();

    return redirect()->route('books.index');
})->name('books.destroy');

// // Latihan 1
// // Route untuk menampilkan beberapa buku dalam bentuk tabel
// Route::get('/book', function(){
//     $books = Book::all();
//     return view('books.index', ['books' => $books]);
// })->name('books.index');
// // Route untuk menampilkan beberapa peminjam dalam bentuk tabel
// Route::get('/borrowers', function(){
//     $borrowers = Borrower::all();
//     return view('borrowers.index', ['borrowers' => $borrowers]);
// })->name('borrowers.index');

use App\Http\Controllers\BookController;

Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

