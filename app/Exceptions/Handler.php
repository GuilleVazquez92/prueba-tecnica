<?php

namespace App\Exceptions;

use Exception;

class Handler extends Exception {
    public function errorMessage() {
        // Mensaje de error
        return json_encode([
            'errors' => "some parameter is missing",
        ], 422);
    }
}