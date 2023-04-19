<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
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

    public function store(SeriesFormRequest $request)
    {
        //dd($request->all()); dump and die
        //Serie::create($request->only('nome')); busca somente os campos da requisição que for informado
        //Serie::create($request->except('_token')); busca tudo exceto o informado
        $serie = Serie::create($request->all());
        return to_route('series.index')->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
    }

    public function destroy(Serie $series, Request $request)
    {
        $series->delete();
        //uma forma de fazer
        //$request->session()->flash('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso'");

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso'");
    }

    public function edit(Serie $series)
    {
        //dd($series);
        return view('series.edit')->with('serie', $series);
    }

    public function update(Serie $series, SeriesFormRequest $request)
    {
        $series->nome = $request->nome;
        //$series->fill($request->all()); para adicionar campos em massa
        $series->save();

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
    }


}
