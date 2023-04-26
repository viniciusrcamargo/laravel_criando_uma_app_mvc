<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request){
        //$series = Series::all();
        $series = Series::query()->orderBy('nome')->get();
        $mensagemSucesso = $request->session()->get('mensagem.sucesso');
        //dd($mensagemSucesso);
        return view('series.index')->with('series', $series)->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create(){
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        //dd($request->all()); //dump and die
        //Series::create($request->only('nome')); busca somente os campos da requisição que for informado
        //Series::create($request->except('_token')); busca tudo exceto o informado
        $serie = Series::create($request->all());

        for($i = 1; $i < $request->seasonsQty; $i++){
            $season = $serie->seasons()->create([
                'number' => $i,
            ]);

            for($j = 1; $j < $request->episodesPerSeason; $j++){
                $season->episodes()->create([
                    'number' => $j
                ]);
            }
        }
        return to_route('series.index')->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
    }

    public function destroy(Series $series, Request $request)
    {
        $series->delete();
        //uma forma de fazer
        //$request->session()->flash('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso'");

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso'");
    }

    public function edit(Series $series)
    {
        //dd($series);
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->nome = $request->nome;
        //$series->fill($request->all()); para adicionar campos em massa
        $series->save();

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
    }


}
