<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\TypeOfCategory;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function createCategory(Request $request){
        $validator = $this->categoryValidation($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
               }
        $data = $this->categoryData($request);
        $imageName = uniqid().'-'.$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/image',$imageName);
        $data['image'] = $imageName;
        Category::create($data);
        $typeData = TypeOfCategory::get();
        $categoryData = Category::get()->toArray();
        return view('admin.category',compact('typeData','categoryData'));
    }

    public function categoryList(){
        $typeData = TypeOfCategory::get();
        $categoryData = Category::get()->toArray();
        return view('admin.category',compact('categoryData','typeData'));
    }

    private function categoryData($request){
        return[
            'type'=> $request->type,
            'category'=>$request->categoryName,
            'image' => $request->image
        ];
    }

    private function categoryValidation($request){
       $validator = Validator::make($request->all(), [
            'type' => 'required',
            'image' => 'required',
            'categoryName' => 'required'
          ]);
    return $validator;
    }
}
