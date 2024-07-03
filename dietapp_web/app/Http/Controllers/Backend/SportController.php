<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Sport;

class SportController extends Controller
{
    public function index()
    {
        // get data
        $data['sports'] = Sport::all();

        return view('backend.sports.index', $data);
    }

    public function create()
    {
        return view('backend.sports.add');
    }

    public function store(Request $request)
    {
        // validaton
        $request->validate([
            'name' => 'required|max:255',
            'five_minute_calories' => 'required',
            'fifteen_minute_calories' => 'required',
            'thirty_minute_calories' => 'required',
            'one_hour_calories' => 'required',
        ]);

        // insert to table
        Sport::create([
            'name' => $request->name,
            'five_minute_calories' => $request->five_minute_calories,
            'fifteen_minute_calories' => $request->fifteen_minute_calories,
            'thirty_minute_calories' => $request->thirty_minute_calories,
            'one_hour_calories' => $request->one_hour_calories,
        ]);

        return redirect('sports')->with('message', 'Olahraga berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // get data
        $data['sport'] = Sport::find($id);

        return view('backend.sports.edit', $data);
    }

    public function update(Request $request,$id)
    {
        // validaton
        $request->validate([
            'name' => 'required|max:255',
            'five_minute_calories' => 'required',
            'fifteen_minute_calories' => 'required',
            'thirty_minute_calories' => 'required',
            'one_hour_calories' => 'required',
        ]);


        // get data by id
        $sport = Sport::find($id);

        // update to table
        $sport->update([
            'name' => $request->name,
            'five_minute_calories' => $request->five_minute_calories,
            'fifteen_minute_calories' => $request->fifteen_minute_calories,
            'thirty_minute_calories' => $request->thirty_minute_calories,
            'one_hour_calories' => $request->one_hour_calories,
        ]);

        return redirect('sports')->with('message', 'Olahraga berhasil diubah!');
    }

    public function destroy($id)
    {
        // get data by id
        $sport = Sport::find($id);

        // delete data
        $sport->delete();

        return response()->json(['message' => 'Olahraga berhasil dihapus!']);
    }
}
