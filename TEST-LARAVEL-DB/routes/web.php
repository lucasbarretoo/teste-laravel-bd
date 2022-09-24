<?php

use App\Http\Controllers\ContatoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ContatoController::class, 'index'])->name('index_contato');
Route::post('/gravarContato', [ContatoController::class, 'gravarContato'])->name('gravar_contato');
Route::get('/editarContato/{contato_id}', [ContatoController::class, 'index'])->name('editar_contato');
Route::post('/excluirContato/{contato_id}', [ContatoController::class, 'excluir'])->name('excluir_contato');
