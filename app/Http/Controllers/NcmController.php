<?php

namespace App\Http\Controllers;

use App\Models\Ncm;
use Illuminate\Http\Request;

class NcmController extends Controller
{
    public function index()
    {
        return view('ncms.index', ['ncms' => Ncm::all()]);
    }

    public function create()
    {
        return view('ncms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ncm' => 'required|unique:ncms'
        ]);
    
        $data = $request->all();
        $data['ncm'] = preg_replace('/[^0-9]/', '', $data['ncm']);
    
        Ncm::create($data);
    
        return redirect()->route('ncms.index')
                        ->with('success', 'NCM criado com sucesso.');
    }

    public function edit(Ncm $ncm)
    {
        return view('ncms.edit', compact('ncm'));
    }

    public function update(Request $request, Ncm $ncm)
    {
        $request->validate([
            'ncm' => 'required|unique:ncms,ncm,' . $ncm->id
        ]);

        $data = $request->all();
        $data['ncm'] = preg_replace('/[^0-9]/', '', $data['ncm']);

        $ncm->update($data);

        return redirect()->route('ncms.index')
                        ->with('success', 'NCM atualizado com sucesso.');
    }

    public function destroy(Ncm $ncm)
    {
        $ncm->delete();

        return redirect()->route('ncms.index')
                        ->with('success', 'NCM deletado com sucesso.');
    }
}
