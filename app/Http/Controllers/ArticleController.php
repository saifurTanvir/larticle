<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\http\resources\ArticleResource;
use App\http\resources\ArticleCollection;

class ArticleController extends Controller
{
    public function index()
    {
        return new ArticleCollection(Article::orderby('created_at', 'desc')->paginate(5));
    }

    public function store()
    {
        // dd("Okay");
        $article = request()->isMethod('put') ? Article::findOrFail(request()->id) : new Article();

        $article->title = request()->title;
        $article->body = request()->body;

        if($article->save()){
            return $article;
        }
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);

        return new ArticleResource($article);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        
        if($article->delete()){
            return $article;
        }
    }
}
