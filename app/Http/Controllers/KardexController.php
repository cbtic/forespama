<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\KardexRequest;
use App\Models\Kardex;

class KardexController extends Controller
{
    public function index()
    {
        $kardex = Kardex::latest()->paginate(10);
        return view('frontend.kardex.index', compact('kardex'));
    }
}
