<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Province;
use App\ServiceType;
use Auth;
use DB;

class OrdersFeedController extends Controller
{
    public function index() {
    	$orders = Order::with(['user', 'user.detail', 'postedBids'])
    		->posted()
    		->general()
            ->sameBarangay()
    		->createdWithinADay()
            ->hasLessThanFivePostedBids()
            ->sameServiceTypeAsUser()
    		->latest()
    		->paginate(10);

		$provinces = Province::orderBy('name', 'ASC')->get();
        $service_types = ServiceType::orderBy('id', 'ASC')->get();
        $service_types_arr = $service_types->pluck('name', 'id')->toArray();
        
        $user_services = Auth::user()->enabledServices->pluck('service_type_id')->toArray();
        
    	return view('orders_feed', compact('orders', 'provinces', 'service_types', 'service_types_arr', 'user_services'));
    }
}
