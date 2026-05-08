    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\KambingController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\LogBeratController;
    use App\Http\Controllers\JadwalMedisController;

    //public routes
    Route::post('/login', [AuthController::class, 'login']);    

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/karyawan/kinerja', [App\Http\Controllers\AuthController::class, 'getKinerjaKaryawan'])->middleware('auth:sanctum');
        Route::delete('/karyawan/{id}', [Authgit add .Controller::class, 'hapusKaryawan']);   

    Route::get('/kambing', [KambingController::class, 'index']);
    Route::get('/kambing/{id}', [KambingController::class, 'show']);
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/grafik-berat/{id}', [KambingController::class, 'grafikBerat']);

    Route::post('/kambing', [KambingController::class, 'store']); 
    Route::put('/kambing/{id}', [KambingController::class, 'update']);

    Route::post('/kambing/{id}/timbang', [LogBeratController::class, 'store']);

    Route::get('/jadwal-medis', [JadwalMedisController::class, 'index']);    
    Route::post('/jadwal-medis', [JadwalMedisController::class, 'store']); 
    Route::put('/jadwal-medis/{id}', [JadwalMedisController::class, 'update']); //edit isi jadwal
    Route::patch('/jadwal-medis/{id}', [JadwalMedisController::class, 'updateStatus']); //centang selesai

    Route::middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        
        //bikin akun buat pegawai baru 
        Route::post('/register', [AuthController::class, 'register']); 
        
        //delete
        Route::delete('/kambing/{id}', [KambingController::class, 'destroy']); 
        Route::delete('/jadwal-medis/{id}', [JadwalMedisController::class, 'destroy']); 
        
    });
});