<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Loan;

class LoanController extends Controller
{
    public function index()
    {
        return response()->json(Loan::all());
    }

    public function show($id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json(['message' => 'Loan tidak ditemukan'], 404);
        }

        return response()->json($loan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'book_id' => 'required'
        ]);

        $userId = $request->user_id;
        $bookId = $request->book_id;

        // 🔥 CEK USER
        $userResponse = Http::get("http://127.0.0.1:8001/api/users/$userId");

        if ($userResponse->failed()) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // 🔥 CEK BOOK
        $bookResponse = Http::get("http://127.0.0.1:8002/api/books/$bookId");

        if ($bookResponse->failed()) {
            return response()->json([
                'message' => 'Buku tidak ditemukan'
            ], 404);
        }

        $book = $bookResponse->json();

        // 🔥 VALIDASI STOK
        if (!isset($book['stok'])) {
            return response()->json([
                'message' => 'Format data buku salah',
                'debug' => $book
            ], 500);
        }

        if ($book['stok'] <= 0) {
            return response()->json([
                'message' => 'Stok tidak tersedia'
            ], 400);
        }

        // 🔥 SIMPAN LOAN
        $loan = Loan::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'status' => 'dipinjam'
        ]);

        return response()->json([
            'message' => 'Peminjaman berhasil',
            'data' => $loan
        ], 201);
    }
}
