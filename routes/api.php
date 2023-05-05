<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/webhook_order_created', function () {
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);
    Log::debug('Webhook ORDER CREATE received:');
    Log::debug($request_body);
    return response()->json([
        'success' => '1',
        'message' => '',
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
