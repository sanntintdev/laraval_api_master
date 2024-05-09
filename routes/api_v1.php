<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\AuthorTicketsController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthController;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// universal resource locater

Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource("tickets", TicketController::class)->except(["update"]);
    Route::put("tickets/{ticket}", [TicketController::class, "replace"])->name(
        "tickets.replace"
    );
    Route::patch("tickets/{ticket}", [TicketController::class, "update"])->name(
        "tickets.update"
    );

    Route::apiResource("authors", AuthorController::class)->except([
        "store",
        "update",
        "delete",
    ]);

    Route::apiResource(
        "authors.tickets",
        AuthorTicketsController::class
    )->except(["update"]);

    Route::put("authors/{author}/tickets/{ticket}", [
        AuthorTicketsController::class,
        "replace",
    ])->name("authors.tickets.replace");

    Route::patch("authors/{author}/tickets/{ticket}", [
        AuthorTicketsController::class,
        "update",
    ])->name("authors.tickets.update");

    Route::apiResource("users", UserController::class)->except(["update"]);
    Route::put("users/{user}", [UserController::class, "replace"]);
    Route::patch("users/{user}", [UserController::class, "update"]);

    Route::get("/user", function (Request $request) {
        return $request->user();
    })->middleware("auth:sanctum");
});
