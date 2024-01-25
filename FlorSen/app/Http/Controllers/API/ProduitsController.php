<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProduitsRequest;
use App\Models\Produits;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


class ProduitsController extends Controller
{/**
 * @OA\Get(
 *     path="/api/ListerProduits",
 *     summary="Récupère la liste des produits non supprimés",
 *     tags={"Produits"},
 *     @OA\Response(
 *         response=200,
 *         description="Liste des produits récupérée avec succès",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Produit")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé"
 *     )
 * )
 *
 * @return \Illuminate\Http\JsonResponse
 */
    public function index()
    {
        $produits = Produits::where('is_deleted', 0)->get();
        return response()->json($produits, 200);
    }

    
    /**
 * @OA\Post(
 *     path="/api/PublierProduits",
 *     summary="Crée un nouveau produit",
 *     tags={"Produits"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Données du produit à créer",
 *         @OA\JsonContent(
 *             @OA\Property(property="nom", type="string", example="Nom du produit"),
 *             @OA\Property(property="description", type="string", example="Description du produit"),
 *             @OA\Property(property="image", type="string", format="binary", example="base64-encoded-image-data"),
 *             @OA\Property(property="categories_id", type="integer", example=1),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Le produit a été publié avec succès !",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="message", type="string",
 *              example="Le produit a été publié avec succès !"),
 *             @OA\Property(property="data", ref="#/components/schemas/Produit"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Une erreur s'est produite lors de la publication du produit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *             example="Une erreur s'est produite lors de la publication du produit"),
 *         )
 *     ),
 * )
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
 * @OA\Get(
 *     path="/api/VoirDetailProduits/{produits}",
 *     summary="Récupère les détails d'un produit spécifique",
 *     tags={"Produits"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID du produit à récupérer",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Détails du produit récupérés avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="article", ref="#/components/schemas/ProduitAvecDetails"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Produit non trouvé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Article not found"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Une erreur s'est produite lors du téléchargement",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *              example="Une erreur s'est produite lors du téléchargement"),
 *         )
 *     ),
 * )
 */
        public function edit(string $id)
    {
        try {
            $produits = Produits::with(['user' => function ($query) {
                $query->select('id', 'prenom','nom');
            }, 'categorie'])->find($id);
        
            if ($produits) {
                return response()->json(['produits' => $produits]);
            } else {
                return response()->json(['message' => 'l\'article n\'existe pas'], 404);
            }
        } catch(\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors du téléchargement',
            ], 500);
        }
    }
       
    

   /**
 * @OA\Post(
 *     path="/api/ModifierProduits/{produits}",
 *     summary="Modifie les détails d'un produit existant",
 *     tags={"Produits"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID du produit à modifier",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         description="Données du produit à modifier",
 *         required=true,
 *         @OA\JsonContent(
 *             ref="#/components/schemas/ProduitsRequest"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Le produit a été modifié avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="message", type="string", example="Le produit a été modifié avec succès !"),
 *             @OA\Property(property="data", ref="#/components/schemas/ProduitAvecDetails"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=401),
 *             @OA\Property(property="error", type="string",
 *                example="Vous n'êtes pas autorisé à modifier ce produit."),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Une erreur s'est produite lors de la modification du produit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *               example="Une erreur s'est produite lors de la modification du produit"),
 *         )
 *     ),
 * )
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
 * @OA\Delete(
 *     path="/api/SupprimerProduits/{produits}",
 *     summary="Supprime un produit",
 *     tags={"Produits"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID du produit à supprimer",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Le produit a été supprimé avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="message", type="string", example="Le produit a été supprimé avec succès!"),
 *             @OA\Property(property="data", ref="#/components/schemas/ProduitAvecDetails"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=401),
 *             @OA\Property(property="error",
 *              type="string", example="Vous n'êtes pas autorisé à supprimer ce produit."),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Une erreur s'est produite lors de la suppression du produit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *                example="Une erreur s'est produite lors de la suppression du produit"),
 *         )
 *     ),
 * ),
 */
    public function destroy(string $id)
    {
        try {
            $this->authorize('delete', Produits::class);
    
            $produits = Produits::findOrFail($id);
            $user = Auth::user();
    
            if ($user->id !== $produits->user_id) {
                return response()->json([
                    'status_code' => 401,
                    'error' => 'Vous n\'êtes pas autorisé à supprimer ce produit.',
                ], 401);
            }
            $produits->is_deleted = 1;
            $produits->save();
            return response()->json([
                'status' => 1,
                'message' => 'Le produit a été supprimé avec succès!',
                'data' => $produits,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de la suppression du produit',
            ], 500);
        }
    }
    /**
 * @OA\Delete(
 *     path="/api/RetirerProduits/{produits}",
 *     summary="Retire un produit de la liste des produits",
 *     tags={"Produits"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID du produit à retirer",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Le produit a été retiré de la liste avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="message", type="string",
 *                example="Le produit a été retiré de la liste des produits!"),
 *             @OA\Property(property="data", ref="#/components/schemas/ProduitAvecDetails"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=401),
 *             @OA\Property(property="error", type="string", example="Vous n'êtes pas autorisé à retirer ce produit."),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Une erreur s'est produite lors du retrait du produit de la liste",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *            example="Une erreur s'est produite lors du retrait du produit de la liste"),
 *         )
 *     ),
 * )
 */
    public function  retirer(string $id)
    {
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
