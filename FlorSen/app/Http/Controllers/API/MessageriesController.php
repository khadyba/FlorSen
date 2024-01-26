<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;

class MessageriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

/**
 * @OA\Post(
 *     path="/api/EnvoyerMessage/{id}",
 *     summary="Envoyer un message à un utilisateur spécifique",
 *     tags={"Messages"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"contenue"},
 *             @OA\Property(property="contenue", type="string", example="Contenu du message")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Message envoyé avec succès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Message envoyé!"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="contenue", type="string", example="Contenu du message")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erreur de validation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="status_code", type="integer", example=422),
 *             @OA\Property(property="error", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Erreur de validation"),
 *             @OA\Property(property="errorsList", type="object",
 *                 @OA\Property(property="receveur_id", type="array",
 *                     @OA\Items(type="string", example="Le champ receveur_id est requis.")
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @param MessageRequest $request
 * @param int $receveur_id
 * @return \Illuminate\Http\JsonResponse
 */
        public function sendMessage(MessageRequest $request, $receveur_id)
    {
        $user = Auth::user();
        $message = new Message();
        $message->contenue = $request->contenue;
        $message->envoyeur_id = $user->id;
        $message->receveur_id = $receveur_id;
        $message->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Message envoyé!',
            'data' => [
                'contenue' => $request->contenue,
            ],
        ], 200);
    }
/**
 * Répondre à un message.
 *
 * @OA\Post(
 *     path="/api/RepondreMessage/{message_id}",
 *     summary="Répondre à un message",
 *     tags={"Messages"},
 *     security={{ "bearerAuth":{} }},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Contenu de la réponse",
 *         @OA\JsonContent(
 *             required={"contenue"},
 *             @OA\Property(property="contenue", type="string", example="Merci pour votre message.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Réponse envoyée avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status_code", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Réponse envoyée avec succès."),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Message"),
 *             @OA\Property(property="reponses", type="array", @OA\Items(ref="#/components/schemas/Message")),
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Accès non autorisé",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="status_code", type="integer", example=403),
 *             @OA\Property(property="error", type="boolean", example=true),
 *             @OA\Property(property="message", type="string",
 *            example="Vous n'êtes pas autorisé à répondre à ce message."),
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Message non trouvé",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="status_code", type="integer", example=404),
 *             @OA\Property(property="error", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Message non trouvé."),
 *         )
 *     )
 * )
 *
 * @param \Illuminate\Http\Request $request
 * @param string $message_id
 * @return \Illuminate\Http\JsonResponse
 */
    public function repondreMessage(MessageRequest $request, $message_id)
    {   $user = Auth::user();
        $message = Message::findOrFail($message_id);
        if ($user->id !== $message->receveur_id) {
            return response()->json([
                'success' => false,
                'status_code' => 403,
                'error' => true,
                'message' => 'Vous n\'êtes pas autorisé à répondre à ce message.',
            ], 403);
    }
        $reponse = new Message();
        $reponse->contenue = $request->contenue;
        $reponse->envoyeur_id = $user->id;
        $reponse->receveur_id = $message->envoyeur_id; //  ici le destinataire devient l'expéditeur
        $reponse->message_parent_id = $message->id; // Stockez l'ID du message auquel vous répondez
        $reponse->save();
        $reponses = $message->reponses;
        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'Réponse envoyée avec succès.',
            'data' => $reponse,
            'reponses' => $reponses,
        ], 200);
    }


  /**
 * Récupérer les messages d'un utilisateur spécifique.
 *
 * @OA\Get(
 *     path="/api/messages",
 *     summary="Récupérer les messages d'un utilisateur",
 *     tags={"Messages"},
 *     security={{ "bearerAuth":{} }},
 *     @OA\Response(
 *         response=200,
 *         description="Messages récupérés avec succès",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Message")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="status_code", type="integer", example=401),
 *             @OA\Property(property="error", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Non autorisé."),
 *         )
 *     )
 * )
 *
 * @param \App\Models\User $user
 * @return \Illuminate\Http\JsonResponse
 */
public function getMessages(User $user)
{
    try {
        $authUser = Auth::user();
        if ($authUser->id !== $user->id) {
            return 'Non autorisé.';
        }
        $messages = Message::where('receveur_id', $user->id)->get();

        return response()->json($messages, 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'status_code' => 401,
            'error' => true,
            'message' => $e->getMessage(),
        ], 401);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
