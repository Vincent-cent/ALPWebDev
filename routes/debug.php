<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-dashboard', function () {
    try {
        $controller = new \App\Http\Controllers\Admin\BannerController();
        $request = \Illuminate\Http\Request::create('/admin/dashboard', 'GET');
        \Illuminate\Support\Facades\Auth::loginUsingId(1);
        return $controller->dashboard();
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace()
        ], 500);
    }
});
