<?php

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


/**
 * @OA\POST(
 *     path="/api/update",
 *     summary="ModifierProfile",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="",
 *     summary="BloquerUser",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/listClients",
 *     summary="lister les clients",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\GET(
 *     path="/api/listJardinier",
 *     summary="lister les jardinier",
 *     description="",
 * @OA\Response(response="200", description="OK")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/refresh",
 *     summary="Refresh",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/logout",
 *     summary="Logout",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/register",
 *     summary="Register",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     tags={"User"},
 * )
 */


/**
 * @OA\POST(
 *     path="/api/login",
 *     summary="Login",
 *     description="",
 * @OA\Response(response="201", description="Created successfully")
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * )
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             example=
  * {
 *     "email": "khady@email.fr",
 *     "password": "1234567"
 * }
 *         )
 *     ),
 *     tags={"User"},
 * )
 */


