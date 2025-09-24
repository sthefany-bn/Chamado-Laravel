<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PerfilController extends Controller
{
    //cadastrar
    public function getCadastrar(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('usuario.cadastrar');
    }

    public function postCadastrar(Request $request)
    {
        $user = new User();
        $user->name = $request->nome;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        $perfil = new Perfil();
        $perfil->user_id = $user->id;
        $perfil->nome_completo = $request->nome;
        $perfil->adm = false;
        $perfil->save();

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso!');
    }


    //login
    public function getLogin(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('usuario.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $perfil = Auth::user()->perfil;
            return redirect()->route($perfil->adm ? 'ver_chamados' : 'meus_chamados');
        }

        return redirect()->route('login')->with('error', 'Username ou senha inválidos!');
    }


    //saida
    public function sair(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('success', 'Logout realizado com sucesso!');
    }


    //adm -> funcionarios
    public function verFuncionarios(Request $request)
    {
        $query = Perfil::where('user_id', '!=', Auth::id())
            ->whereHas('user', function ($q) {
                $q->where('name', '!=', 'Admin');
            });

        if ($request->has('adm')) {
            $query->where('adm', $request->input('adm'));
        }

        $perfil = $query->orderBy('nome_completo')->get();
        $quantidade = $perfil->count();

        return view('adm/ver_funcionarios', compact('perfil', 'quantidade'));
    }

    public function getEditarFuncionarios(Request $request, $id)
    {
        $perfil = Perfil::with('user')->findOrFail($id);
        return view('adm/editar_funcionarios', compact('perfil'));
    }

    public function postEditarFuncionarios(Request $request, $id)
    {
        $perfil = Perfil::with('user')->findOrFail($id);
        $perfil->nome_completo = $request->input('nome_completo');
        $perfil->save();

        $perfil->user->username = $request->input('username');
        $perfil->user->save();

        return redirect()->route('ver_funcionarios')->with('success', 'Funcionário atualizado com sucesso!');
    }


    //mudar funcionario -> adm
    public function tornarAdm($id)
    {
        $perfil = Perfil::findOrFail($id);
        $perfil->adm = true;
        $perfil->save();

        return redirect()->route('ver_funcionarios')->with('success', "{$perfil->nome_completo} agora é um administrador!");
    }

    //mudar adm -> funcionario
    public function retirarAdm($id)
    {
        $perfil = Perfil::findOrFail($id);
        $perfil->adm = false;
        $perfil->save();

        return redirect()->route('ver_funcionarios')->with('success', "{$perfil->nome_completo} não é mais um administrador!");
    }
}
