<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
 *      path="/api/jardiniers",
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
        $jardiniers = User::where('role', 'jardinier')->get();

        return response()->json($jardiniers, 200);
    }

   /**
 * @OA\Get(
 *      path="/api/clients",
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
    {
        $clients = User::where('role', 'clients')->get();

        return response()->json($clients, 200);
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
 * @OA\Put(
 *      path="/api/users/{id}",
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
 *          @OA\JsonContent(
 *              @OA\Property(property="prenom", type="string"),
 *              @OA\Property(property="nom", type="string"),
 *              @OA\Property(property="image", type="file", nullable=true),
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
 *              @OA\Property(property="error", type="string", example="Une erreur s'est produite lors de la mise à jour de l'utilisateur."),
 *          ),
 *      ),
 * )
 */
public function update(Request $request, string $id)
{
    try {
        $user = User::findOrFail($id);

        $user->prenom = $request->input('prenom', $user->prenom);
        $user->nom = $request->input('nom', $user->nom);
        $user->adresse = $request->input('adresse', $user->adresse);
        $user->telephone = $request->input('telephone', $user->telephone);
        $user->email = $request->input('email', $user->email);

        $image = $request->file('image');

        if ($image !== null && !$image->getError()) {
            // Supprimer l'ancienne image s'il en existe une
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Enregistrer la nouvelle image
            $user->image = $image->store('image', 'public');
            $user->role = 'jardinier';
        }

        // Hachage du mot de passe
        $user->password = bcrypt($request->input('password', $user->password));

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
 *      path="/api/user/{id}/block",
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
    // dd('ok');
    $user = User::FindOrFail($id);

    if (!$user) {
        return response()->json([
            'message' => 'Utilisateur non trouvé.',
        ], 404);
    }

    if ($user->role === "jardinier" || $user->role === "clients") {
        $user->is_bloquer = 1;
        $user->save();

        return response()->json([
            "statut" => 1,
            "Message" => "Utilisateur bloqué avec succès"
        ]);
    }
}





  /**
 * @OA\Post(
 *      path="/api/user/{id}/unblock",
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
    $user = User::findOrFail($id);
    
    if ($user->role === "jardinier" || $user->role === "clients" && $user->is_bloquer === 1) {
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
