<?php

namespace App\Http\Controllers;

use App\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')
            ->with(['articles' => function($query) {
                $query->orderBy('id', 'asc');
            }])
            ->paginate(10);

        return view('index', compact('categories'));
    }
}
