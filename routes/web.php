<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageGeneratorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/page-generator', [PageGeneratorController::class, 'index'])->name('page.generator.index');
Route::post('/page-generator/generate', [PageGeneratorController::class, 'generate'])->name('page.generator.generate');
Route::get('/page-generator/list', [PageGeneratorController::class, 'list'])->name('page.generator.list');

// Rota para visualizar a página (pública) utilizando o slug
Route::get('/page/{slug}', [PageGeneratorController::class, 'show'])->name('page.generator.show');

// Rota para exibir o formulário de edição
Route::get('/page-generator/{id}/edit', [PageGeneratorController::class, 'edit'])->name('page.generator.edit');

// Rota para atualizar a página (método PUT)
Route::put('/page-generator/{id}', [PageGeneratorController::class, 'update'])->name('page.generator.update');

// Rota para excluir a página (método DELETE)
Route::delete('/page-generator/{id}', [PageGeneratorController::class, 'destroy'])->name('page.generator.destroy');


