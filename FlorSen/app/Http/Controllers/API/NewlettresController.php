<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Produits;
use App\Models\Newletter;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\NewlettersRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class NewlettresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listeProduits()
{
    $produits = Produits::where('is_deleted', 0)
                        ->where('is_retirer', 0)
                        ->get();

    return response()->json($produits, 200);
}
    /**
     * Show the form for creating a new resource.
     */
    public function filter($categorieId)
    {
        try {
            $categorie = Categories::findOrFail($categorieId);
            $produits = $categorie->produits;
    
            return response()->json($produits, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 404,
                'error' => 'Catégorie non trouvée',
            ], 404);
        }
    }
/**
 * @OA\Post(
 *     path="/api/AjouterNewletters",
 *     operationId="storeNewsletter",
 *     tags={"Newsletters"},
 *     summary="S'inscrire à la newsletter",
 *     description="Inscription à la newsletter avec l'adresse e-mail fournie.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/NewslettersRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Inscription à la newsletter réussie",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="status_message",
 *                type="string", example="Inscription à notre newsletter réussie!"),
 *             @OA\Property(property="user", ref="#/components/schemas/Newletter")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur lors de l'inscription à la newsletter",
 *         @OA\JsonContent(
 *             @OA\Property(property="status_code", type="integer", example=500),
 *             @OA\Property(property="error", type="string",
 *             example="Une erreur s'est produite lors de l'inscription à la newsletter.")
 *         )
 *     )
 * )
 */
    public function store(NewlettersRequest $request)
    {
        try {
            $newletters= new Newletter();
            $newletters->email = $request->email;
            $newletters->save();
           return response()->json([
            'status_code' => 200,
            'status_message' => 'Inscription  a notre newletters reuisis!',
            'user' => $newletters,
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de l\'inscription !',
            ], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function listeJardiniers()
    {
        $jardiniers = User::where('role', 'jardinier')->get();
        return response()->json($jardiniers, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function restorepassword(Request $request  )
    {
        $user = User::where('email', $request->email)->first();
        if (!$user->email) {
            return response()->json([
                'errors' =>401,
                'message' =>'Cette adresse email n\'existe pas !'
            ]);
        }
        $token = Str::random(10);
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
        ]);

        Mail::send('restorepassword', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Mot de passe oublier');
        });

        return response()->json([
            'message' => 'Un email de résetage du mot de passe vous a été envoyé',
        ]);
    }
    public function formRetorepassword($token)
    {
          return view('newpassword',['token' => $token]);
    }

    public function newpassword(Request $request)
{// Valider le formulaire de réinitialisation du mot de passe
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    // Réinitialiser le mot de passe via le trait ResetsPasswords
    $update=DB::table('password_reset_tokens')->where('token',$request->token)->first();
    $user= User::where('email',$update->email)->update([
        'password' => Hash::make($request->password)
    ]);

    if (!$user) {
        return response()->json(['error' => 'Cet utilisateur n\'existe pas.'], 404);
    }
    
   DB::table('password_reset_tokens')->where('email', $update->email)->delete();
   return response()->json(['message' => 'Mot de passe mis à jour avec succès']);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
     
/**
 * @OA\Delete(
 *     path="/api/SupprimerNewlettes/{id}",
 *     operationId="deleteNewsletter",
 *     tags={"Newsletters"},
 *     summary="Suppression de l'inscription à la newsletter",
 *     description="Suppression de l'inscription à la newsletter à l'aide de l'identifiant fourni.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Identifiant de l'inscription à la newsletter",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Inscription à la newsletter supprimée avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=1),
 *             @OA\Property(property="message", type="string", example="Email supprimé avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Inscription à la newsletter non trouvée",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="Inscription à la newsletter non trouvée")
 *         )
 *     )
 * )
 */
public function supprimer($id)
{
    try {
        $newsletter = Newletter::findOrFail($id);

        if ($newsletter->delete()) {
            return response()->json([
                "status" => Response::HTTP_OK,
                "message" => "Désabonnement Reuissie avec success!"
            ]);
        }
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => Response::HTTP_NOT_FOUND,
            'message' => 'Inscription à la newsletter non trouvée'
        ], Response::HTTP_NOT_FOUND);
    }
}
}
