<?php

namespace App\Http\Controllers\App\artieses;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\Artiekeles;
use Carbon\Carbon;
use App\Models\Artiestories;
use App\Models\Artievides;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Searches;
use App\Models\Users;
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
        $dateFilter = $request->input('date_filter');
        $videosQuery = Artievides::query();
        $storiesQuery = Artiestories::query();
        if ($dateFilter) {
            $now = Carbon::now();
            $startDate = null;

            switch ($dateFilter) {
                case 'hour':
                    $startDate = $now->subHour();
                    break;
                case 'today':
                    $startDate = $now->startOfDay();
                    break;
                case 'week':
                    $startDate = $now->startOfWeek();
                    break;
                case 'month':
                    $startDate = $now->startOfMonth();
                    break;
                case 'year':
                    $startDate = $now->startOfYear();
                    break;
            }
            if ($startDate) {
                $videosQuery->where('created_at', '>=', $startDate);
                $storiesQuery->where('created_at', '>=', $startDate);
            }
        }
        $query = $request->input('search');
        $account = Users::withCount('subscribing')
            ->whereNull('deleteaccount')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($q) use ($query) {
                    $q->where('Username', 'LIKE', "%{$query}%")
                    ->orWhere('Nameuse', 'LIKE', "%{$query}%");
                });
            })
            ->orderByDesc('subscribing_count')
            ->get();
        $videos = $videosQuery->with('usericonVides')
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
        $stories = $storiesQuery->with('usericonStories')
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
             
        $formattedAccount = $account->map(function ($item) {
            return ['type' => 'account', 'data' => $item];
        });
        $formattedVideos = $videos->map(function ($item) {
            return ['type' => 'video', 'data' => $item];
        });
        $formattedStories = $stories->map(function ($item) {
            return ['type' => 'story', 'data' => $item];
        });
        $results = new Collection(array_merge($formattedAccount->all(), $formattedVideos->all(), $formattedStories->all()));
        $sortedResults = $results->sortByDesc(function ($item) {
            return $item['data']->created_at;
        });
        return view('appes.searches', [
            'query' => $query,
            'results' => $sortedResults
        ]);
    }
}
