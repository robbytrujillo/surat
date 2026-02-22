<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $jenissurat = JenisSurat::latest()->get();
        
        return view('jenis-surat.index', compact('jenissurat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $template = $this->templateDasar();

        return view('jenis-surat.create', compact('template'));
    }

    private function templateDasar() {
        return '
                <table style="border-collapse: collapse; width: 100%;">
                    <tbody>
                        <tr>
                            <td style="width: 10%;">[[logo]]</td>
                            <td style="text-align: center; width: 90%;">
                                <p style="margin: 0; text-align: center;"><span style="font-size: 14pt;">PEMERINTAH KABUPATEN BOGOR<br>KECAMATAN GUNUNG PUTRI<strong><br>DESA BOJONG NANGKA</strong></span></p>
                                <p style="margin: 0; text-align: center;"><em><span style="font-size: 10pt;">Jalan Raya Bojong Nangka, Kecamatan Gunung Putri, Kabupaten Bogor, Jawa Barat Kode Pos: 16963</span></em></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr style="border: 3px solid;">
                    <p><!-- pagebreak --></p>
                    <h4 style="margin: 0; text-align: center;"><span style="text-decoration: underline;">[[NAMA_SURAT]]</span></h4>
                    <p style="margin: 0; text-align: center;">Nomor : [[NOMOR_SURAT]]<br><br></p>
                    <p style="text-align: justify; text-indent: 30px;">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi ex vero necessitatibus aspernatur sequi sint nam itaque velit rem unde!</p>
                <table style="border-collapse: collapse; width: 100%;" border="0">
                    <tbody>
                        <tr>
                            <td style="width: 53.835%; text-align: center;"> </td>
                            <td style="width: 46.165%; text-align: center;">Bogor, [[TANGGAL_SURAT]]</td>
                        </tr>
                        <tr>
                            <td style="width: 53.835%; text-align: center;"> </td>
                            <td style="width: 46.165%; text-align: center;">[[JABATAN_PENANDATANGAN]]</td>
                        </tr>
                        <tr>
                            <td style="width: 53.835%; text-align: center;"> </td>
                            <td style="width: 46.165%; text-align: center;"><br>[[TANDA_TANGAN]]<br><br></td>
                        </tr>
                        <tr>
                            <td style="width: 53.835%; text-align: center;"> </td>
                            <td style="width: 46.165%; text-align: center;">[[NAMA_PENANDATANGAN]]</td>
                        </tr>
                        <tr>
                            <td style="width: 53.835%; text-align: center;"> </td>
                            <td style="width: 46.165%; text-align: center;"> </td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: center;"> </div>
                <p><!-- pagebreak --></p>
        ';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'nama_surat' => 'required|string|max:255',
            'template_surat' => 'required|string',
        ]);

        JenisSurat::create($validated);

        return redirect()->route('jenis-surat.index')->with('success', 'Jenis Surat created successfully');
    }

    private function replaceImage($isi) {
        $data = [];
        $data['[[logo]]'] = '<img src="' . public_path('images/logo-bn.png') . '" alt="Logo" height="100">';

        return strtr($isi, $data);
    }

    // private function replaceImage($isi) {
    //     $path = public_path('images/logo-bn.png');
    //     $type = pathinfo($path, PATHINFO_EXTENSION);
    //     $data = file_get_contents($path);
    //     $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    //     $isi = str_replace('[[logo]]', '<img src="'.$base64.'" width="80">', $isi);

    //     return $isi;
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $jenissurat = JenisSurat::findOrFail($id);

        $html = $this->replaceImage($jenissurat->template_surat);

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
        $jenissurat = JenisSurat::findOrFail($id);

        return view('jenis-surat.edit', compact('jenissurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'nama_surat' => 'required|string|max:255',
            'template_surat' => 'required|string',
        ]);

        $jenissurat = JenisSurat::findOrFail($id);
        $jenissurat->update($validated);

        return redirect()->route('jenis-surat.index')->with('success', 'Jenis Surat updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $jenissurat = JenisSurat::findOrFail($id);

        $jenissurat->delete();

        return redirect()->route('jenis-surat.index');
    }
}