<?php

namespace App\Http\Controllers;

use App\Models\RepairAssignment;
use App\Models\Mesin;
use App\Models\TugasPerbaikan;
use App\Models\User;
use Illuminate\Http\Request;

class RepairAssignmentController extends Controller
{
    public function index()
    {
        $repairs = TugasPerbaikan::with('mesins', 'users')->get();
        return view('admin.repair.index', compact('repairs'));
    }

    public function create()
    {
        $machines = Mesin::all();
        $users = User::all();
        return view('admin.repair.assign', compact('machines', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'user_id' => 'required|exists:users,id',
            'assigned_at' => 'required|date',
        ]);

        TugasPerbaikan::create([
            'mesins_id' => $request->mesins_id,
            'user_id' => $request->users_id,
            'assigned_at' => $request->assigned_at,
            'status' => 'dijadwalkan',
        ]);

        return redirect()->route('admin.repair.index')->with('success', 'Teknisi berhasil ditugaskan.');
    }

    public function updateStatus(Request $request, $id)
    {
        $assignment = TugasPerbaikan::findOrFail($id);
        $assignment->update(['status' => $request->status]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
