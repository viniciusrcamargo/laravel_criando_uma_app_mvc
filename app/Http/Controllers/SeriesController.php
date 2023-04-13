<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request){
        //$series = Serie::all();
        $series = Serie::query()->orderBy('nome')->get();
        $mensagemSucesso = $request->session()->get('mensagem.sucesso');
        //dd($mensagemSucesso);
        return view('series.index')->with('series', $series)->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create(){
        return view('series.create');
    }

    public function store(Request $request)
    {
        //dd($request->all()); dump and die
        //Serie::create($request->only('nome')); busca somente os campos da requisição que for informado
        //Serie::create($request->except('_token')); busca tudo exceto o informado
        $serie = Serie::create($request->all());
        $request->session()->flash('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
        //dd($request->session());
        return to_route('series.index');
    }

    public function destroy(Serie $series, Request $request)
    {
        $series->delete();
        $request->session()->flash('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso'");

        return to_route('series.index');
    }
}
