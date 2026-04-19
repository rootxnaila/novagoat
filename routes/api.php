    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\KambingController;
    use App\Http\Controllers\DashboardController;

    Route::get('/kambing', [KambingController::class, 'index']); //GET /api/kambing 
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']); //GET /api/dashboard/stats
    Route::get('/kambing/{id}', [KambingController::class, 'show']); //GET /api/kambing/{id}
    Route::post('/kambing', [KambingController::class, 'store']); //POST /api/kambing
    Route::get('/grafik-berat/{id}', [KambingController::class, 'grafikBerat']); 
    Route::get('/ping', function() {
        return response()->json(['status' => 'success', 'message' => 'Pong! Server Kambing Pak Tarno siap melayani!',
        'waktu_Sekarang' => now()
        ]);
    });