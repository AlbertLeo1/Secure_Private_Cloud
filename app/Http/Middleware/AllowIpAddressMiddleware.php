<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Inventory\Device;

class AllowIpAddressMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $mac_addresses = Device::select('mac_address')->where('status', '=', 'Active')->pluck('mac_address')->toArray();
        //print_r($mac_addresses);

        $mac_address = ['192.168.0.1', '202.173.125.72', '192.168.0.3', '202.173.125.71'];
        //print_r($mac_address);

        //echo ($request->getClientIp());
        if (!in_array($request->getClientIp(), $mac_addresses)){
            abort(403, "You are restricted to access the site.");
        }

        return $next($request);
    }
}
