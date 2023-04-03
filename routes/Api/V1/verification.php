<?php

use App\Http\Controllers\Api\V1\VerificationController;


Route::prefix('v1')->group(function(){
    //Route::apiResource('/verify', VerificationController::class);
    Route::post('/verify',  [VerificationController::class, 'store']);
});