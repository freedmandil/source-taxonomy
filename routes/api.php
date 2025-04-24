<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SeferController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\SubTopicController;
use App\Http\Controllers\Api\KeywordController;
use App\Http\Controllers\Api\ReferenceController;

    Route::apiResource('sefarim', SeferController::class);
    Route::apiResource('publishers', PublisherController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('topics', TopicController::class);
    Route::apiResource('subtopics', SubTopicController::class);
    Route::apiResource('keywords', KeywordController::class);
    Route::apiResource('references', ReferenceController::class);
