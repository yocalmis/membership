<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helper\ControlHelper;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{

    public function index(Request $request)
    {
    // Get All
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
   // Validations and insert
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products',
            'price' => 'required',
            'category' => 'required',
        ]);
        if ($validator->fails()) {
            $res["status"] = "Validate Error";return response()->json($res);
        }

        $product = new Product();
        $product->name = ControlHelper::test_input($request->name);
        $product->price = ControlHelper::test_input($request->price);
        $product->category = ControlHelper::test_input($request->category);
        $product->save();
        return response()->json('Product add successfully.');
    }
    
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $res["status"] = "Validate Error";return response()->json($res);

        }

        $id = ControlHelper::test_input($request->id);
        $product = Product::find($id);
        return response()->json($product);
    }
    
    public function update(Request $request)
    {
   // Validations and update
        $id = ControlHelper::test_input($request->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name,' . $id,
            'price' => 'required',
            'category' => 'required',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $res["status"] = "Validate Error";return response()->json($res);
        }

        if(Product::where('id', '=', $id)->get()->count()==0)
        {return response()->json('Product update failed.');}

        $product = Product::find($id);
        $product->name = ControlHelper::test_input($request->name);
        $product->price = ControlHelper::test_input($request->price);
        $product->category = ControlHelper::test_input($request->category);
        $product->update();
        return response()->json('Product edit successfully.');
    }
    
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $res["status"] = "Validate Error";return response()->json($res);

        }

        $id = ControlHelper::test_input($request->id);
        if (Product::destroy($id) == 0) {return response()->json('Product delete failed.');}
        return response()->json('Product delete successfully.');

    }

}
