<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    //--index
    public function index(Request $request)
    {
        $sales = Sale::latest()->get();
        return response()->json($sales);
    }
    //--store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customerName' => 'required',
            'customerPhone' => 'required',
            'customerAddress' => 'required',
            'Product_id' => 'required',
            'ProductSalePrice' => 'required',
            'SaleQunatity' => 'required',
            'InvoiceNumber' => 'required',
            'InvoiceDate' => 'required',
            'InvoiceTotal' => 'required',
            'InvoicePaid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        } else {

            $product  = Product::find($request->Product_id);
            if ($product && $product->stock_quantity >= $request->SaleQunatity) {
                $sale = new Sale();
                $sale->customerName = $request->customerName;
                $sale->customerPhone = $request->customerPhone;
                $sale->customerCompany = $request->customerCompany;
                $sale->customerAddress = $request->customerAddress;
                $sale->product_id = $request->Product_id;
                $sale->ProductSalePrice = $request->ProductSalePrice;
                $sale->SaleQunatity = $request->SaleQunatity;
                $sale->InvoiceNumber = $request->InvoiceNumber;
                $sale->InvoiceDate = $request->InvoiceDate;
                $sale->InvoiceTotal = $request->InvoiceTotal;
                $sale->InvoicePaid = $request->InvoicePaid;
                $sale->InvoiceDue = $request->InvoiceDue;

                if ($sale->save()) {
                    //-- decrement product quantity ---
                    $product->decrement('stock_quantity', $request->SaleQunatity);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Sale Created Successfully',
                        'product' => $product,
                    ]);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Failed to Create Sale'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Insufficient stock. Please adjust the quantity.'
                ]);
            }
        }
    }
}
