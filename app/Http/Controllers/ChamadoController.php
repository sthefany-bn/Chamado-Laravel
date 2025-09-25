<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chamado;
use App\Models\Arquivo;
use App\Models\Perfil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ChamadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //chamados
    public function meusChamados()
    {
        $perfil = Auth::user()->perfil;
        $chamados = Chamado::where('autor_id', $perfil->id)->get();

        $ativos = $chamados->whereNotIn('status', ['cancelado', 'finalizado'])->count();
        $finalizados = $chamados->where('status', 'finalizado')->count();
        $cancelados = $chamados->where('status', 'cancelado')->count();

        return view('usuario/ver_meus_chamados', compact('perfil', 'chamados', 'ativos', 'finalizados', 'cancelados'));
    }

    public function getFazerChamado(Request $request)
    {
        $perfis = Perfil::where('adm', true)->where('id', '!=', 1)->get();
        return view('usuario/fazer_chamado', compact('perfis'));
    }

    public function postFazerChamado(Request $request)
    {
        try {
            $chamado = new Chamado();
            $chamado->titulo = $request->input('titulo');
            $chamado->descricao = $request->input('descricao');
            $chamado->status = 'nao_iniciado';
            $chamado->data = now();
            $chamado->autor_id = Auth::user()->perfil->id;
            $chamado->responsavel_id = $request->input('responsavel');
            $chamado->save();

            if ($request->hasFile('arquivos')) {
                foreach ($request->file('arquivos') as $arquivo) {
                    $path = $arquivo->store('arquivos', 'public');
                    Arquivo::create([
                        'chamado_id' => $chamado->id,
                        'arquivo' => $path,
                        'nome_original' => $arquivo->getClientOriginalName()
                    ]);
                }
            }

            return redirect()->route('meus_chamados')->with('success', 'Chamado enviado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('meus_chamados')->with('error', 'Erro ao enviar chamado!');
        }
    }

    public function getEditarChamado(Request $request, $id)
    {
        $chamado = Chamado::findOrFail($id);
        $perfis = Perfil::where('adm', true)->get();
        return view('usuario/editar_chamado', compact('chamado', 'perfis'));
    }

    public function postEditarChamado(Request $request, $id)
    {
        $chamado = Chamado::findOrFail($id);
        try {
            $chamado->titulo = $request->input('titulo');
            $chamado->descricao = $request->input('descricao');
            $chamado->responsavel_id = $request->input('responsavel');
            $chamado->save();

            if ($request->hasFile('arquivos')) {
                foreach ($request->file('arquivos') as $arquivo) {
                    $path = $arquivo->store('arquivos', 'public');
                    Arquivo::create([
                        'chamado_id' => $chamado->id,
                        'arquivo' => $path,
                        'nome_original' => $arquivo->getClientOriginalName()
                    ]);
                }
            }

            return redirect()->route('meus_chamados')->with('success', 'Chamado atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('meus_chamados')->with('error', 'Erro ao atualizar chamado!');
        }
    }

    public function verDetalhes($id)
    {
        $chamado = Chamado::with('arquivos')->findOrFail($id);
        return view('usuario/ver_detalhes', compact('chamado'));
    }

    public function cancelarChamado($id)
    {
        $chamado = Chamado::findOrFail($id);
        if ($chamado->status == 'nao_iniciado') {
            $chamado->status = 'cancelado';
            $chamado->save();
            return redirect()->route('meus_chamados');
        } else {
            return redirect()->route('meus_chamados')->with('error', 'Esse chamado não pode ser cancelado pois já foi iniciado!');
        }
    }


    //arquivos
    public function removerArquivo($id)
    {
        $arquivo = Arquivo::findOrFail($id);
        Storage::delete($arquivo->arquivo);
        $arquivo->delete();
        return back()->with('success', 'Arquivo deletado com sucesso!');
    }


    //adm
    public function verChamados(Request $request)
    {
        if (!Auth::user()->adm) {
            abort(403, 'Acesso negado');
        }

        $status = $request->query('status');
        $query = Chamado::orderBy('titulo', 'asc');

        if ($status) {
            $query->where('status', $status);
        }

        $chamados = $query->get();
        $quantidade = $chamados->count();

        return view('adm/ver_chamado', compact('chamados', 'quantidade'));
    }

    public function minhasTarefas()
    {
        if (!Auth::user()->adm) {
            abort(403, 'Acesso negado');
        }

        $perfil = Auth::user()->perfil;
        $chamadosAtivos = Chamado::where('responsavel_id', $perfil->id)
            ->whereNotIn('status', ['cancelado', 'finalizado'])
            ->orderBy('data', 'desc')
            ->get();

        $chamadosInativos = Chamado::where('responsavel_id', $perfil->id)
            ->whereIn('status', ['cancelado', 'finalizado'])
            ->orderBy('data', 'desc')
            ->get();

        return view('adm/ver_minhas_tarefas', compact('chamadosAtivos', 'chamadosInativos'));
    }

    public function ifc($id, $status) //iniciar, finalizar, cancelar
    {
        if (!Auth::user()->adm) {
            abort(403, 'Acesso negado');
        }

        $chamado = Chamado::findOrFail($id);
        $chamado->status = $status;
        $chamado->save();

        return redirect()->route('ver_minhas_tarefas');
    }
}
