<?php

use App\Http\Controllers\CommissTransactionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoCartaConducaoController;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Rota para listar os tipos de carta de condução
Route::get('/tipos_carta_conducao', [TipoCartaConducaoController::class, 'index'])->name('tipos_carta_conducao.index');

// Rota para exibir o formulário de criação de um novo tipo de carta de condução
Route::get('/tipos_carta_conducao/create', [TipoCartaConducaoController::class, 'create'])->name('tipos_carta_conducao.create');

// Rota para armazenar um novo tipo de carta de condução no banco de dados
Route::post('/tipos_carta_conducao', [TipoCartaConducaoController::class, 'store'])->name('tipos_carta_conducao.store');

// Rota para exibir os detalhes de um tipo de carta de condução específico
Route::get('/tipos_carta_conducao/{id}', [TipoCartaConducaoController::class, 'show'])->name('tipos_carta_conducao.show');

// Rota para exibir o formulário de edição de um tipo de carta de condução específico
Route::get('/tipos_carta_conducao/{id}/edit', [TipoCartaConducaoController::class, 'edit'])->name('tipos_carta_conducao.edit');

// Rota para atualizar um tipo de carta de condução no banco de dados
Route::put('/tipos_carta_conducao/{id}', [TipoCartaConducaoController::class, 'update'])->name('tipos_carta_conducao.update');

// Rota para excluir um tipo de carta de condução do banco de dados
Route::delete('/tipos_carta_conducao/{id}', [TipoCartaConducaoController::class, 'destroy'])->name('tipos_carta_conducao.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('customers', CustomerController::class);
    
    Route::resource('customers', CustomerController::class);

    Route::get('aluno/{id}', [CustomerController::class, 'showAluno'])->name('aluno.show');
    
    Route::resource('users', UserController::class);
    //   Route::resource('users', UserController::class)->middleware('role:admin');

    Route::resource('payments', PaymentsController::class)->except(['edit', 'destroy']);
    Route::resource('payments.invoice', PaymentsController::class)->except(['edit', 'destroy']);
    Route::get('download-receipt/{payment}', [PaymentsController::class, 'receipt'])->name('payments.receipt');
    

    Route::resource('loans', LoanController::class);
    Route::get('loan/opened', [LoanController::class, 'index'])->name('loans.opened');//Futuro
    Route::get('loan/closed', [LoanController::class, 'index'])->name('loans.closed');//Futuro

    Route::get('loans/customer/{loan}', [LoanController::class, 'getCustomer'])->name('loans.customer');
    Route::get('loans/customer/{loan}', [LoanController::class, 'getCustomer'])->name('loans.customer');

    Route::resource('commissions', CommissTransactionController::class)->except(['edit', 'destroy']);
    Route::get('commissions/rep/{id}', [CommissTransactionController::class, 'getRep'])->name('commissions.rep');

    Route::get('reports/{type?}', [ReportController::class, 'show'])->name('reports.show');


});

require __DIR__ . '/auth.php';
