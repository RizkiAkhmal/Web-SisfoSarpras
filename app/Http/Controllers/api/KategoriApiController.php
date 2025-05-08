<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriApiController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return response()->json([
            'success' => true,
            'data' => $kategoris
        ]);
    }
}
