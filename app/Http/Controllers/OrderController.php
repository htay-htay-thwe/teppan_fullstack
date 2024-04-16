<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(Request $request){
         $data = $this->getOrder($request);
         Order::create($data);
         $orderData = Order::get();
         return response()->json([
            'status' => 'success',
            'orderData' => $orderData,
          ]);
    }

    public function adminOrderLists(){
        $data = Order::select('orders.*','orders.name as order_name','orders.number as number','orders.status as orderStatus','categories.image as image')
                ->leftJoin('categories','categories.id','=','orders.menu_id')
                ->get()->toArray();
        return view('admin.orderLists',compact('data'));
    }

    public function orderStatus(Request $request){
        $data =  Order::where('menu_id',$request->menuId)->update(['status'=>$request->status]);
    return view('admin.orderLists',compact('data'));

    }
    private function getOrder($request){
        return[
            'number'=>$request->number,
            'menu_id'=> $request->menuId,
            'name' => $request->name,
            'status'=>$request->status
        ];
    }
}
