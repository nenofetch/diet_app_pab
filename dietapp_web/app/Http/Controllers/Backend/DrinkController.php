<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Drink;

class DrinkController extends Controller
{
    public function index()
    {
        // get data
        $data['drinks'] = Drink::all();

        return view('backend.drinks.index', $data);
    }

    public function create()
    {
        return view('backend.drinks.add');
    }

    public function store(Request $request)
    {
        // validaton
        $request->validate([
            'name' => 'required|max:255',
            'calories' => 'required',
            'proteins' => 'required',
            'carbohydrate' => 'required',
            'fat' => 'required',
            'sugar' => 'required',
        ]);

        // insert to table
        Drink::create([
            'name' => $request->name,
            'calories' => $request->calories,
            'proteins' => $request->proteins,
            'carbohydrate' => $request->carbohydrate,
            'fat' => $request->fat,
            'sugar' => $request->sugar,
        ]);

        return redirect('drinks')->with('message', 'Minuman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // get data
        $data['drink'] = Drink::find($id);

        return view('backend.drinks.edit', $data);
    }

    public function update(Request $request,$id)
    {
        // validaton
        $request->validate([
            'name' => 'required|max:255',
            'calories' => 'required',
            'proteins' => 'required',
            'carbohydrate' => 'required',
            'fat' => 'required',
            'sugar' => 'required',
        ]);

        $drink = Drink::find($id);

        // update to table
        $drink->update([
            'name' => $request->name,
            'calories' => $request->calories,
            'proteins' => $request->proteins,
            'carbohydrate' => $request->carbohydrate,
            'fat' => $request->fat,
            'sugar' => $request->sugar,
        ]);

        return redirect('drinks')->with('message', 'Minuman berhasil diubah!');
    }

    public function destroy($id)
    {
        // get data by id
        $drink = Drink::find($id);

        // delete data
        $drink->delete();

        return response()->json(['message' => 'Minuman berhasil dihapus!']);
    }
}
