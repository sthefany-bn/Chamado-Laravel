<?php

use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\PerfilController;
use App\Models\Perfil;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    //Chamados
    Route::get('/fazer_chamado', [ChamadoController::class, 'create'])->name('fazer_chamado');
    Route::post('/fazer_chamado', [ChamadoController::class, 'store'])->name('fazer_chamado_store');

    Route::get('/', [ChamadoController::class, 'meusChamados'])->name('meus_chamados');
    Route::get('/editar_chamado/{id}', [ChamadoController::class, 'edit'])->name('editar_chamados');
    Route::post('/editar_chamado/{id}', [ChamadoController::class, 'update'])->name('atualizar_chamados');

    Route::get('/ver_detalhes/{id}', [ChamadoController::class, 'show'])->name('ver_detalhes');
    Route::get('/cancelar_chamado/{id}', [ChamadoController::class, 'cancel'])->name('cancelar_chamado');
    Route::get('/remover_arquivo/{id}', [ChamadoController::class, 'removerArquivo'])->name('remover_arquivo');

    //Admin
    Route::get('/ver_chamados', [ChamadoController::class, 'verTodos'])->name('ver_chamados');
    Route::get('/ver_funcionarios', [PerfilController::class, 'verFuncionarios'])->name('ver_funcionarios');
    Route::get('/editar_funcionarios', [PerfilController::class, 'editarFuncionarios'])->name('editar_funcionarios');
    Route::get('/tornar_adm/{id}', [PerfilController::class, 'tornarAdm'])->name('tornar_adm');
    Route::get('/retirar_adm/{id}', [PerfilController::class, 'retirarAdm'])->name('retirar_adm');
    Route::get('/ver_minhas_tarefas', [ChamadoController::class, 'minhasTarefas'])->name('ver_minhas_tarefas');
    Route::get('/ifc/{id}/{status}', [ChamadoController::class, 'ifc'])->name('ifc'); //iniciar, finalizar, cancelar
    
    //Cadastro
    Route::get('/usuario/cadastrar', [PerfilController::class, 'cadastrar'])->name('register');
    Route::post('/usuario/cadastrar', [PerfilController::class, 'cadastrar']);
    
    //Login
    Route::get('/usuario/login', [PerfilController::class, 'login'])->name('login');
    Route::post('/usuario/login', [PerfilController::class, 'login']);

    //Sair
    Route::post('/usuario/sair', [PerfilController::class, 'sair'])->name('logout');

});
