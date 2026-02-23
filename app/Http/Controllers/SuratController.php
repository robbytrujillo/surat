<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Surat;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $penandatangan = User::where('role', 'penandatangan')->get();

        return view('surat.create', compact('jenissurat', 'nomor_surat', 'penandatangan'));
    }

    private function replaceTemplate($isi, $data) {
        $data = [
            '[[NAMA_SURAT]]' => $data['nama_surat'],
            '[[NOMOR_SURAT]]' => $data['nomor_surat'],
            '[[TANGGAL_SURAT]]' => date('d F Y', strtotime($data['tanggal_surat'])),
            '[[NAMA_PENANDATANGAN]]' => $data['user']->name,
            '[[JABATAN_PENANDATANGAN]]' => $data['user']->jabatan,
            
        ];

        return strtr($isi, $data);
    }

    public function preview(Request $request) {
        $jenissurat = JenisSurat::findOrFail($request->jenis_surat_id);
        
        $data = $request->all();
        
        $data['user'] = User::find($request->user_id);
        $data['nama_surat'] = $jenissurat->nama_surat;

        $html = $this->replaceTemplate($jenissurat->template_surat, $data);

        return view('surat.preview', compact('data', 'html'));
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

        // $validated['nomor_surat'] = Surat::generateNomorSurat();

        $surat = new Surat();
         $surat->nomor_surat = Surat::generateNomorSurat(); // ✅ PAKAI INI
        $surat->tanggal_surat = $request->tanggal_surat;
        $surat->jenis_surat_id = $request->jenis_surat_id;
        $surat->isi_surat = $request->isi_surat;
        $surat->user_id = auth()->id(); // lebih aman dari request
        
        $surat->save();

        // Surat::create($validated);

        return redirect()->route('surat.index')->with('success', 'Surat created successfully');
    }

    private function replaceImage($isi, $ttd) {
        $data = [];
        $data['[[logo]]'] = '<img src="' . public_path('images/logo-bn.png') . '" alt="Logo" height="100">';
        // $data['[[TANDA_TANGAN]]'] = '<img src="' . public_path($ttd) . '" alt="Ttd" height="100">';

        // Tanda tangan
        if ($ttd && file_exists(public_path('upload/tanda_tangan/' . $ttd))) {
            $path = public_path('upload/tanda_tangan/' . $ttd);
            $data['[[TANDA_TANGAN]]'] = '<img src="' . $path . '" height="100">';
        } else {
            $data['[[TANDA_TANGAN]]'] = '';
        }

        return strtr($isi, $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // $surat = Surat::findOrFail($id);
        $surat = Surat::with('user')->findOrFail($id);

        // $ttd = "";
        // if ($surat->user->tanda_tangan) {
        //     $ttd = $surat->user->tanda_tangan;
        // }

        $ttd = $surat->user?->tanda_tangan;

        // dd($ttd);

        // $ttd = $surat->user?->tanda_tangan;


        $html = $this->replaceImage($surat->isi_surat, $ttd);

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