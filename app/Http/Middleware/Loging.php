<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class Loging
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, Response $response)
    {
        if ($request->getMethod() != 'OPTIONS') {
            $url = $request->fullUrl();
            $ip = $request->ip();
            $method = $request->getMethod();
            $statusCode = $response->getStatusCode();

            $r = new Log();
            $r->ip = $ip;
            $r->url = $url;
            $r->method = $method;
            $r->status_code = $statusCode;
            $r->request = json_encode($request->all());
            $r->response = json_encode($response);
            $r->save();
        }
    }
}
