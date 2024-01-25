<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\Categories;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

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
 * @OA\Post(
 *     path="/api/AjouterCategorie",
 *     summary="Ajoute une nouvelle catégorie",
 *     tags={"Catégories"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Données de la nouvelle catégorie",
 *         @OA\JsonContent(
 *             required={"nom"},
 *             @OA\Property(property="nom", type="string", example="Nom de la catégorie"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="La catégorie a été ajoutée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="statut", type="integer", example=1),
 *             @OA\Property(property="message", type="string", example="Catégorie ajoutée avec succès!"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Une erreur s'est produite lors de l'ajout de la catégorie",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *               example="Une erreur s'est produite lors de l'ajout de la catégorie"),
 *         )
 *     ),
 * )
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
 * @OA\Put(
 *     path="/api/ModifierCategorie/{id}",
 *     summary="Modifie une catégorie existante",
 *     tags={"Catégories"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la catégorie à modifier",
 *         @OA\Schema(type="string"),
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Nouvelles données de la catégorie",
 *         @OA\JsonContent(
 *             required={"nom"},
 *             @OA\Property(property="nom", type="string", example="Nouveau nom de la catégorie"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="La catégorie a été modifiée avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modification effectuée"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Catégorie non trouvée",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Catégorie non trouvée"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="La modification de la catégorie a échoué",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modification non effectuée"),
 *         )
 *     ),
 * )
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
    public function destroy(string $id)
    {
        //
    }
}
