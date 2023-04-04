<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\CertificateType;

class CertificateTypeController extends Controller
{
    public function index()
    {
        $certificate_types = CertificateType::orderBy('name', 'ASC')
        //->with('sub_categories')
                            ->get();
        return response()->json(['certificate_types' => $certificate_types]);
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
