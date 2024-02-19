<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Mail\BlockUser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
 /**
 * @OA\Get(
 *      path="/api/listJardinier",
 *      operationId="listJardinier",
 *      tags={"User Management"},
 *      summary="Liste des utilisateurs avec le rôle de jardinier",
 *      description="Récupère la liste des utilisateurs ayant le rôle de jardinier.",
 *      security={{ "bearerAuth":{} }},
 *      @OA\Response(
 *          response=200,
 *          description="Liste des utilisateurs de jardinier",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(ref="#/components/schemas/User"),
 *          ),
 *      ),
 * )
 *
 * @return \Illuminate\Http\JsonResponse
 */
    public function listJardinier()
    {
        if ($this->authorize('viewAny', User::class)) {
            $jardiniers = User::where('role_id', 2)->get();

            return response()->json($jardiniers, 200);
        }  else {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à effectuer cette action!',
            ], 403);
        }
       
    }
   /**
 * @OA\Get(
 *      path="/api/listClients",
 *      operationId="listClients",
 *      tags={"User Management"},
 *      summary="Liste des utilisateurs avec le rôle de client",
 *      description="Récupère la liste des utilisateurs ayant le rôle de client.",
 *      security={{ "bearerAuth":{} }},
 *      @OA\Response(
 *          response=200,
 *          description="Liste des utilisateurs de client",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(ref="#/components/schemas/User"),
 *          ),
 *      ),
 * )
 *
 * @return \Illuminate\Http\JsonResponse
 */
    public function listClients()
    {if ($this->authorize('viewAny', User::class)) {
            $clients = User::where('role_id', 3)->get();
            return response()->json($clients, 200);
        } else {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à effectuer cette action!',
            ], 403);
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */



/**
 * @OA\Post(
 *      path="/api/modifierProfil/{id}",
 *      operationId="updateUser",
 *      tags={"User Management"},
 *      summary="Mettre à jour un utilisateur",
 *      description="Mettre à jour les informations d'un utilisateur existant",
 *      @OA\Parameter(
 *          name="id",
 *          description="ID de l'utilisateur à mettre à jour",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\multipart/form-data(
 *              @OA\Property(property="prenom", type="string"),
 *              @OA\Property(property="nom", type="string"),
 *              @OA\Property(property="image", type="string", format="binary", nullable=true),
 *              @OA\Property(property="adresse", type="string"),
 *              @OA\Property(property="telephone", type="string"),
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="password", type="string", format="password"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Utilisateur mis à jour avec succès",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Utilisateur mis à jour avec succès !"),
 *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Utilisateur non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=404),
 *              @OA\Property(property="error", type="string", example="Utilisateur non trouvé."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Erreur serveur",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=500),
 *              @OA\Property(property="error", type="string",
 *               example="Une erreur s'est produite lors de la mise à jour de l'utilisateur."),
 *          ),
 *      ),
 * )
 */
public function update(Request $request, string $id)
{
    $this->authorize('update', User::class);
    try {
        $user = User::findOrFail($id);
        $user->prenom = $request->input('prenom', $user->prenom);
        $user->nom = $request->input('nom', $user->nom);
        $user->adresse = $request->input('adresse', $user->adresse);
        $user->telephone = $request->input('telephone', $user->telephone);
        $image = $request->input('image');

        if ($image !== null && !$image->getError()) {
            // Supprimer l'ancienne image s'il en existe une
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Enregistrer la nouvelle image
            $user->image = $image->store('image', 'public');
            $user->role = 'jardinier';
        }
        $user->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Profile  mis à jour avec succès !',
            'user' => $user,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status_code' => 500,
            'error' => 'Une erreur s\'est produite lors de la mise à jour de l\'utilisateur.',
        ], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
/**
 * @OA\Post(
 *      path="/api/blockUser/{id}",
 *      operationId="blockUser",
 *      tags={"User Management"},
 *      summary="Bloquer un utilisateur",
 *      description="Bloque un utilisateur spécifié en fonction de son ID.",
 *      security={{ "bearerAuth":{} }},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID de l'utilisateur à bloquer",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Utilisateur bloqué avec succès",
 *          @OA\JsonContent(
 *              @OA\Property(property="statut", type="integer", example=1),
 *              @OA\Property(property="Message", type="string", example="Utilisateur bloqué avec succès"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Utilisateur non trouvé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Utilisateur non trouvé."),
 *          ),
 *      ),
 * )
 *
 * @param int $id ID de l'utilisateur à bloquer
 * @return \Illuminate\Http\JsonResponse
 */

    public function blockUser($id)
    {
        $this->authorize('blockUser', User::class);

        $user = User::FindOrFail($id);

        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non trouvé.',
            ], 404);
        }

        if ($user->role_id === 2 || $user->role_id === 3) {
            $user->is_bloquer = 1;
            $user->save();
            Mail::to($user)->send( new BlockUser($user->email));
            return response()->json([
                "statut" => 1,
                "Message" => "Utilisateur bloqué avec succès"
            ]);
        }
    }
  /**
 * @OA\Post(
 *      path="/api/debloquerUser/{id}",
 *      operationId="unblockUser",
 *      tags={"User Management"},
 *      summary="Débloquer un utilisateur",
 *      description="Débloque un utilisateur spécifié en fonction de son ID.",
 *      security={{ "bearerAuth":{} }},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID de l'utilisateur à débloquer",
 *          @OA\Schema(
 *              type="string",
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Utilisateur débloqué avec succès",
 *          @OA\JsonContent(
 *              @OA\Property(property="statut", type="integer", example=1),
 *              @OA\Property(property="Message", type="string", example="Utilisateur débloqué avec succès"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Utilisateur déjà débloqué",
 *          @OA\JsonContent(
 *              @OA\Property(property="statut", type="integer", example=1),
 *              @OA\Property(property="Message", type="string", example="Utilisateur déjà débloqué"),
 *          ),
 *      ),
 * )
 *
 * @param string $id ID de l'utilisateur à débloquer
 * @return \Illuminate\Http\JsonResponse
 */
public function debloquerUser(string $id)
{
    $this->authorize('debloquerUser', User::class);
    $user = User::findOrFail($id);
    
    if ($user->role_id === 2 || $user->role_id === 3  && $user->is_bloquer === 1) {
        $user->is_bloquer = 0;
        $user->save();

        return response()->json([
            "statut" => 1,
            "Message" => "Utilisateur débloqué avec succès"
        ]);
    } else {
        return response()->json([
            "statut" => 1,
            "Message" => "Utilisateur déjà débloqué"
        ]);
    }
}
}
