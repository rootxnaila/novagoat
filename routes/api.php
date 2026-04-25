    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\KambingController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\LogBeratController;
    use App\Http\Controllers\JadwalMedisController;

    //public routes
    
    Route::post('/register', [AuthController::class, 'register']); 
    Route::post('/login', [AuthController::class, 'login']);       

    Route::get('/kambing', [KambingController::class, 'index']);
    Route::get('/kambing/{id}', [KambingController::class, 'show']);
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/grafik-berat/{id}', [KambingController::class, 'grafikBerat']);


    // protected routes (butuh token)
    Route::middleware('auth:sanctum')->group(function () {
    Route::put('/jadwal-medis/{id}', [JadwalMedisController::class, 'update']);
    Route::delete('/jadwal-medis/{id}', [JadwalMedisController::class, 'destroy']);

    //admin n anak kandang
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/kambing/{id}/timbang', [LogBeratController::class, 'store']); //daily timbang
    Route::get('/jadwal-medis', [JadwalMedisController::class, 'index']);    
    Route::post('/jadwal-medis', [JadwalMedisController::class, 'store']); 
    Route::patch('/jadwal-medis/{id}', [JadwalMedisController::class, 'updateStatus']); 
    

    //admin-only routes
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        Route::post('/kambing', [KambingController::class, 'store']);//tambah wedus
        Route::put('/kambing/{id}', [KambingController::class, 'update']);// edit data wedus
        Route::delete('/kambing/{id}', [KambingController::class, 'destroy']);// hapus wedus
        
    });
});