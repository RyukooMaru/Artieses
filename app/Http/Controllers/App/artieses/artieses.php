<?php

namespace App\Http\Controllers\App\artieses;

use App\Http\Controllers\Controller;
use App\Models\Artiekeles;
use App\Models\Artiestories;
use App\Models\Artievides;
use Illuminate\Http\Request;

class artieses extends Controller
{
    private function generateMergedFeed($videos, $stories, $articles)
    {
        $mergedFeed = [];
        $videoIndex = $storyIndex = $articleIndex = 0;
        while ($videoIndex < $videos->count() || $storyIndex < $stories->count() || $articleIndex < $articles->count()) {
            for ($i = 0; $i < 3 && $videoIndex < $videos->count(); $i++) {
                $mergedFeed[] = ['type' => 'video', 'data' => $videos[$videoIndex++]];
            }
            for ($i = 0; $i < 3 && $storyIndex < $stories->count(); $i++) {
                $mergedFeed[] = ['type' => 'story', 'data' => $stories[$storyIndex++]];
            }
            for ($i = 0; $i < 3 && $articleIndex < $articles->count(); $i++) {
                $mergedFeed[] = ['type' => 'article', 'data' => $articles[$articleIndex++]];
            }
        }
        return $mergedFeed;
    }
    public function loadFeed(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = 12;
        $videos = Artievides::whereNull('deltime')
            ->with('usericonVides')
            ->withCount('likeVides')
            ->orderByDesc('like_vides_count')
            ->orderByDesc('created_at')
            ->get();
        $stories = Artiestories::whereNull('deltime')
            ->withCount('reactStories', 'comments')
            ->orderByDesc('react_stories_count')
            ->with([
                'usericonStories',
                'ReactStories',
                'comments.replies',
                'comments.userComments',
                'comments.replies.userBalcom'
            ])
            ->latest()
            ->get();
        $articles = Artiekeles::latest()->get();
        $mergedFeed = $this->generateMergedFeed($videos, $stories, $articles);
        $pagedFeed = collect($mergedFeed)->forPage($page, $perPage);
        return view('appes.partials.feed-items', ['mergedFeed' => $pagedFeed]);
    }
    public function Homes(Request $request)
    {
        $videos = Artievides::whereNull('deltime')
            ->with('usericonVides')
            ->withCount('likeVides')
            ->orderByDesc('like_vides_count')
            ->orderByDesc('created_at')
            ->get();
        $stories = Artiestories::whereNull('deltime')
            ->withCount('reactStories', 'comments')
            ->orderByDesc('react_stories_count')
            ->with([
                'usericonStories',
                'ReactStories',
                'comments.replies',
                'comments.userComments',
                'comments.replies.userBalcom'
            ])
            ->latest()
            ->get();
        $articles = Artiekeles::latest()->get();
        $mergedFeed = $this->generateMergedFeed($videos, $stories, $articles);
        $perPage = 12;
        $pagedFeed = collect($mergedFeed)->forPage(1, $perPage);
        return view('appes.artieses', [
            'mergedFeed' => $pagedFeed,
            'allFeed' => $mergedFeed
        ]);
    }
    public function Homes1()
    {
        return redirect()->to('/Artieses');
    }
}