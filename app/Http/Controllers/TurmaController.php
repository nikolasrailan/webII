<?php

namespace App\Http\Controllers;

use App\Repositories\TurmaRepository;
use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    protected $repository;
    
    public function __construct(){
        $this->repository = new TurmaRepository();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->selectAllWith(['curso']);
        
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
        $objCurso = (new CursoRepository())->findById($request->curso_id);
        
        if(isset($objCurso)) {
            $obj = new Turma();
            $obj->ano = $request->ano;
            $obj->curso()->associate($objCurso);
            $this->repository->save($obj);
            return "Foi";
        }
        
        return "Erro..";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->repository->findById($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $obj = $this->repository->findById($id);
        $objCurso = (new CursoRepository())->findById($request->curso_id);
        
        if(isset($obj) && isset($objCurso)) {
            $obj->ano = $request->ano;
            $obj->curso()->associate($objCurso);
            $this->repository->save($obj);
            return "Foi";
        }
        
        return "Erro";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->repository->delete($id))  {
            return "Foi";
        }
        
        return "Erro..";
    }
}
