<?php

namespace App\Http\Controllers;

use App\Models\Cnpj;
use Illuminate\Http\Request;

class CnpjController extends Controller
{
    public function index()
    {
        $cnpjs = Cnpj::all();
        return view('cnpjs.index', compact('cnpjs'));
    }

    public function create()
    {
        return view('cnpjs.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['cnpj'] = preg_replace('/[^0-9]/', '', $data['cnpj']);

        Cnpj::create($data);
        return redirect()->route('cnpjs.index')->with('success', 'CNPJ cadastrado com sucesso.');
    }

    public function edit(Cnpj $cnpj)
    {
        return view('cnpjs.edit', compact('cnpj'));
    }

    public function update(Request $request, Cnpj $cnpj)
    {
        $data = $request->all();
        $data['cnpj'] = preg_replace('/[^0-9]/', '', $data['cnpj']);
    
        $cnpj->update($data);
        return redirect()->route('cnpjs.index')->with('success', 'CNPJ atualizado com sucesso.');
    }

    public function destroy(Cnpj $cnpj)
    {
        $cnpj->delete();
        return redirect()->route('cnpjs.index')->with('success', 'CNPJ deletado com sucesso.');
    }
}
