<?php

namespace App\Http\Controllers;

use App\Models\Book;
use app\Http\Resources\BookResource;
use app\Http\Resources\BookCollection;

use Illuminate\Http\Request;

class ApiBookController extends Controller
{
    public function index()
    {
        // Atau bisa menggunakan all() untuk menampilkan semua data
        $books = Book::paginate(2);
        return new BookCollection($books);
    }
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return new BookResource($book);
    }
    public function store(Request $request)
    {
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->year = $request->year;
        $book->save();

        return response()->json([
            'message' => 'Book created successfully'
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->year = $request->year;
        $book->save();

        return response()->json([
            'message' => 'Book updated successfully'
        ], 200);
    }
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ], 200);
    }
}
