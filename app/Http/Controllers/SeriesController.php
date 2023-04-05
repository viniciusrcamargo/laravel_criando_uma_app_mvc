<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(){
        //$series = Serie::all();
        $series = Serie::query()->orderBy('nome')->get();

        return view('series.index')->with('series', $series);
    }

    public function create(){
        return view('series.create');
    }

    public function store(Request $request)
    {
        //dd($request->all()); dump and die
        //Serie::create($request->only('nome')); busca somente os campos da requisição que for informado
        //Serie::create($request->except('_token')); busca tudo exceto o informado
        Serie::create($request->all());

        return redirect('series');
    }
}
