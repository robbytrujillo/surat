<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Surat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $totalJenisSurat = JenisSurat::count();
        $totalSurat = Surat::count();

        return view('index', compact(
            'totalJenisSurat',
            'totalSurat'
        ));
    }
}