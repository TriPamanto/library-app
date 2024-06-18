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

use App\Models\Borrowing;

// Latihan 1
Route::prefix('latihan1')->group(function () {
    Route::get('/books', function () {
        return view('latihan-1.book', [
            'books' => Book::all()
        ]);
    });

    Route::get('/borrowers', function () {
        $borrowers = Borrowing::all();
        $uniqueBorrowers = $borrowers->unique(function ($item) {
            return $item->user->name;
        });
        return view('latihan-1.borrower', [
            'borrowers' => $uniqueBorrowers
        ]);
    });

    Route::get('/borrowings', function () {
        $borrowings = Borrowing::all();
        return view('latihan-1.borrowing', [
            'borrowings' => $borrowings
        ]);
    });
});

use App\Http\Controllers\BookController;

// route books page
// route untuk menampilkan index view dengan data buku
Route::get('/books', [BookController::class, 'index'])->name('books.index');
// route untuk menampilkan form tambah buku
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
// route untuk menyimpan data buku yang baru ditambahkan
Route::post('/books', [BookController::class, 'store'])->name('books.store');
// route untuk menampilkan form edit buku
Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
// route untuk menyimpan data buku yang telah diubah
Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
// route untuk menghapus data
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

use App\Models\User;

// Latihan 2
Route::prefix('latihan2')->group(function () {
    Route::get('/borrower', function () {
        $borrowers = Borrowing::all();
        $uniqueBorrowers = $borrowers->unique(function ($item) {
            return $item->user->name;
        });
        return view('latihan-2.borrower', [
            'borrowers' => $uniqueBorrowers
        ]);
    })->name('borrower2.index');

    // Borrowing
    Route::get('/borrowing', function () {
        $borrowings = Borrowing::all();
        return view('latihan-2.borrowing.index', [
            'borrowings' => $borrowings
        ]);
    })->name('borrowing2.index');

    Route::get('borrowing/{id}/edit', function ($id) {
        $borrowing = Borrowing::findOrFail($id);
        return view('latihan-2.edit', [
            'borrowing' => $borrowing
        ]);
    })->name('borrowing2.edit');

    Route::delete('borrowing/{id}', function ($id) {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();
        return redirect()->route('borrowing2.index');
    })->name('borrowing2.destroy');
});

Route::get('/user-profile/{user_id}', function (string $id) {
    $user = User::find($id);
    echo $user->name;
    echo "<br>";
    echo $user->profile->address;
});

Route::get('/borrowing', function () {
    $borrowing = Borrowing::all();

    foreach ($borrowing as $key => $value) {
        echo "Book: " . $value->book->title . " | User: " . $value->user->name;
        echo "<br>";
    }
});

Route::get('/borrower/{user_id}', function (string $id) {
    $borrower = User::find($id);
    echo "$borrower->name";
    echo "<br>";

    foreach ($borrower->borrowings as $key => $value) {
        echo "Book: " . $value->book->title;
        echo "<br>";
    }
});

Route::get('/book-borrow/{book_id}', function (string $id) {
    $book = Book::find($id);
    echo "$book->title";
    echo "<br>";

    foreach ($book->borrowings as $key => $value) {
        echo "Borrower: " . $value->user->name;
        echo "<br>";
    }
});
