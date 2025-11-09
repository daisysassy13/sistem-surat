<?php
namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;


class SuratMasukController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::with('creator')->latest()->get();
        return view('surat-masuk.index', compact('suratMasuk'));
    }

    public function create()
    {
        $nomorAgenda = SuratMasuk::generateNomorAgenda();
        return view('surat-masuk.create', compact('nomorAgenda'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date|after_or_equal:tanggal_surat',
            'asal_surat' => 'required|string|max:255',
            'perihal' => 'required|string',
            'file_surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        // Upload file
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-masuk', $filename, 'public');
            $validated['file_surat'] = $path;
        }

        $validated['nomor_agenda'] = SuratMasuk::generateNomorAgenda();
        $validated['created_by'] = auth()->id();

        // SuratMasuk::create($validated);

        $surat = SuratMasuk::create($validated);

        // Log activity
        ActivityLog::log(
            'create',
            'SuratMasuk',
            $surat->id,
            'Menambahkan surat masuk: ' . $surat->nomor_agenda,
            ['nomor_agenda' => $surat->nomor_agenda, 'asal_surat' => $surat->asal_surat]
        );


        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan!');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $suratMasuk)
{
    // Operator hanya bisa edit surat sendiri
    if (auth()->user()->role == 'operator' && $suratMasuk->created_by != auth()->id()) {
        abort(403, 'Anda tidak bisa mengedit surat orang lain.');
    }
    
    return view('surat-masuk.edit', compact('suratMasuk'));
}

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
         // Operator hanya bisa update surat sendiri
    if (auth()->user()->role == 'operator' && $suratMasuk->created_by != auth()->id()) {
        abort(403, 'Anda tidak bisa mengupdate surat orang lain.');
    }
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date|after_or_equal:tanggal_surat',
            'asal_surat' => 'required|string|max:255',
            'perihal' => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        // Upload file baru jika ada
        if ($request->hasFile('file_surat')) {
            // Hapus file lama
            if ($suratMasuk->file_surat) {
                Storage::disk('public')->delete($suratMasuk->file_surat);
            }
            
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-masuk', $filename, 'public');
            $validated['file_surat'] = $path;
        }

        $suratMasuk->update($validated);

         $suratMasuk->update($validated);

        // Log activity
        ActivityLog::log(
            'update',
            'SuratMasuk',
            $suratMasuk->id,
            'Mengupdate surat masuk: ' . $suratMasuk->nomor_agenda
        );


        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil diupdate!');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        // Soft delete (pindah ke arsip)
        $suratMasuk->delete();  

         $nomorAgenda = $suratMasuk->nomor_agenda;
    
    $suratMasuk->delete();

        // Log activity
        ActivityLog::log(
            'delete',
            'SuratMasuk',
            $suratMasuk->id,
            'Mengarsipkan surat masuk: ' . $nomorAgenda
        );

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil diarsipkan!');
    }
}
