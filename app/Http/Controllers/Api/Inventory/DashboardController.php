<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inventory\Device;

class DashboardController extends Controller
{
    public function index()
    {
        $previous_week = strtotime("-1 week +1 day");
        $old_begins = date("Y-m-d H:i:s", $previous_week);
        //echo $old_begins;
        return response()->json([
            'all_devices'       => Device::whereNotIn('status', ['Sold', 'Discontinued'])->count(),
            'new_devices'       => Device::whereDate('created_at', '>=', $old_begins)->count(),
            'damaged_devices'   => Device::where('status', '=', 'Damaged')->count(),
            'repaired_devices'  => Device::where('status', '=', 'Repaired')->count(),
            'sold_devices'      => Device::where('status', '=', 'Sold')->count(),
            'due_devices'       => Device::where('status', '=', 'Due' )->count(),
            //'all_devices' => Device::with('branch')->count(),  
        ]);
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
