<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 22:34.
 */

namespace Foundation\Abstracts\Middleware;

use Closure;
use Illuminate\Http\Request;

abstract class Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    abstract public function handle(Request $request, Closure $next);
}
