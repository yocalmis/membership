<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helper\ControlHelper;
use App\Models\Category;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{


    public function index(Request $request)
    {
    // Get All
         $categories = Category::all();
        return response()->json($categories);

    }

    public function store(Request $request)
    {
    // Validations and insert
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required|unique:categories',
            'parent' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            $res["status"] = "Validate Error";return response()->json($res);
        }

        $category = new Category();
        $category->cat_name = ControlHelper::test_input($request->cat_name);
        $category->parent = ControlHelper::test_input($request->parent);
        $category->status = ControlHelper::test_input($request->status);
        $category->save();
        return response()->json('Category add successfully.');
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
        $category = Category::find($id);
        return response()->json($category);
    }
    
    public function update(Request $request)
    {
    // Validations and update
        $id = ControlHelper::test_input($request->id);
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required|unique:categories,cat_name,' . $id,
            'parent' => 'required',
            'status' => 'required',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            $res["status"] = "Validate Error";return response()->json($res);

        }

        if(Category::where('id', '=', $id)->get()->count()==0)
        {return response()->json('Category update failed.');}
        $category = Category::find($id);
        $category->cat_name = ControlHelper::test_input($request->cat_name);
        $category->parent = ControlHelper::test_input($request->parent);
        $category->status = ControlHelper::test_input($request->status);
        $category->update();
        return response()->json('Category edit successfully.');
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
        if (Category::destroy($id) == 0) {return response()->json('Category delete failed.');}
        return response()->json('Category delete successfully.');
    }

}
