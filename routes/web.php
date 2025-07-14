<?php
use App\Http\Controllers\PersediaanBarangController;
use App\Http\Controllers\PengajuanBarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_DangerZ;
use App\Http\Controllers\userss;

use App\Http\Controllers\dataController;

use App\Http\Controllers\Inputdatper;
use App\Http\Controllers\kondisicuaca;
use App\Http\Controllers\KondisiTanah;
use App\Http\Controllers\monitoring;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\Monitoringcuaca;
use App\Http\Controllers\Monitoringhama;
use App\Http\Controllers\PengajuanHamaController;
use App\Http\Controllers\HamaController;
use App\Http\Controllers\PemilikDangerController;

Route::middleware(['guest'])->group(function(){
    Route::get('/', [SesiController::class, 'index']);
    Route::get('/login', [SesiController::class, 'loginPage']);
    Route::post('/login', [SesiController::class, 'login'])->name('login');
    Route::get('/register', [SesiController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [SesiController::class, 'register']);
});

Route::middleware(['auth'])->group(function(){
    Route::post('/logout', [SesiController::class, 'logout'])->name('logout');
    Route::get('/home',[HomeController::class, 'index']);
    Route::resource('data', dataController::class );
    
    Route::get('/kondisicuaca', [Kondisicuaca::class, 'kondisicuaca'])->name('kondisicuaca.index');
Route::post('/weather/store', [Kondisicuaca::class, 'store'])->name('weather.store');
Route::get('/weather/data', [Kondisicuaca::class, 'getData'])->name('weather.data');
Route::get('/weather/available-dates', [Kondisicuaca::class, 'getAvailableDates'])->name('weather.dates');


    Route::get('/inputdata',[KondisiTanah::class,'index'] );
    Route::post('/data/store', [KondisiTanah::class, 'store'])->name('data.store');
    Route::get('/datapertanian', [KondisiTanah::class, 'show'])->name('data.show');
    Route::get('/datapertanian/{id}/edit', [KondisiTanah::class, 'edit'])->name('data.edit');
    Route::put('/datapertanian/{id}', [KondisiTanah::class, 'update'])->name('data.update');
    Route::delete('/datapertanian/{id}', [KondisiTanah::class, 'destroy'])->name('data.destroy');
    route::get('/hasilpertanian', [KondisiTanah::class, 'hasilPertanian'])->name('data.hasil');
    Route::post('/pengajuanbarang/{pengajuanBarang}/setujui', [PengajuanBarangController::class, 'setujui'])
        ->name('pengajuanbarang.setujui');
    
    Route::get('/inputdatapertanian',[Inputdatper::class,'index'] );
    Route::post('/data/store', [Inputdatper::class, 'store'])->name('data.store');
    Route::get('/datapertanian', [Inputdatper::class, 'show'])->name('data.show');
    Route::get('/datapertanian/{id}/edit', [Inputdatper::class, 'edit'])->name('data.edit');
    Route::put('/datapertanian/{id}', [Inputdatper::class, 'update'])->name('data.update');
    Route::delete('/datapertanian/{id}', [Inputdatper::class, 'destroy'])->name('data.destroy');
    route::get('/hasilpertanianpetani', [Inputdatper::class, 'hasilPertanian'])->name('data.hasil');
    Route::get('/persediaan/{id}/edit', [PengajuanBarangController::class, 'edit'])->name('pengajuanbarang.edit');
    Route::put('/persediaan/{id}', [PengajuanBarangController::class, 'update'])->name('pengajuanbarang.update');
    
    
    
    
    
    
    Route::get('/editdata',[userss::class,'index']);
    Route::get('/danger',[C_DangerZ::class,'index']);
    Route::get('/history',[C_DangerZ::class,'history']);
    
    
    
    
    Route::get('/jadwalronda', [PemilikController::class, 'jadwalronda']);
    Route::resource('/pemilik',PemilikController::class);
    Route::get('/pemilikdanger', [PemilikController::class, 'dangerpemilik']);
    Route::get('/pemilik-prediksi-hama', [PemilikController::class, 'prediksiHama'])->name('pemilik.prediksi.hama');
    Route::get('/laporan', [PemilikController::class, 'laporan']);
    
    
    
    
    
    Route::get('/kondisicuaca', [kondisicuaca::class, 'kondisicuaca']);
    Route::get('/monitoring', [monitoring::class, 'monitoring']);
    
    
    
    
    
    route::resource('pengajuanbarang', PengajuanBarangController::class);
    
    // Route untuk manajemen persediaan barang
    Route::get('/persediaan', [PengajuanBarangController::class, 'editPersediaan'])->name('persediaan.index');
    Route::post('/persediaan/store', [PengajuanBarangController::class, 'storePersediaan'])->name('persediaan.store');
    Route::put('/persediaan/{id}', [PengajuanBarangController::class, 'updatePersediaan'])->name('persediaan.update');
    
    
    Route::get('/monitoringhama', [App\Http\Controllers\Monitoringhama::class, 'index'])->name('monitoringhama.index');
    Route::post('/monitoringhama/save', [App\Http\Controllers\Monitoringhama::class, 'save'])->name('monitoringhama.save');
    Route::get('/monitoringhama/history', [App\Http\Controllers\Monitoringhama::class, 'history'])->name('monitoringhama.history');
    
    
    Route::get('/monitoringcuaca', [App\Http\Controllers\Monitoringcuaca::class, 'kondisicuaca'])->name('monitoringcuaca.index');
    
    Route::get('/manage-hama', [C_DangerZ::class, 'manageHama'])->name('manage.hama');
    Route::post('/store-hama', [C_DangerZ::class, 'storeHama'])->name('store.hama');
    Route::put('/update-hama/{id}', [C_DangerZ::class, 'updateHama'])->name('update.hama');
    Route::delete('/delete-hama/{id}', [C_DangerZ::class, 'deleteHama'])->name('delete.hama');
    Route::get('/get-hama-data/{id?}', [C_DangerZ::class, 'getHamaData'])->name('get.hama.data');
    
    // Tambahkan route resource untuk pengajuan hama
    Route::resource('pengajuanhama', PengajuanHamaController::class);
    
    Route::get('/get-persebaran-hama', [PengajuanHamaController::class, 'getPersebaranHama'])->name('get.persebaran.hama');
    
    Route::post('/weather/store', [kondisicuaca::class, 'store'])->name('weather.store');
    Route::get('/weather/data', [kondisicuaca::class, 'getData'])->name('weather.data');
    
    Route::get('/get-weather-data', [Kondisicuaca::class, 'getData']);
    
    Route::post('/save-weather-data', [C_DangerZ::class, 'saveWeatherData']);
    Route::get('/get-weather-data', [C_DangerZ::class, 'getWeatherData']);
    
    Route::get('/pemilik-danger', [PemilikDangerController::class, 'index'])->name('pemilik.danger');
    Route::get('/get-hama-data/{id?}', [PemilikDangerController::class, 'getHamaData']);
    Route::get('/get-persebaran-hama', [PemilikDangerController::class, 'getPersebaranHama']);
    Route::post('/save-weather-data', [PemilikDangerController::class, 'saveWeatherData']);
    Route::get('/get-weather-data', [PemilikDangerController::class, 'getWeatherData']);
    
    // Routes untuk Pemilik
    Route::prefix('pemilik')->name('pemilik.')->group(function () {
        // Routes untuk Pengajuan Hama
        Route::get('/pengajuan-hama/create', [App\Http\Controllers\Pemilik\PengajuanHamaController::class, 'create'])->name('pengajuanhama.create');
        Route::post('/pengajuan-hama', [App\Http\Controllers\Pemilik\PengajuanHamaController::class, 'store'])->name('pengajuanhama.store');
    });
});

