<?php

namespace Naif\NovaMysql\Http\Middleware;

use Naif\NovaMysql\NovaMysql;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaMysql::class)->authorize($request) ? $next($request) : abort(403);
    }
}
