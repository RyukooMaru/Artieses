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
        $videos = Artievides::with('usericonVides')
             ->whereNull('deltime')
             ->whereHas('usericonVides', function ($query) {
                          $query->whereNull('deleteaccount');
             })
             ->when($query, function ($queryBuilder) use ($query) {
                          $queryBuilder->where(function ($q) use ($query) {
                                       $q->where('judul', 'LIKE', "%{$query}%")
                                       ->orWhere('kseo', 'LIKE', "%{$query}%")
                                       ->orWhere('lseo', 'LIKE', "%{$query}%");
                          });
             })
             ->get();
        $stories = Artiestories::with('usericonStories')
             ->whereNull('deltime')
             ->whereHas('usericonStories', function ($query) {
                          $query->whereNull('deleteaccount');
             })
             ->when($query, function ($queryBuilder) use ($query) {
                          $queryBuilder->where(function ($q) use ($query) {
                                       $q->where('caption', 'LIKE', "%{$query}%")
                                       ->orWhere('kseo', 'LIKE', "%{$query}%")
                                       ->orWhere('lseo', 'LIKE', "%{$query}%");
                          });
             })
             ->get();
        $formattedVideos = $videos->map(function ($item) {
            return ['type' => 'video', 'data' => $item];
        });
        $formattedStories = $stories->map(function ($item) {
            return ['type' => 'story', 'data' => $item];
        });
        $results = new Collection(array_merge($formattedVideos->all(), $formattedStories->all()));
        $sortedResults = $results->sortByDesc(function ($item) {
            return $item['data']->created_at;
        });
        return view('appes.searches', [
            'query' => $query,
            'results' => $sortedResults
        ]);
    }
}
