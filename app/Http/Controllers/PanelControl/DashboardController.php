<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');
        $movies = collect();
        $error = null;

        if ($query) {
            $apiKey = config('services.omdb.key');
            $apiUrl = config('services.omdb.url');

            if (! $apiKey || ! $apiUrl) {
                $error = __('OMDB API key or URL is not configured.');
            } else {
                $response = Http::timeout(10)->get($apiUrl, [
                    'apikey' => $apiKey,
                    's' => $query,
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if (! empty($data['Search'])) {
                        $movies = collect($data['Search']);
                    } else {
                        $error = $data['Error'] ?? __('No movies found.');
                    }
                } else {
                    $error = __('Unable to fetch movies from OMDB.');
                }
            }
        }

        return view('controlpanel.dashboard', compact('movies', 'query', 'error'));
    }

    public function favorite(Request $request)
    {
        $request->validate([
            'imdbID' => 'required|string',
            'Title' => 'required|string',
            'Year' => 'nullable|string',
            'Type' => 'nullable|string',
            'Poster' => 'nullable|string',
        ]);

        $favoritePath = storage_path('app/favorites.json');
        $favorites = [];

        if (file_exists($favoritePath)) {
            $favorites = json_decode(file_get_contents($favoritePath), true) ?: [];
        }

        $exists = collect($favorites)->contains('imdbID', $request->input('imdbID'));

        if (! $exists) {
            $favorites[] = [
                'Title' => $request->input('Title'),
                'Year' => $request->input('Year'),
                'Type' => $request->input('Type'),
                'Poster' => $request->input('Poster'),
                'imdbID' => $request->input('imdbID'),
            ];

            file_put_contents($favoritePath, json_encode($favorites, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        return redirect()->back()->with('success', $exists ? __('Movie already in favorites.') : __('Movie added to favorites.'));
    }

    public function removeFavorite(Request $request)
    {
        $request->validate([
            'imdbID' => 'required|string',
        ]);

        $favoritePath = storage_path('app/favorites.json');
        $favorites = [];

        if (file_exists($favoritePath)) {
            $favorites = json_decode(file_get_contents($favoritePath), true) ?: [];
        }

        $favorites = collect($favorites)
            ->reject(function ($item) use ($request) {
                return ($item['imdbID'] ?? '') === $request->input('imdbID');
            })
            ->values()
            ->all();

        file_put_contents($favoritePath, json_encode($favorites, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return redirect()->back()->with('success', __('Movie removed from favorites.'));
    }
}
