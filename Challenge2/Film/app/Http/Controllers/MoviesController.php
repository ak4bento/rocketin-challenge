<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMoviesRequest;
use App\Http\Resources\MovieResource;
use App\Services\MoviesService;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /** @var  MoviesService */
    public $service;

    /**
     * MoviesController constructor.
     */
    public function __construct()
    {
        $this->service = new MoviesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return MovieResource::collection($this->service->getIndexData());
        $data = $this->service->getIndexData([
            'id' => 'id',
            'title' => 'title',
            'description' => 'description',
            'artists' => 'artists',
            'genres' => 'genres',
        ]);
        
        return (MovieResource::collection($data))->additional([
            'sortableAndSearchableColumn' => $data->sortableAndSearchableColumn,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMoviesRequest $request)
    {
        $data = $this->service->create($request->all());
        return new MovieResource($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMoviesRequest $request, $id)
    {
        $data = $this->service->update($id, $request->all());
        return new MovieResource($data);
    }
}
