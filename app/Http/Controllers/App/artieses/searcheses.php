<?php

namespace App\Http\Controllers\App\artieses;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\Artiekeles;
use App\Models\Artiestories;
use App\Models\Artievides;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Searches;
use Illuminate\Support\Facades\DB;

class searcheses extends Controller
{
    public function Search(Request $request)
    {
        if (!AuthHelper::check()) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }
        $request->validate([
            'search' => 'required|string',
        ]);
        Searches::create([
            'userid' => session('userid'),
            'search' => $request->search,
        ]);
        $query = $request->input('search');
        $videos = Artievides::whereNull('deltime')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('judul', 'LIKE', "%{$query}%")
                    ->orWhere('kseo', 'LIKE', "%{$query}%")
                    ->orWhere('lseo', 'LIKE', "%{$query}%");
            })
            ->get();
        $stories = Artiestories::whereNull('deltime')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('caption', 'LIKE', "%{$query}%")
                    ->orWhere('kseo', 'LIKE', "%{$query}%")
                    ->orWhere('lseo', 'LIKE', "%{$query}%");
            })
            ->get();
        $articles = Artiekeles::whereNull('deltime')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('judul', 'LIKE', "%{$query}%")
                    ->orWhere('kseo', 'LIKE', "%{$query}%")
                    ->orWhere('lseo', 'LIKE', "%{$query}%");
            })
            ->get();
        $formattedVideos = $videos->map(function ($item) {
            return ['type' => 'video', 'data' => $item];
        });
        $formattedStories = $stories->map(function ($item) {
            return ['type' => 'story', 'data' => $item];
        });
        $formattedArticles = $articles->map(function ($item) {
            return ['type' => 'article', 'data' => $item];
        });
        $results = new Collection(array_merge($formattedVideos->all(), $formattedStories->all(), $formattedArticles->all()));
        $sortedResults = $results->sortByDesc(function ($item) {
            return $item['data']->created_at;
        });
        return view('appes.searches', [
            'query' => $query,
            'results' => $sortedResults
        ]);
    }
}
