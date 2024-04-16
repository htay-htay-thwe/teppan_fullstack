<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\TypeOfCategory;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function menuGet(){
          $typeData = TypeOfCategory::get();
          return response()->json([
            'status' => 'success',
            'type' => $typeData,
          ]);
    }

    public function menuDetails(Request $request){
        $id = $request-> TypeId;
        $menuData = Category::where('type',$id)->get();
        return response()->json([
            'status' => 'success',
            'menuData' => $menuData,
          ]);
    }

    public function UserOrderStatus(){
        $orderStatus = Order::select('orders.*','orders.name as order_name','orders.number as number','orders.status as orderStatus','categories.image as image')
        ->leftJoin('categories','categories.id','=','orders.menu_id')
        ->get();
        logger($orderStatus);
        return response()->json([
            'status' => 'success',
            'acceptStatus' => $orderStatus,
          ]);
    }
}
