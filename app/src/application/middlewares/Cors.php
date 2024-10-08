<?php

namespace toubeelib\application\middlewares;

use PhpParser\Node\Expr\New_;
use Slim\Exception\HttpUnauthorizedException;

class Cors
{

    public function __invoke($request, $response, $next)
    {
        if (! $request->hasHeader('Origin')) {
            New HttpUnauthorizedException($request, 'Origin header is required');
        }
        $response = $next->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', $request->getHeader('Origin'))
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET')
            ->withHeader('Access-Control-Allow-Headers', 'Authorization')
            ->withHeader('Access-Control-Max-Age', '3600')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }

}