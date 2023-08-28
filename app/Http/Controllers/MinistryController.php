<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\MinistryResource;
use App\Models\Ministry;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Traits\HttpRes;
use App\Http\Requests\StoreMinistryRequest;
use App\Http\Requests\UpdateMinistryRequest;
use Illuminate\Support\Str;

class MinistryController extends Controller
{

    use HttpRes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return MinistryResource::collection(
            Ministry::WHERE('title', 'LIKE', '%'.$request->search.'%')
                    ->orderBy('id', 'DESC')
                    ->paginate(config('app.pagination')) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    public function store(StoreMinistryRequest $request)
    {
        $ministry = Ministry::create([
            'title'         => $request->title,
            'short_title'   => Str::substr((Str::upper($request->title)), 0,4),
            'description'   => $request->description,
            'slug'          => SlugService::createSlug(Ministry::class, 'slug', $request->title, ['unique' => true]),
        ]);

        return $this->success('201', 'Ministry Added Successfully', $ministry);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    public function update(UpdateMinistryRequest $request, $id)
    {
        Ministry::where('id', $id)
                    ->update([
                        'title'         => $request->title,
                        'short_title'   => Str::substr((Str::upper($request->title)), 0,4),
                        'description'   => $request->description,
                        'slug'          => SlugService::createSlug(Ministry::class, 'slug', $request->title, ['unique' => true]),
                    ]);
        $ministry = Ministry::find($id);
        return $this->success('202', 'Ministry Updated Successfully', $ministry);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ministry::destroy($id);
        return $this->success('200', 'Ministry Deleted Successfully', []);
    }
}
