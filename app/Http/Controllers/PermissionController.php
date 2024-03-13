<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ResourceRepository;
use App\Models\Permission;

class PermissionController extends Controller
{
    protected $repository;
    public function __construct(){
        $this->repository = new PermissionRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->selectAllWith(['role', 'resource']);
        return $data;
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
        $objRole = (new RoleRepository())->findById($request->role_id);
        $objResource = (new ResourceRepository())->findById($request->resource_id);
    
        if(isset($objRole) && isset($objResource)) {
            $obj = new Permission();
            $obj->permission = $request->permissao;
            $obj->role()->associate($objRole);
            $obj->resource()->associate($objResource);
            $this->repository->save($obj);
            
            return "Ok";
        }

        return "Erroo..";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->repository->findByCompositeIdWith(
            Permission::getKeys(), // keys
            explode("_", $id), // ids
            ['role', 'resource'] // orm
            );
        
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = $this->repository->findByCompositeId(
            Permission::getKeys(), // keys
            explode("_", $id) // ids
            );
        
        $objRole = (new RoleRepository())->findById($request->role_id);

        $objResource = (new ResourceRepository())->findById($request->resource_id);
        if(isset($obj) && isset($objRole) && isset($objResource)) {
            if($this->repository->updateCompositeId(
                Permission::getKeys(),     // keys
                explode("_", $id),         // ids
                "permissions",             // table
                [                          // values
                "permission" => $request->permissao
                ]
            ))
            {
                return "Ok";
            }
        }
        return "Erro..";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->deleteCompositeId(
            Permission::getKeys(), // keys
            explode("_", $id),     // ids
            "permissions"          // table
        ))
        {
            return "<h1>Delete - OK!</h1>";
        }
        return "<h1>Delete - Not found Eixo!</h1>";
    }
}
