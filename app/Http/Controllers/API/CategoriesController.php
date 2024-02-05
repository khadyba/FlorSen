<?php

namespace App\Http\Controllers\API;
use FFMpeg\FFMpeg;

use App\Models\User;
use App\Models\Video;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Requests\VideoRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoriesRequest;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::where('is_deleted', 0)->get();

        return response()->json(['videos' => $videos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function publiervideo(VideoRequest $request)
    {
      
       
        $user = Auth::user();
        if ($user->is_bloquer) {
            return response()->json([
                'status_code' => 403,
                'error' => 'Vous êtes bloqué et n\'êtes pas autorisé à publier une vidéo.',
            ], 403);
        }
        
        $video = new Video();
        $video->user_id = $user->id;
        $video->titre = $request->input('titre');
        $video->description = $request->input('description');
        
        $file = $request->file('video');
        
        if ($file) {
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('videos'), $fileName);
        
            // $ffmpeg = FFMpeg::create();
            // $videoFFmpeg = $ffmpeg->open(public_path('videos /'.$fileName));
        
            // // Ajoutez la ligne suivante pour copier la piste audio sans la réencoder
            // $videoFFmpeg->save(new \FFMpeg\Format\Video\X264('aac'), public_path('videos/'.$fileName));
        
            $video->video = 'videos/'.$fileName;
        }
        
        $video->save();
        
        return response()->json([
            'message' => 'Vidéo publiée avec succès'
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriesRequest $request)
    {
        try {
            $user = auth()->user();
            $categorie = new Categories();
            $categorie->nom = $request->nom;
            $categorie->user_id = $user->id;
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
        $video = Video::with(['user' => function ($query) {
            $query->select('id', 'nom', 'prenom', 'image', 'telephone');
        }])->find($id);
        if ($video) {
            return response()->json(['video' => $video]);
        }else{
            return response()->json(['message' => 'Vidéo non trouvé']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function modifier(VideoRequest $request, $id)
    {
        try {
            $video = Video::findOrFail($id);
            $user = Auth::user();
            if ($user->is_bloquer || ($user->id !== $video->user_id)) {
                return response()->json([
                    'status_code' => 403,
                    'error' => 'Vous êtes bloqué ou n\'êtes pas autorisé à modifier  cette video.',
                ], 403);
            }
            $video->user_id = $user->id;
            $video->titre = $request->input('titre');
            $video->description = $request->input('description');
            $video->url = urlencode($request->url);
            $video->save();
            return response()->json([
                'message' => 'Modifiecation Efectuer ! '
            ]);
        }  catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'error' => 'Une erreur s\'est produite lors de la modification.',
            ], 500);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriesRequest $request, string $id)
    {
        $user = auth()->user();
       
        $categorie = Categories::findorFail($id);
        if ($user->id !== optional($categorie->user)->id) {
            return response()->json([
                'status_code' => 403,
                'error' => 'Vous n\'êtes pas autorisé à modifier cette catégorie.',
            ], 403);
        }
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
    public function destroy(Categories $categories)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status_code' => 401,
                'error' => 'Vous devez être connecté pour effectuer cette action.',
            ], 401);
        }
        if ($user->id !== $categories->user_id) {
            return response()->json([
                'status_code' => 403,
                'error' => 'Vous n\'êtes pas autorisé à supprimer cette catégorie.',
            ], 403);
        }
    
        $categories->delete();
    
        return response()->json(['message' => 'Catégorie supprimée avec succès', 'categories' => $categories]);
    }
    
    public function effacer($id)
    {
        $user= Auth::user();
        $video = Video::find($id);
        if ($user->id !== $video->user_id) {
            return response()->json([
                'status_code' => 403,
                'error' => 'Vous n\'êtes pas autorisé à supprimer cette video.',
            ], 403);
        }
         $video->is_deleted = 1;
         $video->save();

       return response()->json(['message' => 'Video supprimée avec succès', 'video' => $video]);
    }


    public function listCategorie($jardinierId)
    {
        $user= Auth::user();
        if (!$user->id == $jardinierId) {
            return response()->json([
                'status_code' => 403,
                'error' => 'Vous n\'etes pas autorisé à consulter cette catégorie.',
            ], 403);
        }
        $categories = Categories::where('user_id', $jardinierId)->get();
        return response()->json(['categories' => $categories]);
    }
    
}
