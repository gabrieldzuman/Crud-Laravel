<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base controller for the application.
 * Provides authorization, job dispatching, and validation utilities.
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Handle API responses in a consistent manner.
     *
     * @param mixed $data Data to be returned.
     * @param int $status HTTP status code.
     * @param string|null $message Optional response message.
     * @return \Illuminate\Http\JsonResponse JSON response.
     */
    protected function apiResponse(mixed $data, int $status = 200, ?string $message = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status,
        ], $status);
    }

    /**
     * Handle validation errors and return a formatted response.
     *
     * @param array $errors List of validation errors.
     * @return \Illuminate\Http\JsonResponse JSON response with errors.
     */
    protected function validationErrorResponse(array $errors): \Illuminate\Http\JsonResponse
    {
        return $this->apiResponse($errors, 422, 'Validation Error');
    }

    /**
     * Authorize an action with a custom exception handler.
     *
     * @param string $ability Ability to authorize.
     * @param mixed $arguments Arguments for the policy.
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeAction(string $ability, mixed $arguments = null): void
    {
        $this->authorize($ability, $arguments);
    }
}
