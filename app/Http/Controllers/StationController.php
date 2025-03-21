<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::all();
        return view('admin.stations.index', compact('stations'));
    }

    public function create()
    {
        return view('admin.stations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_station' => 'required|string|max:255'
        ]);

        Station::create($request->all());

        return redirect()->route('stations.index')
            ->with('success', 'Station berhasil ditambahkan');
    }

    public function show(Station $station)
    {
        return view('admin.stations.show', compact('station'));
    }

    public function edit(Station $station)
    {
        return view('admin.stations.edit', compact('station'));
    }

    public function update(Request $request, Station $station)
    {
        $request->validate([
            'nama_station' => 'required|string|max:255'
        ]);

        $station->update($request->all());

        return redirect()->route('stations.index')
            ->with('success', 'Station berhasil diperbarui');
    }

    public function destroy(Station $station)
    {
        $station->delete();

        return redirect()->route('stations.index')
            ->with('success', 'Station berhasil dihapus');
    }
} 