<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;
/**
 * @OA\Security(
 *     security={
 *         "BearerAuth": {}
 *     },
 */


/**
 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 */


/**
 * @OA\Info(
 *     title="Your API Title",
 *     description="Your API Description",
 *     version="1.0.0"
 */


/**
 * @OA\Consumes({
 *     "application/json"
 * })
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
