<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Masyarakat;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    public function create()
    {
        $kabupatens = Kabupaten::orderBy('nama')->get();
        return view('masyarakat.create', compact('kabupatens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'gender' => 'required|in:L,P',
            'id_kabupaten' => 'required|integer',
        ]);

        Masyarakat::create($validated);

        return redirect()->route('masyarakat.create')->with('success', 'Data berhasil terimpan!');
    }
}
