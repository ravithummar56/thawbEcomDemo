<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserSession;

class AuthDeviceApi
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
        $session = UserSession::where('session_id',$request['session_id'])->first();

        if($session == null){
            return response()->json(['status'=> '0', 'message' => 'Device not Find.']);
        }
        
        return $next($request);
    }
}
