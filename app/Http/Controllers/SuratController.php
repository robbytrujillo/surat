<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public static function bulanRomawi($bulan)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III',
            4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX',
            10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        return $map[$bulan];
    }

    public static function generateNomorSurat($kode = 'SPD', $instansi = 'BOJONGNANGKA')
    {
        return DB::transaction(function () use ($kode, $instansi) {

            $now = now();
            $bulan = $now->month;
            $tahun = $now->year;

            $count = self::whereYear('tanggal_surat', $tahun)
                ->whereMonth('tanggal_surat', $bulan)
                ->lockForUpdate()
                ->count();

            $noUrut = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

            return $noUrut . '/' . $kode . '/' . $instansi . '/' 
                . self::bulanRomawi($bulan) . '/' . $tahun;
        });
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
        $nomor_surat = Surat::generateNomorSurat();

        return view('surat.create', compact('jenissurat', 'nomor_surat'));
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
            // 'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'jenis_surat_id' => 'required',
            'isi_surat' => 'required'
        ]);

        $validated['nomor_surat'] = Surat::generateNomorSurat();

        Surat::create($validated);

        return redirect()->route('surat.index')->with('success', 'Surat created successfully');
    }

    private function replaceImage($isi) {
        $data = [];
        $data['[[logo]]'] = '<img src="' . public_path('images/logo-bn.png') . '" alt="Logo" height="100">';

        return strtr($isi, $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $surat = Surat::findOrFail($id);

        $html = $this->replaceImage($surat->isi_surat);

        $pdf = Pdf::setPaper('a4', 'portrait');
        $pdf->loadHTML($html);
                
        return $pdf->stream('surat.pdf');
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
        $validated = $request->validate([
            'isi_surat' => 'required'
        ]);

        $surat = Surat::findOrFail($id);
        $surat->update($validated);

        return redirect()->route('surat.index')->with('success', 'Surat updated successfully');
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