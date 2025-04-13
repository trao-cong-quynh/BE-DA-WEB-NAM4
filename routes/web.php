<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/docs/api-docs.json', function () {
    // Trả về tài liệu API ở đây, có thể là một file JSON
    Route::get('/docs/api-docs.json', function () {
        // Đảm bảo rằng tài liệu Swagger đã được tạo và có sẵn
        $swaggerDocs = json_decode(file_get_contents(storage_path('api-docs/api-docs.json')), true);

        return response()->json($swaggerDocs);
    });
});
