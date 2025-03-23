<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pdfs = Pdf::all();
        return view('dashboard', compact('pdfs'));
    }
}
