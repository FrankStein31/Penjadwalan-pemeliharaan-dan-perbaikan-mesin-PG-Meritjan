<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use App\Models\RequestPart;
use App\Models\Mesin;
use Illuminate\Http\Request;

class RequestPartController extends Controller
{
    // Form request suku cadang (teknisi)
    public function create()
    {
        $spareParts = SparePart::all();
        $mesins = Mesin::all();
        return view('teknisi.request-part.create', compact('spareParts', 'mesins'));
    }

    // Simpan request (teknisi)
    public function store(Request $request)
    {
        // Validasi input, pastikan mesin dan suku cadang valid di DB
        $validated = $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'spare_part_id' => 'required|exists:spare_parts,id',
            'jumlah' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string', // di form name-nya 'deskripsi', tapi di DB pakai 'keterangan'
        ]);

        // Simpan data, mapping 'deskripsi' ke 'keterangan' di DB
        RequestPart::create([
            'teknisi_id' => auth()->id(),
            'mesin_id' => $validated['mesin_id'],
            'spare_part_id' => $validated['spare_part_id'],
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['deskripsi'] ?? null,
            'status' => 'Pending',
        ]);

        return redirect()->route('teknisi.request-part.index')->with('success', 'Request suku cadang berhasil dikirim!');
    }

    // Tampilkan semua request (admin)
    public function index()
    {
        // Eager load supaya data relasi langsung tersedia (teknisi, sparePart, mesin)
        $requestParts = RequestPart::with('teknisi', 'sparePart', 'mesin')->latest()->get();
        return view('admin.request-part.index', compact('requestParts'));
    }

    // Admin setujui request
    public function approve(int $id)
    {
        $requestPart = RequestPart::findOrFail($id);
        $requestPart->status = 'Disetujui';
        $requestPart->save();

        return back()->with('success', 'Request suku cadang disetujui!');
    }

    // Admin tolak request
    public function reject(int $id)
    {
        $requestPart = RequestPart::findOrFail($id);
        $requestPart->status = 'Ditolak';
        $requestPart->save();

        return back()->with('success', 'Request suku cadang ditolak!');
    }
}
