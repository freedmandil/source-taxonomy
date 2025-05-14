<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SeferController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\SubTopicController;
use App\Http\Controllers\Api\KeywordController;
use App\Http\Controllers\Api\ReferenceController;
use App\Http\Controllers\Api\TaxonomyController;

    Route::apiResource('sefarim', SeferController::class);
    Route::apiResource('publishers', PublisherController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('topics', TopicController::class);
    Route::apiResource('subtopics', SubTopicController::class);
    Route::apiResource('keywords', KeywordController::class);
    Route::apiResource('references', ReferenceController::class);
    Route::apiResource('taxonomy', TaxonomyController::class);

    Route::any('taxonomy-action/{method}', function ($method, Request $request) {
        $controller = app(\App\Http\Controllers\Api\TaxonomyController::class);
        if (method_exists($controller, $method)) {
            return app()->call([$controller, $method]);
        }
        abort(404, "Method [$method] not found.");
    });

    Route::any('references-action/{method}', function ($method, Request $request) {
        $controller = app(\App\Http\Controllers\Api\ReferenceController::class);
        if (method_exists($controller, $method)) {
            return app()->call([$controller, $method]);
        }
        abort(404, "Method [$method] not found.");
    });

Route::any('tag-action/{method}', function ($method, Request $request) {
    $controller = app(\App\Http\Controllers\Api\TagController::class);
    if (method_exists($controller, $method)) {
        return app()->call([$controller, $method]);
    }
    abort(404, "Method [$method] not found.");
});



