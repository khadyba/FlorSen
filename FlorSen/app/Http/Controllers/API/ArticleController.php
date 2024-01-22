<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Mail\NouvelleArticle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ArticleRequest;
use App\Models\Newletter;
use App\Notifications\NewArticleNotification;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $article = Article::where('is_deleted', 0)->get();
        return response()->json($article, 200);
    }

    /**
     * Show the form for creating a new resource.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
