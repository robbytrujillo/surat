<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Surat;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $jenissurat = JenisSurat::all();
        $surat = Surat::latest()->get();

        return view('surat.index', compact('jenissurat', 'surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        // if ($request->jenis) {
        //     return view('surat.create');
        // } else {
        //     return redirect()->route('surat.index');
        // }
        
        // $template = $this->templateDasar();
        $jenissurat = JenisSurat::all();

        return view('surat.create', compact('jenissurat'));
    }

    private function replaceTemplate($isi, $data) {
        $data = [
            '[[NAMA_SURAT]]' => $data['nama_surat'],
            '[[NOMOR_SURAT]]' => $data['nomor_surat'],
            '[[TANGGAL_SURAT]]' => date('d F Y', strtotime($data['tanggal_surat'])),
        ];

        return strtr($isi, $data);
    }

    public function preview(Request $request) {
        $jenissurat = JenisSurat::findOrFail($request->jenis_surat_id);

        $data = $request->all();
        $data['nama_surat'] = $jenissurat->nama_surat;

        $html = $this->replaceTemplate($jenissurat->template_surat, $data);

        return view('surat.preview', compact('data','html'));
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'jenis_surat_id' => 'required',
            'isi_surat' => 'required'
        ]);

        Surat::create($validated);

        return redirect()->route('surat.index')->with('success', 'Surat created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $surat = Surat::findOrFail($id);

        return view('surat.edit', compact('surat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $surat = Surat::findOrFail($id);

        $surat->delete();

        return redirect()->route('surat.index');
    }
}