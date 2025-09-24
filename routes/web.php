<?php

use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;

//cadastro
Route::get('/usuario/cadastrar', [PerfilController::class, 'getCadastrar'])->name('cadastrar');
Route::post('/usuario/cadastrar', [PerfilController::class, 'postCadastrar']);

//login
Route::get('/usuario/login', [PerfilController::class, 'getLogin'])->name('login');
Route::post('/usuario/login', [PerfilController::class, 'postLogin']);

//saida
Route::post('/usuario/sair', [PerfilController::class, 'sair'])->name('sair');

Route::middleware(['auth'])->group(function () {
    //chamados
    Route::get('/', [ChamadoController::class, 'meusChamados'])->name('meus_chamados');
    Route::get('/fazer_chamado', [ChamadoController::class, 'getFazerChamado'])->name('fazer_chamado');
    Route::post('/fazer_chamado', [ChamadoController::class, 'postFazerChamado'])->name('fazer_chamado_store');
    Route::get('/editar_chamado/{id}', [ChamadoController::class, 'getEditarChamado'])->name('editar_chamados');
    Route::post('/editar_chamado/{id}', [ChamadoController::class, 'postEditarChamado'])->name('atualizar_chamados');
    Route::get('/ver_detalhes/{id}', [ChamadoController::class, 'verDetalhes'])->name('ver_detalhes');
    Route::post('/cancelar_chamado/{id}', [ChamadoController::class, 'cancelarChamado'])->name('cancelar_chamado');

    //arquivo
    Route::get('/remover_arquivo/{id}', [ChamadoController::class, 'removerArquivo'])->name('remover_arquivo');

    //adm
    Route::get('/ver_chamados', [ChamadoController::class, 'verChamados'])->name('ver_chamados');
    Route::get('/ver_minhas_tarefas', [ChamadoController::class, 'minhasTarefas'])->name('ver_minhas_tarefas');
    Route::get('/ifc/{id}/{status}', [ChamadoController::class, 'ifc'])->name('ifc'); //iniciar, finalizar, cancelar

    //adm -> funcionarios 
    Route::get('/ver_funcionarios', [PerfilController::class, 'verFuncionarios'])->name('ver_funcionarios');
    Route::get('/editar_funcionarios/{id}', [PerfilController::class, 'getEditarFuncionarios'])->name('editar_funcionarios');
    Route::post('/editar_funcionarios/{id}', [PerfilController::class, 'postEditarFuncionarios'])->name('atualizar_funcionarios');
    Route::get('/tornar_adm/{id}', [PerfilController::class, 'tornarAdm'])->name('tornar_adm');
    Route::get('/retirar_adm/{id}', [PerfilController::class, 'retirarAdm'])->name('retirar_adm');
});
