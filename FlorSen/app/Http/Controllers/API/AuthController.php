<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;



class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


/**
 * @OA\Post(
 *      path="/api/login",
 *      operationId="login",
 *      tags={"Authentication"},
 *      summary="Authentification de l'utilisateur",
 *      description="Authentifie l'utilisateur et renvoie un jeton JWT.",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property(property="email", type="string"),
 *              @OA\Property(property="password", type="string", format="password"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Connexion réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Bienvenue dans votre espace personnel ! Vous êtes connecté en tant que jardinier."),
 *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 *              @OA\Property(property="authorization", type="object", 
 *                  @OA\Property(property="token", type="string", example="your_jwt_token_here"),
 *                  @OA\Property(property="type", type="string", example="bearer"),
 *              ),
 *          ),
 *      ),
 * 
 *    @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Bienvenue dans votre espace Administrateur!"),
 *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 *              @OA\Property(property="authorization", type="object", 
 *                  @OA\Property(property="token", type="string", example="your_jwt_token_here"),
 *                  @OA\Property(property="type", type="string", example="bearer"),
 *              ),
 *          ),
 *      ),
 *       
 *      @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Félicitations ! Vous êtes connecté."),
 *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 *              @OA\Property(property="authorization", type="object", 
 *                  @OA\Property(property="token", type="string", example="your_jwt_token_here"),
 *                  @OA\Property(property="type", type="string", example="bearer"),
 *              ),
 *          ),
 *      ),
 * 
 *      @OA\Response(
 *          response=401,
 *          description="Non autorisé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Unauthorized"),
 *          ),
 *      ),
 * )
 */

    public function login(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
    
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
    
        $user = Auth::user();
    
        if ($user->role === 'jardinier') {
            return response()->json([
                'message' => 'Bienvenue dans votre espace personnel ! ',
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        }elseif($user->role === 'admin'){ 
            return response()->json([
                'message' => 'Bienvenue dans votre espace Administrateur!',
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        }
        elseif($user->role === 'clients') {
            return response()->json([
                'message' => 'Félicitations ! Vous êtes connecté.',
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        }
    }
/**
 * @OA\Post(
 *      path="/api/register",
 *      operationId="register",
 *      tags={"Authentication"},
 *      summary="Inscription d'un nouvel utilisateur",
 *      description="Enregistre un nouvel utilisateur avec les informations fournies.",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  required={"prenom", "nom", "adresse", "telephone", "email", "password", "image"},
 *                  @OA\Property(property="prenom", type="string"),
 *                  @OA\Property(property="nom", type="string"),
 *                  @OA\Property(property="adresse", type="string"),
 *                  @OA\Property(property="telephone", type="string"),
 *                  @OA\Property(property="email", type="string"),
 *                  @OA\Property(property="password", type="string", format="password"),
 *                  @OA\Property(property="image", type="string", format="binary"),
 *              ),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Inscription réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=200),
 *              @OA\Property(property="status_message", type="string", example="Inscription réussie !"),
 *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Erreur serveur",
 *          @OA\JsonContent(
 *              @OA\Property(property="status_code", type="integer", example=500),
 *              @OA\Property(property="error", type="string", example="Une erreur s'est produite lors du traitement de votre demande."),
 *          ),
 *      ),
 * )
 *
 * @param  \App\Http\Requests\RegisterRequest  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function register(RegisterRequest $request)
{
    try {
    
        $user = new User();
        $user->prenom = $request->prenom;
        $user->nom = $request->nom;
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->email = $request->email;
        
        
        // if ($request->has('image')) {

           
        //     // $imageData = $request->image;
        //     // $imageName = time() . '.jpeg';
        //     // file_put_contents(public_path('image/' . $imageName), $imageData);
        //     // $user->image = "image/" . $imageName;

        //     $user->role = 'jardinier';
        // }
        


        $image = $request->file('image');

        if ($image !== null && !$image->getError()) {
            $user->image = $image->store('image', 'public');
            $user->role = 'jardinier';
        }
        // Hachage du mot de passe
        $user->password = bcrypt($request->password);
        // dd($user);
        $user->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Inscription réussie !',
            'user' => $user
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status_code' => 500,
            'error' => 'Une erreur s\'est produite lors du traitement de votre demande.',
        ], 500);
    }
}


/**
 * @OA\Post(
 *      path="/api/logout",
 *      operationId="logout",
 *      tags={"Authentication"},
 *      summary="Déconnexion de l'utilisateur",
 *      description="Déconnecte l'utilisateur authentifié.",
 *      security={{ "bearerAuth":{} }},
 *      @OA\Response(
 *          response=201,
 *          description="Déconnexion réussie",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Vous êtes maintenant déconnecté!"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Non autorisé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Unauthorized"),
 *          ),
 *      ),
 * )
 */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Vous Maintenant Déconnecté!',
        ]);
    }

/**
 * @OA\Post(
 *      path="/api/refresh",
 *      operationId="refreshToken",
 *      tags={"Authentication"},
 *      summary="Rafraîchir le token d'authentification",
 *      description="Renvoie un nouveau token d'authentification en actualisant celui actuellement utilisé.",
 *      security={{ "bearerAuth":{} }},
 *      @OA\Response(
 *          response=201,
 *          description="Token rafraîchi avec succès",
 *          @OA\JsonContent(
 *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
 *              @OA\Property(property="authorization", type="object",
 *                  @OA\Property(property="token", type="string", example="your_refreshed_jwt_token_here"),
 *                  @OA\Property(property="type", type="string", example="bearer"),
 *              ),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Non autorisé",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Unauthorized"),
 *          ),
 *      ),
 * )
 *
 * @return \Illuminate\Http\JsonResponse
 */
    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }


 
}









