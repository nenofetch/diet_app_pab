<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Snack;

class SnackController extends Controller
{
    public function index()
    {
        $data['snacks'] = Snack::all();

        return view('backend.snacks.index', $data);
    }

    public function create()
    {
        return view('backend.snacks.add');
    }

    public function store(Request $request)
    {
        // validaton
        $request->validate([
            'name' => 'required|max:255',
            'portion' => 'required',
            'calories' => 'required',
            'proteins' => 'required',
            'carbohydrate' => 'required',
            'fat' => 'required',
            'sugar' => 'required',
        ]);

        // insert to table
        Snack::create([
            'name' => $request->name,
            'portion' => $request->portion,
            'calories' => $request->calories,
            'proteins' => $request->proteins,
            'carbohydrate' => $request->carbohydrate,
            'fat' => $request->fat,
            'sugar' => $request->sugar,
        ]);

        return redirect('snacks')->with('message', 'Cemilan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // get data
        $data['snack'] = Snack::find($id);

        return view('backend.snacks.edit', $data);
    }

    public function update(Request $request,$id)
    {
        // validaton
        $request->validate([
            'name' => 'required|max:255',
            'portion' => 'required',
            'calories' => 'required',
            'proteins' => 'required',
            'carbohydrate' => 'required',
            'fat' => 'required',
            'sugar' => 'required',
        ]);

        // get data by id
        $food = Snack::find($id);

        // update to table
        $food->update([
            'name' => $request->name,
            'portion' => $request->portion,
            'calories' => $request->calories,
            'proteins' => $request->proteins,
            'carbohydrate' => $request->carbohydrate,
            'fat' => $request->fat,
            'sugar' => $request->sugar,
        ]);

        return redirect('snacks')->with('message', 'Cemilan berhasil diubah!');
    }

    public function destroy($id)
    {
        // get data by id
        $snack = Snack::find($id);

        // delete data
        $snack->delete();

        return response()->json(['message' => 'Cemilan berhasil dihapus!']);
    }
}
