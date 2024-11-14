<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    //--index
    public function index(Request $request)
    {
        $sales = Sale::all();
        return response()->json($sales);
    }
    //--store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            ''
        ]);
        return response()->json('ddd');
    }
}
