<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Models\Produits;
use App\Models\Newletter;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewlettersRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    public function localiser(string $id)
    {
        try {

            if (!is_numeric($id)) {
                return response()->json('L\'ID doit être numérique.');
            }
            
            $user = User::findOrFail($id);
            $adresse = $user->adresse;
            $googleMapsUrl = "https://maps.google.com/?q=$adresse";
            return redirect()->to($googleMapsUrl);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('LocaliserJardinier/{id}');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function localiserIp(Request $request, string $id)
    {
        try {
            // Validation de l'ID comme étant numérique
            if (!is_numeric($id)) {
                return response()->json('L\'ID doit être numérique.');
            }

            $user = User::findOrFail($id);

            // Remplacez 'VOTRE_CLE' par votre véritable clé d'API ipinfo.io
            $apiKey = '486a4633162443dcbc4801760c43ad9a';

            // Assurez-vous que la clé d'API est correcte et non vide
            if (empty($apiKey)) {
                return response()->json('La clé d\'API ne peut pas être vide.');
            }

            // Utiliser ipify.org pour obtenir l'adresse IP publique
            $ipResponse = Http::get("https://api.ipify.org?format=json");
            $ipInfo = $ipResponse->json();

            // Vérifiez la structure de la réponse pour accéder à l'adresse IP correctement
            $ipAddress = $ipInfo['ip'] ?? null;

            if (empty($ipAddress)) {
                return response()->json(['error' => 'Impossible d\'obtenir l\'adresse IP publique.']);
            }

            // Utiliser l'adresse IP publique pour interroger l'API Abstract IP Geolocation
            $geoResponse = Http::get("https://ipgeolocation.abstractapi.com/v1/?api_key={$apiKey}&ip_address={$ipAddress}");
            $geolocation = $geoResponse->json();
            // Vous pouvez maintenant accéder aux informations de localisation
            $userLocation = $geolocation['city'] . ', ' . $geolocation['region'] . ', ' . $geolocation['country'];

            // Autres opérations avec les informations de localisation...

            return response()->json(['user_location' => $userLocation]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('LocaliserIPJardinier/{id}');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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