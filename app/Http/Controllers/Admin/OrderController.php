<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Base\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\ProductImage;
use File;
use DB;
use General;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class OrderController extends AdminController
{	

	public function orderCount()
	{
		$cnt['allcnt'] = $this->Order->count();
		$cnt['processingCnt'] = $this->Order->where('order_status_id',1)->count();
		$cnt['comCnt'] = $this->Order->where('order_status_id',2)->count();
		$cnt['readytodiscnt'] = $this->Order->where('order_status_id',3)->count();
		$cnt['discnt'] = $this->Order->where('order_status_id',4)->count();
		$cnt['dilvcnt'] = $this->Order->where('order_status_id',5)->count();
		$cnt['cancnt'] = $this->Order->where('order_status_id',6)->count();	
		return $cnt;
	}	
	/**
	 *  get the order details and display it.
	 *  and search the order.
	 */
    public function index(Request $request)
	{
		try
		{
			$payment_status = $this->PaymentStatus->pluck('status_value','id');
			$order_status = $this->OrderStatus->pluck('status_value','id');
			if($request->ajax())
			{
			$lists = $this->Order->orderBy('id','desc');
			     
				if(request('start') && request('end'))
                {  
                    $start = date('Y-m-d', strtotime(request('start')));
                    
                    $end = date('Y-m-d', strtotime(request('end')));
                   
                    $lists = $lists->whereBetween('orderDate', array($start,$end));
                }  

                if(request('payment_type'))
                {
                    $lists = $lists->where('payments_type',request('payment_type'));
                }

                if(request('order_status'))
                {
                    $lists = $lists->where('order_status_id',request('order_status'));
                }

                  if(request('payment_status'))
                {
                    $lists = $lists->where('payments_status_id',request('payment_status'));
                }

				if(request('searchtext'))
				{ 
					$search = $request->searchtext;
                    

					$lists->where(function($query) use ($search)
		             {
		                  $query->orWhere('order_name', 'like', '%' . request('searchtext') . '%')
										->orWhere('order_id', 'like', '%' . request('searchtext') . '%')
										->orWhere('total', 'like', '%' . request('searchtext') . '%')
										->orWhere('invoice_number', 'like', '%' . request('searchtext') . '%')
										->orWhere('payments_type', 'like', '%' . request('searchtext') . '%'); 
		             });
				}

				$lists = $lists->paginate(10);
                 return response()->json(
                   View::make('admin.order.data',compact('lists','payment_status'))
                   ->render()
               );
				
			}
			
			$cnt = $this->orderCount();
			
			$allcnt = $cnt['allcnt'];
			$processingCnt = $cnt['processingCnt'];
			$comCnt =$cnt['comCnt'];
			$readytodiscnt = $cnt['readytodiscnt'];
			$discnt = $cnt['discnt'];
			$dilvcnt = $cnt['dilvcnt'];
			$cancnt = $cnt['cancnt'];

			
			return view('admin.order.index',compact('lists','payment_status','order_status','allcnt','processingCnt','comCnt','readytodiscnt','discnt','dilvcnt','cancnt'));
		}
		catch (\Exception $e) {
			return $this->debugLog($e->getMessage());
		}
	}

	/**
	 * edit order.
	 */
	public function edit()
	{
        return view('admin.order.edit',compact('lists'));
	}
	
	
	/**
	 * udpate the payment status.
	 */
	public function changeOrderStatus(Order $order, Request $request)
	{

		try
		{
			$data = request()->all();
				
			 
			if(isset($data['id']))
			{
				if($data['value'] == 5) {
					for ($i=0; $i<count($request->id); $i++)
					{
						$this->Order->where('id',$request->id[$i])->update(['order_status_id' => $data['value'],'delivered_date'=>date('Y-m-d')]);
					}
				}else{
					for ($i=0; $i<count($request->id); $i++)
					{
						$this->Order->where('id',$request->id[$i])->update(['order_status_id' => $data['value']]);
					}
				}
				

				$message = $this->success($this->updated,'Oder');
				$cnt = $this->orderCount();
				return response()->json(['orderStatus' => $status ,'pId'=> $request->id,'cnt' => $cnt ,'message' => $message]);
			}
			
		}
		catch (\Exception $e) {
			dd($e);
			return $this->debugLog($e->getMessage());
		}
	}

	/**
	 * udpate the payment status.
	 */
	public function changePaymentStatus(Order $order, Request $request)
	{
        
		try
		{
			$data = request()->all();
			
			if(isset($data['id']))
			{
				for ($i=0; $i<count($request->id); $i++)
				{
					$this->Order->where('id',$request->id[$i])->update(['payments_status_id' => $data['value']]);
				}
				$message = $this->success($this->updated,'Oder');
				return ['paymentStatus' => $status ,'pId'=> $request->id ,'message' => $message];
			}
			return;
		}
		catch (\Exception $e) {
			return $this->debugLog($e->getMessage());
		}
	}

	public function show($id)
    {
        try
        {
            $myOrder = $this->Order->with('billAddress','paymentStatus','orderStatus','shipaddress')->where('order_id',$id)->first();
   	 		foreach ($myOrder->orderItems as $order) {
   	 				if($order->product_type == 'custome_product'){
   	 					$image_Path = Url('public/default/default_user.png');
   	 				}else{
   	 					$image_Path = ProductImage::where('product_id',$order->product_id)->first();
   	 					$image_Path = $image_Path->image != null ? Url("/public".config('admin.image.product').$image_Path->product_id.'/'.$image_Path->image) : Url('public/default/default_user.png');
   	 				}
   	 				$order->item_image_path = $image_Path;
                    $order->fabricDetails;
                    $order->colorDetails;
                    $order->kandoraStyleDetails;
                    $order->productDetails;
                    $order->sizeDetails;
   	 			if($order->product_type == 'custome_product'){
                    $order->collarStyleDetails;
                    $order->fabricTypeDetails;
                }
   	 			
   	 		}
            return view('admin.order.view',compact('myOrder'));
        }
        catch (\Exception $e) 
        {
           dd($e);
            return $this->debugLog($e->getMessage());
        }
    }

    public function changeDeliveryDate()
    {
    	try {
    		$data = request()->all();
    		$order = $this->Order->where('id',$data['order_id'])->update(['delivered_date'=>$data['date']]);
    		dd($order);
    		return 'true';
    	} catch (Exception $e) {
    		return $this->debugLog($e->getMessage());
    	}
    }

}
