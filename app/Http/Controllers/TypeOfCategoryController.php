<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\TypeOfCategory;
use Illuminate\Support\Facades\Validator;

class TypeOfCategoryController extends Controller
{
    public function dashboard() {
        $typeData = TypeOfCategory::get();
        $categoryData = Category::get()->toArray();
        return view('admin.category',compact('typeData','categoryData'));
    }
    public function createType(Request $request){
        $validator = $this->typeValidate($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
               }
        $dataType = $this->getType($request);
        $imageName = uniqid().'-'.$request->file('image_one')->getClientOriginalName();
        $request->file('image_one')->storeAs('public/image',$imageName);
       $dataType['image'] = $imageName;
        TypeOfCategory::create($dataType);
        $typeData = TypeOfCategory::get();
        $categoryData = Category::get()->toArray();
        return view('admin.category',compact('typeData','categoryData'));

    }
    private function typeValidate($request){
      $validator = Validator::make($request->all(), [
        'image_one' => 'required',
          'types' => 'required',
        ]);
           return $validator;
    }
    private function getType($request){
        return[
            'image' => $request->image_one,
            'type' => $request->types,
        ];
    }


}
