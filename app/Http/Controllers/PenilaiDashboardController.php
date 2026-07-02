<?php

namespace App\Http\Controllers;

use App\Models\CalonPenghuni;

class PenilaiDashboardController extends Controller
{
    public function index()
    {
        return view('penilai.dashboard');
    }
}