    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\KambingController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\AuthController;

    Route::get('/kambing', [KambingController::class, 'index']); //GET /api/kambing 
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']); //GET /api/dashboard/stats
    Route::get('/kambing/{id}', [KambingController::class, 'show']); //GET /api/kambing/{id}
    Route::post('/kambing', [KambingController::class, 'store']); //POST /api/kambing
    Route::get('/grafik-berat/{id}', [KambingController::class, 'grafikBerat']); 
    Route::post('/register', [AuthController::class, 'register']); //sign up
    Route::post('/login', [AuthController::class, 'login']); //sign in    
    
    Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});