<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Article;
use App\Models\Produits;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use App\Mail\ProfilConsulter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CommentaireRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Annotations as OA;

class CommentaireController extends Controller
{
   /**
 * @OA\Get(
 *     path="/api/ContacterJardinier/{id}",
 *     summary="Redirige vers la messagerie WhatsApp de l'utilisateur",
 *     tags={"Utilisateurs"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'utilisateur à contacter",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response=302,
 *         description="Redirection vers la messagerie WhatsApp",
 *         @OA\Header(header="Location", @OA\Schema(type="string")),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="L'utilisateur n'existe pas",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="L'utilisateur n'existe pas"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Une erreur s'est produite",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Une erreur s'est produite"),
 *         )
 *     ),
 * )
 */
public function contact(string $id)
{
    try {
        // Validation de l'ID comme étant numérique
        if (!is_numeric($id)) {
            throw new Exception('L\'ID doit être numérique.');
        }

                $proprietaire = User::findOrFail($id);

        $numeroWhatsApp = $proprietaire->telephone;
        // dd($numeroWhatsApp);
        $urlWhatsApp = "https://api.whatsapp.com/send?phone=$numeroWhatsApp";

        return redirect()->to($urlWhatsApp);
    } catch (ModelNotFoundException $e) {
        return redirect()->route('ContacterJardinier'); // Utilisez le bon nom de route
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
/**
 * @OA\Post(
 *     path="/api/commentaires",
 *     operationId="createComment",
 *     tags={"Commentaires"},
 *     summary="Création d'un commentaire",
 *     description="Création d'un commentaire associé à un article et à l'utilisateur connecté.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="contenue", type="string", description="Contenu du commentaire")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Commentaire créé avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="message", type="string", example="Commentaire réussi avec succès!"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="commentaire", type="object",
 *                     @OA\Property(property="contenue", type="string", example="Contenu du commentaire"),
 *                     @OA\Property(property="article_id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="string",
 *                       format="date-time", example="2024-01-22T13:17:32.000000Z"),
 *                     @OA\Property(property="updated_at", type="string",
 *                      format="date-time", example="2024-01-22T13:17:32.000000Z"),
 *                     @OA\Property(property="id", type="integer", example=1)
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de la création du commentaire",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *                example="Une erreur s'est produite lors de l'ajout du commentaire.")
 *         )
 *     )
 * )
 */
    public function create(CommentaireRequest $request, Article $article)
    {
       try {
        $commentaire = new Commentaire();
        $commentaire->contenue = $request->contenue;
        $commentaire->article()->associate($article);
        $user = Auth::user();
        $commentaire->user()->associate($user);
        $commentaire->save();
        return response()->json([
            "status" => 1,
            "message" => "Commentaire réussi avec succès!",
            "data" => [
                'commentaire' => $commentaire,
                
            ]
        ]);
       } catch (\Exception $e) {
        return response()->json([
            'status_code' => 500,
            'error' => 'Une erreur s\'est produite lors de l\'ajout du commentaire.',
        ], 500);
       }
       
       
    }
    

   /**
 * @OA\Get(
 *     path="/api/commentaires",
 *     summary="Récupère tous les commentaires",
 *     tags={"Commentaires"},
 *     @OA\Response(
 *         response=200,
 *         description="Liste de tous les commentaires récupérée avec succès",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Commentaire")
 *         )
 *     )
 * )
 */
    public function afficherCommentaire()
    {
        $commentaires = Commentaire::all();
        return response()->json($commentaires, 200);
    }
    

/**
 * @OA\Get(
 *     path="/api/VoirDetailProduits/{produits}",
 *     summary="Affiche les détails d'un produit",
 *     tags={"Produits"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du produit à afficher",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Détails du produit récupérés avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="article", ref="#/components/schemas/Produit"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Le produit n'existe pas",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Le produit n'existe pas"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Une erreur s'est produite lors du téléchargement",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string",
 *           example="Une erreur s'est produite lors du téléchargement"),
 *         )
 *     ),
 * )
 */
    public function show(string $id)
    {
        try {
            $produits = Produits::with(['user' => function ($query) {
                $query->select('id', 'prenom','nom');
            }, 'categorie'])->find($id);
        
            if ($produits) {
                return response()->json(['produits' => $produits]);
            } else {
                return response()->json(['message' => 'Le produit n\'existe pas'], 404);
            }
        }  catch(\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors du téléchargement',
            ], 500);
        }
        
    }

    /**
 * @OA\Get(
 *     path="/api/ConsulterProfile/{jardinier}",
 *     summary="Affiche les informations d'un jardinier et envoie un e-mail",
 *     tags={"Utilisateurs"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'utilisateur (jardinier) à consulter",
 *         @OA\Schema(type="integer"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Informations de l'utilisateur récupérées avec succès et e-mail envoyé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user", ref="#/components/schemas/User"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="L'utilisateur n'a pas d'adresse e-mail valide",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string",
 *              example="L'utilisateur n'a pas d'adresse e-mail valide."),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="L'utilisateur (jardinier) non trouvé",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="L'utilisateur (jardinier) non trouvé"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Une erreur s'est produite lors du téléchargement",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string",
 *                 example="Une erreur s'est produite lors du téléchargement"),
 *         )
 *     ),
 * )
 */
    public function edit($id)
    {
        try {
            $user = User::where('id', $id)
            ->where('role', 'jardinier')
            ->select('id', 'prenom', 'nom', 'telephone','email')
            ->first();
            
            if (!empty($user->email)) {
                Mail::to($user->email)->send(new ProfilConsulter($user));
                return response()->json(['user' => $user]);
            } else {
                return response()->json(['message' => 'L\'utilisateur n\'a pas d\'adresse e-mail valide.'], 400);
            }
            
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors du téléchargement',
            ], 500);
        }
        
       
    }
    
  
/**
 * @OA\Post(
 *     path="/api/ModifierCommentaire/{article}",
 *     operationId="updateComment",
 *     tags={"Commentaires"},
 *     summary="Mise à jour d'un commentaire",
 *     description="Mise à jour d'un commentaire existant par l'utilisateur connecté.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID du commentaire à mettre à jour",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="contenue", type="string", description="Nouveau contenu du commentaire")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Commentaire mis à jour avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="message", type="string", example="Commentaire mis à jour avec succès!"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="commentaire", type="object",
 *                     @OA\Property(property="contenue", type="string", example="Nouveau contenu du commentaire"),
 *                     @OA\Property(property="article_id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=1),
 *                     @OA\Property(property="created_at", type="string",
 *                      format="date-time", example="2024-01-22T13:17:32.000000Z"),
 *                     @OA\Property(property="updated_at", type="string",
 *                      format="date-time", example="2024-01-22T13:17:32.000000Z"),
 *                     @OA\Property(property="id", type="integer", example=1)
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Accès refusé pour la modification du commentaire",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=403),
 *             @OA\Property(property="error", type="string",
 *               example="Vous n'êtes pas autorisé à modifier ce commentaire.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de la mise à jour du commentaire",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *              example="Une erreur s'est produite lors de la mise à jour du commentaire.")
 *         )
 *     )
 * )
 */
    public function update(CommentaireRequest $request, string $id)
    {
        try {
         
            $commentaire = Commentaire::findOrFail($id);
            if (auth()->user()->id !== $commentaire->user_id) {
                return response()->json([
                    'status_code' => 403,
                    'error' => 'Vous n\'êtes pas autorisé à modifier ce commentaire.',
                ], 403);
            }
            $commentaire->contenue = $request->contenue;
            $commentaire->save();
    
            return response()->json([
                "status" => 1,
                "message" => "Commentaire mis à jour avec succès!",
                "data" => [
                    'commentaire' => $commentaire
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de la mise à jour du commentaire.',
            ], 500);
        }
    }
    

   /**
 * @OA\Delete(
 *     path="/api/SupprimerCommentaire/{commentaire",
 *     operationId="deleteComment",
 *     tags={"Commentaires"},
 *     summary="Suppression d'un commentaire",
 *     description="Suppression d'un commentaire existant par l'utilisateur connecté.",
 *     @OA\Parameter(
 *         name="commentaire",
 *         in="path",
 *         description="Commentaire à supprimer",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Commentaire supprimé avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Commentaire supprimé avec succès"),
 *             @OA\Property(property="commentaire", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="contenue", type="string", example="Contenu du commentaire"),
 *                 @OA\Property(property="article_id", type="integer", example=1),
 *                 @OA\Property(property="user_id", type="integer", example=1),
 *                 @OA\Property(property="created_at", type="string", format="date-time",
 *                    example="2024-01-22T13:17:32.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time",
 *                        example="2024-01-22T13:17:32.000000Z")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Accès non autorisé (non connecté)",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=401),
 *             @OA\Property(property="error", type="string",
 *               example="Vous devez être connecté pour effectuer cette action.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Accès refusé pour la suppression du commentaire",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=403),
 *             @OA\Property(property="error", type="string",
 *              example="Vous n'êtes pas autorisé à supprimer ce commentaire.")
 *         )
 *     )
 * )
 */
    public function destroy(Commentaire $commentaire)
    {
       
        if (!auth()->check()) {
            return response()->json([
                'status_code' => 401,
                'error' => 'Vous devez être connecté pour effectuer cette action.',
            ], 401);
        }
        if (auth()->user()->id !== optional($commentaire->user)->id) {
            return response()->json([
                'status_code' => 403,
                'error' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire.',
            ], 403);
        }
        $commentaire->delete();
    
        return response()->json(['message' => 'Commentaire supprimé avec succès', 'commentaire' => $commentaire]);
    }
    
    
}
