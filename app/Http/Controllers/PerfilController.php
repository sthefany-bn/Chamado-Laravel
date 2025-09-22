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
        // GET e POST para cadastro
    public function cadastrar(Request $request)
    {
        if ($request->isMethod('get')) {
            if (Auth::check()) {
                return redirect('/');
            }
            return view('usuario.cadastrar');
        }

        // Validação
        $request->validate([
            'nome' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'senha' => 'required|string|min:6',
        ]);

        // Criação do usuário
        $user = new User();
        $user->name = $request->nome;
        $user->username = $request->username;
        $user->password = Hash::make($request->senha);
        $user->save();

        // Criação do perfil associado
        $perfil = new Perfil();
        $perfil->user_id = $user->id;
        $perfil->nome_completo = $request->nome;
        $perfil->adm = false;
        $perfil->save();

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            if (Auth::check()) {
                return redirect('/');
            }
            return view('usuario.login');
        }

        $credentials = $request->only('username', 'senha');

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['senha']])) {
            $perfil = Auth::user()->perfil;
            return redirect()->route($perfil->adm ? 'ver_chamados' : 'meus_chamados');
        }

        return redirect()->route('login')->with('error', 'Username ou senha inválidos!');
    }

    public function sair(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('success', 'Logout realizado com sucesso!');
    }

    public function atualizar(Request $request, $id)
    {
        $perfil = Perfil::findOrFail($id);

        if ($request->isMethod('get')) {
            return view('usuario.editar', ['perfil' => $perfil]);
        }

        $request->validate([
            'nome_completo' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $perfil->user_id,
        ]);

        $perfil->nome_completo = $request->nome_completo;
        $perfil->save();

        $user = $perfil->user;
        $user->username = $request->username;
        $user->save();

        return redirect()->route('ver_funcionarios')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function verFuncionarios(Request $request)
    {
        $query = Perfil::where('user_id', '!=', Auth::id());

        if ($request->has('adm')) {
            $query->where('adm', $request->input('adm'));
        }

        $perfil = $query->get();
        return view('adm/ver_funcionarios', compact('perfil'));
    }

    public function editarFuncionarios(Request $request)
    {
        //fazer
    }

    public function tornarAdm($id)
    {
        $perfil = Perfil::findOrFail($id);
        $perfil->adm = true;
        $perfil->save();

        return redirect()->route('usuarios/funcionarios')->with('success', "Usuário {$perfil->nome_completo} agora é um administrador!");
    }

    public function retirarAdm($id)
    {
        $perfil = Perfil::findOrFail($id);
        $perfil->adm = false;
        $perfil->save();

        return redirect()->route('usuarios/funcionarios')->with('success', "Usuário {$perfil->nome_completo} não é mais um administrador!");
    }
}
