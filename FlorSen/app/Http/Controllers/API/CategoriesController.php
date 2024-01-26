<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriesRequest $request)
    {
        try {
            $categorie = new Categories();
            $categorie->nom = $request->nom;
            if ($categorie->save()) {
                return response()->json([
                    "statut" => 1,
                    "message" => "Categorie ajoutée avec success!"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de l\'ajout de la categorie.',
            ], 500);
        }
        
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriesRequest $request, string $id)
    {
        $categorie = Categories::findorFail($id);
        $categorie->nom = $request->nom;
        if ($categorie->save()) {
            return response()->json([
                "message" => "Modification effectuée"
            ]);
        } else {
            return response()->json([
                "message" => "Modification non effectuée"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories)
    {
        if (!auth()->check()) {
            return response()->json([
                'status_code' => 401,
                'error' => 'Vous devez être connecté pour effectuer cette action.',
            ], 401);
        }
        if (auth()->user()->id !== optional($categories->user)->id) {
            return response()->json([
                'status_code' => 403,
                'error' => 'Vous n\'êtes pas autorisé à supprimer ce categories.',
            ], 403);
        }
        $categories->delete();
    
        return response()->json(['message' => 'categories supprimé avec succès', 'categories' => $categories]);
        
    }
}
