<?php

namespace App\Http\Controllers\Api\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EMR\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            'products'     => Product::select('id', 'name', 'unit_price', 'brand', 'category')->paginate(250),
        ]);
    }

    public function search()
    {
        if (is_null(\Request::get('q'))){
            $products   = Product::select('id', 'name', 'unit_price', 'brand', 'category')->paginate(250);    
        }
        else{
            $search = \Request::get('q');
            $products   = Product::select('id', 'name', 'unit_price', 'brand', 'category')->where('name', 'LIKE', '%'.$search.'%')->paginate(250);
        }
        
        return response()->json([
            'products'     => $products,
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
