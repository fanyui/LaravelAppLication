<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class AnalyseRequest
{
    /**
     * Check the incoming request for the presence of notif and redirect for deletion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      
        if ($request->has("notif")) {
            return redirect("notification/delete/".$request->input("notif"));
        }
        //continue processing the request
        return $next($request);
        
    }
}
