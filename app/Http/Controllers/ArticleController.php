<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Article; // ✅ Correct namespace
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view article', only:['index']),
            new Middleware('permission:create article', only:['create']),
            new Middleware('permission:edit article', only:['edit']),
            new Middleware('permission:destroy article', only:['destroy']),
        ];
    }
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('articles.list', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'  => 'required|string|min:3',
            'text'   => 'nullable|string',
            'author' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->route('article.create')
                ->withInput()
                ->withErrors($validator);
        }

        Article::create([
            'title'  => $request->title,
            'text'   => $request->text,
            'author' => $request->author,
        ]);

        return redirect()->route('article.index')
            ->with('success', 'Article added successfully.');
    }

    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'  => 'required|string|min:3',
            'text'   => 'nullable|string',
            'author' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->route('article.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $article->update([
            'title'  => $request->title,
            'text'   => $request->text,
            'author' => $request->author,
        ]);

        return redirect()->route('article.index')
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('article.index')
            ->with('success', 'Article deleted successfully.');
    }
}
