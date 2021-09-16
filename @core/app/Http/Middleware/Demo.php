<?php

namespace App\Http\Middleware;

use Closure;

class Demo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->isMethod('POST') || $request->isMethod('PUT')) {
            return redirect()->back()->with(['type' => 'warning' , 'msg' => __('This is Demo version. You can not change anything.')]);
        }
        return $next($request);
    }
}
