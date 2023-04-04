<?php

namespace App\Http\Controllers\Api\EMR\Hims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Drug;

class DrugController extends Controller
{
    public function index()
    {

    }
   
    public function search()
    {
        if ($search = \Request::get('q')){
            $drugs = Drug::select('id', 'name')->orderBy('name', 'ASC')->where('name', 'LIKE', "%$search%")->limit(10)->get();
        }
        else{
            $drugs = Drug::select('id', 'name')->orderBy('name', 'ASC')->limit(10)->get();
        }
        
        return response()->json(['drugs' => $drugs,]);
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
