<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Mail\NouvelleArticle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ArticleRequest;
use App\Models\Newletter;
class ArticleController extends Controller
{
 /**
 * @OA\Get(
 *     path="/api/ListeArticle",
 *     operationId="getArticlesList",
 *     tags={"Articles"},
 *     summary="Obtenir la liste des articles",
 *     description="Retourne la liste des articles",
 *     @OA\Response(
 *         response=200,
 *         description="Opération réussie",
 *         @OA\JsonContent(ref="#/components/schemas/Article"),
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
    public function index()
    {
        $article = Article::where('is_deleted', 0)->get();
        return response()->json($article, 200);
    }
/**
 * @OA\Post(
 *     path="/api/createArticle",
 *     operationId="createArticle",
 *     tags={"Articles"},
 *     summary="Créer un nouvel article",
 *     description="Crée un nouvel article avec les détails fournis.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/ArticleRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Article créé avec succès",
 *         @OA\JsonContent(ref="#/components/schemas/Article")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé, utilisateur non authentifié",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur interne",
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */
    public function create(ArticleRequest $request)
    {
        $this->authorize('create', Article::class);
        try {
            $article = new Article;
            $article->titre = $request->titre;
            $article->image = $request->image;
            $image = $request->file('image');
            if ($image !== null && !$image->getError()) {
                $article->image = $image->store('image', 'public');
            }
            $article->contenue = $request->contenue;
            if ($article->save()) {
                $subscribers = Newletter::all();
                foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->send(new NouvelleArticle($article));
                }
                return response()->json([
                    "status" => 1,
                    "message" => "L'article a été ajouter avec succès",
                    "data" => $article
             ]);
           }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de la publication  de l\'Article.',
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
 * @OA\Get(
 *     path="/api/VoirDetailArticle/{id}",
 *     operationId="getArticleById",
 *     tags={"Articles"},
 *     summary="Obtenir les détails d'un article",
 *     description="Récupère les détails d'un article en fonction de l'ID fourni.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de l'article",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Détails de l'article",
 *         @OA\JsonContent(ref="#/components/schemas/Article")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Article non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Article not found")
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        $article = Article::find($id);
        if ($article) {
            return response()->json(['article' => $article]);
        } else {
            return response()->json(['message' => 'Article not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

  
/**
 * @OA\Post(
 *     path="/api/updateArticle/{id}",
 *     operationId="updateArticle",
 *     tags={"Articles"},
 *     summary="Modifier un article",
 *     description="Modifie un article en fonction de l'ID fourni.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de l'article",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Données de mise à jour de l'article",
 *         @OA\JsonContent(ref="#/components/schemas/ArticleRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Article modifié avec succès",
 *         @OA\JsonContent(ref="#/components/schemas/Article")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Article non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Article not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de la mise à jour de l'article",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *             example="Une erreur s'est produite lors de la mise à jour de l'Article.")
 *         )
 *     )
 * )
 */
    public function update(ArticleRequest $request, $id)
    {
        $this->authorize('update', Article::class);

        try {
            $article = Article::findOrFail($id);
            $article->titre = $request->titre;
            $article->image = $request->image;
            $image = $request->file('image');
           if ($image !== null && !$image->getError()) {
            $article->image = $image->store('image', 'public');
           }
           $article->contenue = $request->contenue;
           $article->save();
           return response()->json([
            "status" => 1,
            "message" => "L'article a été modifier avec succès!",
            "data" => $article
             ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de la mise à jour de l\'Article.',
            ], 500);
        }
        
    }

   
/**
 * @OA\Delete(
 *     path="/api/destroyArticle/{id}",
 *     operationId="deleteArticle",
 *     tags={"Articles"},
 *     summary="Supprimer un article",
 *     description="Supprime un article en fonction de l'ID fourni.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de l'article",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Article supprimé avec succès",
 *         @OA\JsonContent(ref="#/components/schemas/Article")
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Accès non autorisé",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=403),
 *             @OA\Property(property="error", type="string",
 *             example="Vous n'êtes pas autorisé à supprimer cet article.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Article non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Article not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de la suppression de l'article",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *               example="Une erreur s'est produite lors de la suppression de l'Article.")
 *         )
 *     )
 * )
 */
    public function destroy(string $id)
    {
        $this->authorize('delete', Article::class);

        try {
            $article= Article::FindOrFail($id);
             $article->is_deleted=0;
                $article->is_deleted=1;
                $article->save();
                return response()->json([
                    "status" => 1,
                    "message" => "L'article a été supprimer avec succès!",
                    "data" => $article
                     ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de la suppression de l\'Article.',
            ], 500);
        }
       
    }
}
