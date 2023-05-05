<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/webhook', function (Request $request) {

    $webhook_payload_cnt = file_get_contents('php://input');
    //Log::info('Webhook received:');
    //Log::info($webhook_payload_cnt);

    return response()->json([
        $request->all(),
    ]);
});

Route::post('/webhook_refund_create', function (Request $request) {

    $webhook_payload_cnt = file_get_contents('php://input');
    Log::info('Webhook REFUND CREATE received:');
    Log::info($webhook_payload_cnt);

    return response()->json([
        $request->all(),
    ]);
});

Route::post('/webhook_order_update', function (Request $request) {

    $webhook_payload_cnt = file_get_contents('php://input');
    Log::info('Webhook ORDER UPDATE received:');
    Log::info($webhook_payload_cnt);

    return response()->json([
        $request->all(),
    ]);
});
