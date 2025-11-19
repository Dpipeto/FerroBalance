<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;

// -------------------------
// Rutas públicas
// -------------------------
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// -------------------------
// Autenticación (solo invitados)
// -------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/registro', [RegisterController::class, 'showRegistrationForm'])->name('registro');
    Route::post('/registro', [RegisterController::class, 'register']);
});

// -------------------------
// Logout (solo autenticados)
// -------------------------
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// -------------------------
// Productos (CRUD completo)
// -------------------------
Route::resource('productos', ProductController::class);

// -------------------------
// Compras (solo clientes)
// -------------------------
Route::middleware(['auth', 'role:Cliente'])->group(function () {
    Route::get('/compras', [CompraController::class, 'index'])->name('compras.index');
    Route::post('/compras', [CompraController::class, 'store'])->name('compras.store');
    Route::delete('/compras/{id}', [CompraController::class, 'destroy'])->name('compras.destroy');

    // Generar factura y pago al comprar
    Route::post('/compras/checkout', [CompraController::class, 'checkout'])->name('compras.checkout');

    // Ver detalle del pago y factura
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
});

// -------------------------
// Dashboard (solo administrador)
// -------------------------
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/users/{id}/update-role', [AdminController::class, 'updateRole'])->name('users.updateRole');
});

// -------------------------
// Facturas (solo Cajero, Almacenista, Administrador)
// -------------------------
Route::middleware(['auth', 'role:Cajero,Almacenista,Administrador'])->group(function () {
    Route::get('/facturas', [FacturaController::class, 'index'])->name('facturas.index');
    Route::get('/facturas/crear', [FacturaController::class, 'create'])->name('facturas.create');
    Route::post('/facturas', [FacturaController::class, 'store'])->name('facturas.store');
    Route::get('/facturas/{factura}', [FacturaController::class, 'show'])->name('facturas.show');
});
