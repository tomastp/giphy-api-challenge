<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Src\Shared\Infrastructure\LaravelLogguer;

class LoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $log = [
            'service' => $request->getPathInfo(),
            'http_status_code' => $response->getStatusCode(),
            'response_body' =>  $response->getContent(),
            'method' => $request->getMethod(),
            'ip' => $request->ip(),
        ];
        
        $request_body = [];
        if (count($request->all()) > 0) {
           $hiddenKeys = ['password'];
           $request_body = $request->except($hiddenKeys);
       }

        if ($request->user()) {
            $log['user'] = $request->user()->id;
        }

        $log['request_body'] = (count($request_body) > 0) ? json_encode($request_body) : json_encode('{}');
        
        LaravelLogguer::info('+ Incomming Request ', $log);

        return $response;
    }

}
