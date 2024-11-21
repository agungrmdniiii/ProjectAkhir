<?php
use App\Http\Controllers\PersediaanBarangController;
use App\Http\Controllers\PengajuanBarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_DangerZ;
use App\Http\Controllers\userss;

use App\Http\Controllers\dataController;

use App\Http\Controllers\Rondacon;
use App\Http\Controllers\kondisicuaca;
use App\Http\Controllers\KondisiTanah;
use App\Http\Controllers\monitoring;
use App\Http\Controllers\PemilikController;
Route::middleware(['guest'])->group(function(){
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
    Route::get('/register', [SesiController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [SesiController::class, 'register']);
});

Route::middleware(['auth'])->group(function(){
    Route::get('/logout', [SesiController::class, 'logout']);
    Route::get('/home',[HomeController::class, 'index']);
});

Route::resource('data', dataController::class );


Route::get('/inputdata',[KondisiTanah::class,'index'] );
Route::post('/data/store', [KondisiTanah::class, 'store'])->name('data.store');
Route::get('/datapertanian', [KondisiTanah::class, 'show'])->name('data.show');
Route::get('/datapertanian/{id}/edit', [KondisiTanah::class, 'edit'])->name('data.edit');
Route::put('/datapertanian/{id}', [KondisiTanah::class, 'update'])->name('data.update');
Route::delete('/datapertanian/{id}', [KondisiTanah::class, 'destroy'])->name('data.destroy');
route::get('/hasilpertanian', [KondisiTanah::class, 'hasilPertanian'])->name('data.hasil');





Route::get('/editdata',[userss::class,'index']);
Route::get('/danger',[C_DangerZ::class,'index']);
Route::get('/history',[C_DangerZ::class,'history']);




Route::get('/jadwalronda', [PemilikController::class, 'jadwalronda']);
Route::resource('/pemilik',PemilikController::class);
Route::get('/pemilikdanger', [PemilikController::class, 'dangerpemilik']);
Route::get('/laporan', [PemilikController::class, 'laporan']);





Route::get('/kondisicuaca', [kondisicuaca::class, 'kondisicuaca']);
Route::get('/monitoring', [monitoring::class, 'monitoring']);





route::resource('pengajuanbarang', PengajuanBarangController::class);






