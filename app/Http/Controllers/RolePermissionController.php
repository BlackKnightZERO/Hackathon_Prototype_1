<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
        $collection = Role::with('permissions.module')
                    ->where('id', $id)
                    ->get();

        $filtered = $collection[0]->permissions->map(function(Object $obj, int $key) {
            return $obj->only(['module_id', 'id']);
        });

        $grouped = $filtered->mapToGroups(function (array $item, int $key) {
            return [$item['module_id'] => $item['id']];
        });

        return response()->json([
            collect()->merge([
                'id' => $collection[0]->id,
                'title' => $collection[0]->title,
                'permissions' => $grouped,
            ])
            ], 200);
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
        $role = Role::find($id);

        $this->validate($request, [
            'syncData' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            foreach($request->syncData as $data) {
                // return $data['permissions'];
                foreach($data['permissions'] as $permission) {
                    if($permission['value'] == false) {
                        $role->permissions()->detach($permission['id']);
                    } else if ($permission['value'] == true) {
                        $role->permissions()->detach($permission['id']);
                        $role->permissions()->attach($permission['id']);
                    }
                }
            }
        DB::commit();
        return $this->success([
            'message' => 'Permissions updated successfully'
        ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error('', 'Failed to update permissions', 500);
            // Write On Log
        }
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
