<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Inventory\Device;

class AllowMacAddressMiddleware
{
    //public 
    //public $mac_address = ['192.168.0.1', '202.173.125.72', '192.168.0.3', '202.173.125.71','127.0.0.1'];

    public function handle(Request $request, Closure $next)
    {
        $mac_addresses = Device::select('mac_address')->where('status', '=', 'Active')->get();
        if (!in_array($request->getClientIp(), $this->mac_address)){
            abort(403, "You are restricted to access the site.");
        }
        return $next($request);
    }
}
