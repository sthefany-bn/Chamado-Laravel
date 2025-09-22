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

    public function fazerChamado(Request $request)
    {
        if ($request->isMethod('get')) {
            $perfis = Perfil::where('adm', true)->where('id', '!=', 1)->get();
            return view('usuario/fazer_chamado', compact('perfis'));
        }

        if ($request->isMethod('post')) {
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
                        $path = $arquivo->store('arquivos');
                        Arquivo::create([
                            'chamado_id' => $chamado->id,
                            'arquivo' => $path
                        ]);
                    }
                }

                return redirect()->route('meus_chamados')->with('success', 'Chamado enviado com sucesso!');
            } catch (\Exception $e) {
                return redirect()->route('meus_chamados')->with('error', 'Erro ao enviar chamado!');
            }
        }
    }

    public function editarChamado(Request $request, $id)
    {
        $chamado = Chamado::findOrFail($id);
        $perfis = Perfil::where('adm', true)->get();

        if ($request->isMethod('get')) {
            return view('usuario/editar_chamado', compact('chamado', 'perfis'));
        }

        if ($request->isMethod('post')) {
            try {
                $chamado->titulo = $request->input('titulo');
                $chamado->descricao = $request->input('descricao');
                $chamado->responsavel_id = $request->input('responsavel');
                $chamado->save();

                if ($request->hasFile('arquivos')) {
                    foreach ($request->file('arquivos') as $arquivo) {
                        $path = $arquivo->store('arquivos');
                        Arquivo::create([
                            'chamado_id' => $chamado->id,
                            'arquivo' => $path
                        ]);
                    }
                }

                return redirect()->route('meus_chamados')->with('success', 'Chamado atualizado com sucesso!');
            } catch (\Exception $e) {
                return redirect()->route('meus_chamados')->with('error', 'Erro ao atualizar chamado!');
            }
        }
    }

    public function verMeusChamados()
    {
        $perfil = Auth::user()->perfil;
        $chamados = Chamado::where('autor_id', $perfil->id)->get();

        $ativos = $chamados->whereNotIn('status', ['cancelado', 'finalizado'])->count();
        $finalizados = $chamados->where('status', 'finalizado')->count();
        $cancelados = $chamados->where('status', 'cancelado')->count();

        return view('usuario/ver_meus_chamados', compact('perfil', 'chamados', 'ativos', 'finalizados', 'cancelados'));
    }

    public function cancelarChamado($id)
    {
        $chamado = Chamado::findOrFail($id);
        if ($chamado->status == 'nao_iniciado') {
            $chamado->status = 'cancelado';
            $chamado->save();
            return redirect()->route('meus_chamados');
        } else {
            return redirect()->route('meus_chamados')->with('error', 'Esse chamado não pode ser cancelado pois já foi iniciado');
        }
    }

    public function removerArquivo($id)
    {
        $arquivo = Arquivo::findOrFail($id);
        Storage::delete($arquivo->arquivo);
        $arquivo->delete();
        return back()->with('success', 'Arquivo deletado com sucesso!');
    }

    public function verDetalhes($id)
    {
        $chamado = Chamado::with('arquivos')->findOrFail($id);
        return view('usuario/ver_detalhes', compact('chamado'));
    }

    // ADMIN
    public function verChamados(Request $request)
    {
        $status = $request->query('status');
        $chamados = $status 
            ? Chamado::where('status', $status)->get()
            : Chamado::all();

        $quantidade = $chamados->count();

        return view('adm/ver_chamado', compact('chamados', 'quantidade'));
    }

    public function verFuncionarios(Request $request)
    {
        $tipo = $request->query('adm');
        $query = Perfil::where('user_id', '!=', Auth::id());

        if ($tipo !== null) {
            $query->where('adm', $tipo);
        }

        $perfil = $query->get();
        $quantidade = $perfil->count();

        return view('adm/ver_funcionarios', compact('perfil', 'quantidade'));
    }

    public function tornarAdm($id)
    {
        $perfil = Perfil::findOrFail($id);
        $perfil->adm = true;
        $perfil->save();

        return redirect()->route('funcionarios.ver')->with('success', "Usuário {$perfil->nome_completo} agora é um administrador!");
    }

    public function retirarAdm($id)
    {
        $perfil = Perfil::findOrFail($id);
        $perfil->adm = false;
        $perfil->save();

        return redirect()->route('funcionarios.ver')->with('success', "Usuário {$perfil->nome_completo} não é mais um administrador!");
    }

    public function verMinhasTarefas()
    {
        $perfil = Auth::user()->perfil;
        $chamados = Chamado::where('responsavel_id', $perfil->id)
            ->where('status', '!=', 'cancelado')
            ->get();

        $quantidade = $chamados->count();

        return view('adm/ver_minhas_tarefas', compact('chamados', 'quantidade'));
    }

    public function ifc($id, $status)
    {
        $chamado = Chamado::findOrFail($id);
        $chamado->status = $status;
        $chamado->save();

        return redirect()->route('tarefas.minhas');
    }
}
