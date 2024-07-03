<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Food;

class FoodController extends Controller
{
    public function index()
    {
        // get data
        $data['foods'] = Food::all();

        return view('backend.foods.index', $data);
    }

    public function create()
    {
        return view('backend.foods.add');
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
            'fiber' => 'required',
            'sugar' => 'required',
        ]);

        // insert to table
        Food::create([
            'name' => $request->name,
            'portion' => $request->portion,
            'calories' => $request->calories,
            'proteins' => $request->proteins,
            'carbohydrate' => $request->carbohydrate,
            'fat' => $request->fat,
            'fiber' => $request->fiber,
            'sugar' => $request->sugar,
        ]);

        return redirect('foods')->with('message', 'Makanan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // get data
        $data['food'] = Food::find($id);

        return view('backend.foods.edit', $data);
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
            'fiber' => 'required',
            'sugar' => 'required',
        ]);

        // get data by id
        $food = Food::find($id);

        // update to table
        $food->update([
            'name' => $request->name,
            'portion' => $request->portion,
            'calories' => $request->calories,
            'proteins' => $request->proteins,
            'carbohydrate' => $request->carbohydrate,
            'fat' => $request->fat,
            'fiber' => $request->fiber,
            'sugar' => $request->sugar,
        ]);

        return redirect('foods')->with('message', 'Makanan berhasil diubah!');
    }

    public function destroy($id)
    {
        // get data by id
        $food = Food::find($id);

        // delete data
        $food->delete();

        return response()->json(['message' => 'Makanan berhasil dihapus!']);
    }
}
