<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

use App\Models\Anime;
use App\Models\Genre;

class AnimeController extends Controller
{

    public $anime;
    public $genre;

    public function __construct()
    {
        $this->anime = new Anime();
        $this->genre = new Genre();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animes = $this->anime->getAllAnimes();
        return view('admin.animes.index' , compact('animes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $apiKey = null;

        $filePath = storage_path('app/api_keys.json');

        if (File::exists($filePath)) {
            $apiKeys = json_decode(File::get($filePath), true);
            $apiKey = $apiKeys['mal'] ?? null;
        }

        $anime = $this->anime->find($id);
        $genres = $this->genre->get();
        return view('admin.animes.edit', compact('anime', 'genres', 'apiKey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = $request->validate([
            'name' => 'required|string|max:355',
            'name_alternative' => 'nullable|string|max:355',
            'banner' => 'nullable|string|max:355',
            'poster' => 'nullable|string|max:355',
            'overview' => 'nullable|string',
            'aired' => 'required|date',
            'type' => 'required|string',
            'status' => 'required|int',
            'premiered' => 'nullable|string',
            'broadcast' => 'required|int',
            'genres' => 'nullable|array',
            'rating' => 'required|string',
            'popularity' => 'required|numeric',
            'vote_average' => 'required|numeric',
            'prequel' => 'nullable|int',
            'sequel' => 'nullable|int',
            'related' => 'nullable|string',
        ]);

        if(isset($data["genres"])){
            $data["genres"] = implode(',', $data["genres"]);
        }
    
        $anime = $this->anime->find($id);

        if ($anime) {
            $anime->update($data);
            return redirect()->route('admin.animes.index')->with('success', 'Anime updated successfully.');
        }else{
            return redirect()->route('admin.animes.index')->with('error', 'Anime not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->anime->find($id)) {
            $this->anime->find($id)->delete();
            return redirect()->route('admin.animes.index')->with('success', 'Anime deleted successfully.');
        }else{
            return redirect()->route('admin.animes.index')->with('error', 'Anime not found.');
        }
    }


    // Funciones Adicionales

    public function generate()
    {
        $apiKey = null;

        $filePath = storage_path('app/api_keys.json');

        if (File::exists($filePath)) {
            $apiKeys = json_decode(File::get($filePath), true);
            $apiKey = $apiKeys['tmdb'] ?? null;
        }

        return view('admin.animes.generate', compact('apiKey'));
    }


    public function storeTmdb(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:355',
            'original_name' => 'required|string|max:355',
            'overview' => 'required|string',
            'popularity' => 'required|numeric',
            'poster_path' => 'required|string|max:355',
            'backdrop_path' => 'nullable|string|max:355',
            'first_air_date' => 'required|date',
            'vote_average' => 'required|numeric',
            'vote_count' => 'required|integer',
        ]);

        $animeData = [
            'name' => $data['name'],
            'name_alternative' => $data['original_name'],
            'poster' => $data['poster_path'],
            'banner' => $data['backdrop_path'], 
            'overview' => $data['overview'],
            'aired' => $data['first_air_date'],
            'rating' => $data['vote_average'],
            'popularity' => $data['popularity'],
            'vote_average' => $data['vote_average']
        ];

        $anime = Anime::create($animeData);

        return redirect()->route('admin.animes.index')->with('success', 'Anime created successfully.');
    }

    public function fetchAnimeData(Request $request)
    {
        $apiKey = null;
        
        $filePath = storage_path('app/api_keys.json');

        if (File::exists($filePath)) {
            $apiKeys = json_decode(File::get($filePath), true);
            $apiKey = $apiKeys['mal'] ?? null;
        }

        if (!$apiKey) {
            return response()->json(['error' => 'API Key for MAL is not configured. Please configure it first.'], 500);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey
        ])->get('https://api.myanimelist.net/v2/anime', [
            'q' => $request->query('q'),
            'limit' => 12,
            'fields' => 'id,title,main_picture,media_type,start_date,num_episodes'
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Unable to fetch data'], 500);
    }

    public function fetchAnimeDataById(Request $request)
    {
        $apiKey = null;
        
        $filePath = storage_path('app/api_keys.json');

        if (File::exists($filePath)) {
            $apiKeys = json_decode(File::get($filePath), true);
            $apiKey = $apiKeys['mal'] ?? null;
        }

        if (!$apiKey) {
            return response()->json(['error' => 'API Key for MAL is not configured. Please configure it first.'], 500);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey
        ])->get('https://api.myanimelist.net/v2/anime/' . $request->query('id').'?fields=id,title,alternative_titles,start_date,end_date,mean,popularity,media_type,status,genres,my_list_status,num_episodes,broadcast,average_episode_duration,rating');

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Unable to fetch data'], 500);
    }

    public function getAnimesData()
    {
        $animes = Anime::select(['id', 'name', 'name_alternative', 'aired', 'status'])->orderBy('id', 'desc'); 

        return DataTables::of($animes)->make(true);
    }

}
