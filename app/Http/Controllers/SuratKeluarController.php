<?php
namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $suratKeluar = SuratKeluar::with('creator')->latest()->get();
        return view('surat-keluar.index', compact('suratKeluar'));
    }

    public function create()
    {
        $nomorSurat = SuratKeluar::generateNomorSurat();
        return view('surat-keluar.create', compact('nomorSurat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_surat' => 'required|date',
            'tujuan_surat' => 'required|string|max:255',
            'perihal' => 'required|string',
            'file_surat' => 'required|file|mimes:pdf|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        // Upload file
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-keluar', $filename, 'public');
            $validated['file_surat'] = $path;
        }

        $validated['nomor_surat'] = SuratKeluar::generateNomorSurat();
        $validated['created_by'] = auth()->id();

        //SuratKeluar::create($validated);

         $surat = SuratKeluar::create($validated);

        // Log activity
        ActivityLog::log(
            'create',
            'SuratKeluar',
            $surat->id,
            'Menambahkan surat keluar: ' . $surat->nomor_agenda,
            ['nomor_agenda' => $surat->nomor_agenda, 'asal_surat' => $surat->asal_surat]
        );

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil ditambahkan!');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        return view('surat-keluar.show', compact('suratKeluar'));
    }

    public function edit(SuratKeluar $suratKeluar)
    {
    // Operator hanya bisa edit surat sendiri
    if (auth()->user()->role == 'operator' && $suratKeluar->created_by != auth()->id()) {
        abort(403, 'Anda tidak bisa mengedit surat orang lain.');
    }
    
    return view('surat-keluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {

         if (auth()->user()->role == 'operator' && $suratKeluar->created_by != auth()->id()) {
        abort(403, 'Anda tidak bisa mengupdate surat orang lain.');
    }

        $validated = $request->validate([
            'tanggal_surat' => 'required|date',
            'tujuan_surat' => 'required|string|max:255',
            'perihal' => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        // Upload file baru jika ada
        if ($request->hasFile('file_surat')) {
            // Hapus file lama
            if ($suratKeluar->file_surat) {
                Storage::disk('public')->delete($suratKeluar->file_surat);
            }
            
            $file = $request->file('file_surat');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('surat-keluar', $filename, 'public');
            $validated['file_surat'] = $path;
        }

        $suratKeluar->update($validated);

        //$suratMasuk->update($validated);

        // Log activity
        ActivityLog::log(
            'update',
            'SuratKeluar',
            $suratKeluar->id,
            'Mengupdate surat keluar: ' . $suratKeluar->nomor_agenda
        );


        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil diupdate!');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        // Soft delete (pindah ke arsip)
        //$suratKeluar->delete();

         $nomorAgenda = $suratKeluar->nomor_agenda;
    
        $suratKeluar->delete();

        // Log activity
        ActivityLog::log(
            'delete',
            'SuratKeluar',
            $suratKeluar->id,
            'Mengarsipkan surat keluar: ' . $nomorAgenda
        );

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil diarsipkan!');
    }
}