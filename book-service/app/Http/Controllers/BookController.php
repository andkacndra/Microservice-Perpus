<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::all());
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json($book);
    }

    public function reduceStock($id)
{
    $book = Book::findOrFail($id);
    $book->stok -= 1;
    $book->save();

    return response()->json(['message' => 'stok dikurangi']);
}
    public function addStock($id)
{
    $book = Book::findOrFail($id);
    $book->stok += 1;
    $book->save();

    return response()->json(['message' => 'stok ditambah']);
}

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'stok' => 'required|integer'
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
{
    $book = Book::findOrFail($id);

    $book->update([
        'judul' => $request->judul,
        'penulis' => $request->penulis,
        'stok' => $request->stok
    ]);

    return response()->json([
        'message' => 'Buku berhasil diupdate',
        'data' => $book
    ]);
}
}
