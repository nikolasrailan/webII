<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CursoRepository;
use App\Repositories\EixoRepository;
use App\Repositories\NivelRepository;
use App\Models\Curso;

class CursoController extends Controller
{

    protected $repository;
    public function __construct(){
        $this->repository = new CursoRepository();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->selectAllWith(['eixo', 'nivel']);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $objEixo = (new EixoRepository())->findById($request->eixo_id);
        $objNivel = (new NivelRepository())->findById($request->nivel_id);

        if(isset($objEixo) && isset($objNivel)) {
            $obj = new Curso();
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->sigla = mb_strtoupper($request->sigla, 'UTF-8');
            $obj->total_horas = $request->horas;
            $obj->eixo()->associate($objEixo);
            $obj->nivel()->associate($objNivel);
            $this->repository->save($obj);
        
            return "Okk, foi";
        }
        return "ERRO..";
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = $this->repository->findById($id);
        $objEixo = (new EixoRepository())->findById($request->eixo_id);
        $objNivel = (new NivelRepository())->findById($request->nivel_id);
        if(isset($obj) && isset($objEixo) && isset($objNivel)) {
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');
            $obj->sigla = mb_strtoupper($request->sigla, 'UTF-8');
            $obj->total_horas = $request->horas;
            $obj->eixo()->associate($objEixo);
            $obj->nivel()->associate($objNivel);
            $this->repository->save($obj);
        
            return "<h1>Upate - OK!</h1>";
        }
        return "<h1>Upate - Not found Curso or Eixo or Nível!</h1>";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->repository->findById($id);
        return $data;
    }
}
