<?php

namespace App\Http\Controllers\Api\EMR\Hims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Visitation;

class VisitationController extends Controller
{
    public function index()
    {
        $date = date('Y-m-d');

        $visitations = Visitation::where('date', '=', $date)->paginate(50);

        return response()->json([
            'visitations' => $visitations,
        ]);
    }

    public function outpatient()
    {
        $date = date('Y-m-d');

        $visitations = Visitation::where('date', '=', $date)->paginate(50);

        return response()->json([
            'visitations' => $visitations,
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
