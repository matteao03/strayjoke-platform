<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Order;

class OrdersController extends Controller
{
    public function store(Request $request){
        $user = Auth::user();
        //开启一个数据库事务
        $order = \DB::transaction(function()use ($user, $request){
            //创建一个订单
            $order = new Order([
                'address'=>'',
                //'remark'=> $request->comment,
                'total_amount'=>0
            ]);
            //订单关联到当前用户
            $order->user()->associate($user);
            //写入数据库
            $order->save();
            
            $totalAmount = 0;
            //创建一个order_item 
            $item = $order->items()->make([
                'price'=>$request->money,
                'amount'=>1,
                'product_id'=>$request->articleId,
                'obj_table'=>'articles',
            ]);
            $item->save();
            $totalAmount = $request->money * 1;
            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);
            return $order;
        });
        return ['code'=> 1, 'data'=> $order];
    }
}
