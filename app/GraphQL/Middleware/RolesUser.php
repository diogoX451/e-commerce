<?php

namespace App\GraphQL\Middleware;

use Closure;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Middleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class RolesUser extends Middleware
{
    public function handle($root, array $args, $context, ResolveInfo $info, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => 'Token is Expired']);
            } else {
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
    }
}
