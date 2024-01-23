<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProduitsRequest;
use App\Models\Produits;
use Illuminate\Http\Request;

class ProduitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produits::where('is_deleted', 0)->get();
        return response()->json($produits, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    
    
    public function create(ProduitsRequest $request)
    {
        
        try {
            $this->authorize('create', Produits::class);
            $user = Auth::user();
            $produits = new Produits();
            $produits->nom = $request->nom;
            $produits->description = $request->description;
            $produits->image = $request->image;
            $produits->user_id = $user->id;
            if ($request->has('categories_id')) {
                $produits->categories_id = $request->categories_id;
            }
            $image = $request->file('image');
            if ($image !== null && !$image->getError()) {
                $produits->image = $image->store('image', 'public');
            }
            $produits->save();
            return response()->json([
                "status" => 1,
                "message" => "Le produit a été publié avec succès !",
                "data" => $produits
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de la publication du produit',
            ], 500);
        }
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        try {
            $produits = Produits::with(['user' => function ($query) {
                $query->select('id', 'prenom','nom');
            }, 'categorie'])->find($id);
        
            if ($produits) {
                return response()->json(['article' => $produits]);
            } else {
                return response()->json(['message' => 'Article not found'], 404);
            }
        } catch(\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors du téléchargement',
            ], 500);
        }
    }
       
    

    /**
     * Update the specified resource in storage.
     */
    public function update(ProduitsRequest $request, string $id)
    {
        try {
         $this->authorize('update', Produits::class);
         $produits = Produits::findOrFail($id);
        $user = Auth::user();
        if ($user->id !== $produits->user_id) {
            return response()->json([
                'status_code' => 401,
                'error' => 'Vous n\'êtes pas autorisé à modifier ce produit.',
            ], 401);
        }
        $produits->nom = $request->nom;
        $produits->description = $request->description;
        $produits->image = $request->image;
        $produits->user_id = $user->id;
        if ($request->has('categories_id')) {
            $produits->categories_id = $request->categories_id;
        }
        $image = $request->file('image');
        if ($image !== null && !$image->getError()) {
            $produits->image = $image->store('image', 'public');
        }
        $produits->save();
        return response()->json([
            "status" => 1,
            "message" => "Le produit a été modifier avec succès !",
            "data" => $produits
        ]);
        }catch(\Exception $e) {
                return response()->json([
                    'status_code' => 500,
                    'error' => 'Une erreur s\'est produite lors de la modification du produit',
                ], 500);
            }
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
        $this->authorize('delete', Produits::class);
            $produits= Produits::FindOrFail($id);
            $user = Auth::user();
            if ($user->id !== $produits->user_id) {
                return response()->json([
                    'status_code' => 401,
                    'error' => 'Vous n\'êtes pas autorisé à supprimer ce produit.',
                ], 401);
            }
             $produits->is_deleted=0;
                $produits->is_deleted=1;
                $produits->save();
                return response()->json([
                    "status" => 1,
                    "message" => "L'produits a été supprimer avec succès!",
                    "data" => $produits
                     ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de la suppression du produits',
            ], 500);
        }
    }

    public function  retirer(string $id){
        try {
        $this->authorize('retirer', Produits::class);
            $produits= Produits::FindOrFail($id);
            $user = Auth::user();
            if ($user->id !== $produits->user_id) {
                return response()->json([
                    'status_code' => 401,
                    'error' => 'Vous n\'êtes pas autorisé à retirer ce produit.',
                ], 401);
            }
            $produits->is_retirer=0;
               $produits->is_retirer=1;
               $produits->save();
               return response()->json([
                   "status" => 1,
                   "message" => "L'produits a été retirer de la liste des produits !",
                   "data" => $produits
                    ]);
        }catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de la suppression du produits',
            ], 500);
        }
   }
}
