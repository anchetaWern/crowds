<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateOrder;
use App\Order;
use App\ServiceType;
use Auth;

class BarangayOrdersController extends Controller
{
    public function index() {
    	
    	$user_type = Auth::user()->user_type;
        $selectedStatus = request()->has('status') ? request('status') : 'posted';
        
    	$orders = null;
    	if ($user_type == 'user') {
    		$orders = Order::where('user_id', Auth::id())
    			->barangay()
    			->latest()
            	->paginate(10);
    	} else if ($user_type == 'officer') {
    		$orders = Order::with(['user', 'user.detail'])
	    		->$selectedStatus()
	    		->barangay()
	            ->sameBarangay()
	    		->latest()
	    		->paginate(10);
    	}

        $service_types = ServiceType::orderBy('id', 'ASC')->get();
        $service_types_arr = $service_types->pluck('name', 'id')->toArray();
        $order_status = [
            'posted', 
            'fulfilled',
            'expired'
        ];

    	return view('barangay-orders', compact('selectedStatus', 'orders', 'service_types', 'service_types_arr', 'order_status'));
    }


    public function create(ValidateOrder $request) {

    	Order::create(array_merge($request->formatted(), [
            'user_id' => Auth::id(),
            'barangay_id' => Auth::user()->barangay_id,
            'is_barangay_only' => true,
            'status' => 'posted'
        ]));

        // note: no notifications here because there might be a lot
    	return back()
            ->with('alert', ['type' => 'success', 'text' => "Request Created! <br/>Please wait for a barangay official to fulfill your request."]);
    }


    public function fulfill() {

        $order_id = request('_order_id');
        Order::find($order_id)->fulfill();

        return back()
            ->with('alert', ['type' => 'success', 'text' => "Request marked as <strong>fulfilled</strong>"]);
    }
}
