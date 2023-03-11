<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $collection = Role::with('permissions.module')
                    ->where('id', $request->id)
                    ->get();

        // return $collection;

        $filtered = $collection[0]->permissions->map(function(Object $obj, int $key) {
            return $obj->only(['module_id', 'id']);
        });

        $grouped = $filtered->mapToGroups(function (array $item, int $key) {
            return [$item['module_id'] => $item['id']];
        });
         
        // $grouped->all();

        return collect()->merge([
            'id' => $collection[0]->id,
            'title' => $collection[0]->title,
            'permissions' => $grouped,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
