<?php

namespace App\Http\Controllers;

use App\Models\TipoCartaConducao;
use App\Models\Payment;
use App\Models\User;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \PDF;


class TipoCartaConducaoController extends Controller
{

    public function index()
    {
        $tiposCartaConducao = TipoCartaConducao::all();
        return view('tipos_carta_conducao.index', compact('tiposCartaConducao'));
    }

    public function create()
    {
        return view('tipos_carta_conducao.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'custo' => 'required|numeric',
            'description' => 'nullable',
        ]);

        TipoCartaConducao::create($data);

        return redirect()->route('tipos_carta_conducao.index');
    }

    public function show($id)
    {
        $tipoCartaConducao = TipoCartaConducao::find($id);
        return view('tipos_carta_conducao.show', compact('tipoCartaConducao'));
    }

    public function edit($id)
    {
        $tipoCartaConducao = TipoCartaConducao::find($id);
        return view('tipos_carta_conducao.edit', compact('tipoCartaConducao'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'custo' => 'required|numeric',
            'description' => 'nullable',
        ]);

        $tipoCartaConducao = TipoCartaConducao::find($id);
        $tipoCartaConducao->update($data);

        return redirect()->route('tipos_carta_conducao.index');
    }

    public function destroy($id)
    {
        $tipoCartaConducao = TipoCartaConducao::find($id);
        $tipoCartaConducao->delete();

        return redirect()->route('tipos_carta_conducao.index');
    }


}
