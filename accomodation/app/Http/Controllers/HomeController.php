<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
        /**
     * Page d'accueil
     */
    public function index()
    {
        // Catégories avec nombre d'hébergements
        $categories = Category::withCount('accommodations')->get();
        
        // Hébergements populaires (les plus vus)
        $popularAccommodations = Accommodation::with(['category', 'images'])
            ->orderBy('views_count', 'desc')
            ->take(8)
            ->get();
        
        return view('index', compact('categories', 'popularAccommodations'));
    }
}
