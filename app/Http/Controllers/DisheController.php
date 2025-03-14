<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisheRequest;
use App\Models\Dishe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\DishOnline;

class DisheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishes = Dishe::all();

        if($dishes->isEmpty()){
            return response()->json(['error' => 'No dishes found'], 404);
        }
        $user = auth()->user();

        return response()->json($dishes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DisheRequest $request)
    {
        $path = null;
        if($request->hasFile('image')){
            $path = $request->file('image')->store('dishes', 'public');
            $path = asset('storage/' . $path);
        }
        $dishe = Dishe::create([
            'nom' => $request->nom,
            'image' => $path,
            'user_id' => auth()->id(),
            'recette' => $request->recette,
        ]);
        auth()->notify(new DishOnline($dishe));


        return response()->json($dishe, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dishe = Dishe::find($id);

        if(!$dishe){
            return response()->json(['error' => 'Dishe not found'], 404);
        }

        return response()->json($dishe, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DisheRequest $request, Dishe $dishe)
    {
        $path = null;
        if($request->hasFile('image')){
            if($dishe->image) {
                Storage::disk('public')->delete($dishe->image);
            }
            $path = $request->file('image')->store('dishes', 'public');
            $dishe->image = $path;
        }
        $dishe->update([
            'name' => $request->name,
            'recette' => $request->recette,
            'user_id' => auth()->id(),
        ]);

        return response()->json($dishe, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Dishe::destroy($id);
        return response()->json(null, 204);
    }
}
