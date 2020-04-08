<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateOrder;
use App\Order;
use App\User;
use App\ServiceType;
use Auth;
use App\Notifications\OrderCreated;
use Illuminate\Support\Facades\Notification;

class OrdersController extends Controller
{
    public function create(ValidateOrder $request) {

        Order::create(array_merge($request->formatted(), [
            'user_id' => Auth::id(),
            'barangay_id' => Auth::user()->barangay_id,
            'status' => 'posted'
        ]));

        // note: might be better making it as a listener? 
        $users = User::whereHas('setting', function($q) {
            $q->where('is_orders_notification_enabled', true);
        })->whereHas('enabledServices', function($q) {
            $q->where('service_type_id', request('service_type'));
        })
            ->where('id', '!=', Auth::id())
            ->where('barangay_id', Auth::user()->barangay_id)
            ->get();

        Notification::send($users, new OrderCreated);

        return back()
            ->with('alert', ['type' => 'success', 'text' => "Request Created! <br/>Please wait for someone in your neighborhood to submit a bid."]);
    }


    public function index() {
        
        $orders = Order::where('user_id', Auth::id())
            ->with(['bidsAcceptedFirst', 'bids.user'])
            ->general()
            ->latest()
            ->paginate(10);

        $service_types_arr = ServiceType::orderBy('id', 'ASC')->pluck('name', 'id')->toArray();
        
        if (!session()->has('alert')) {
            session()->now('alert', ['type' => 'info', 'text' => "Once you've accepted a bid, click on the contact button and contact the person first to make sure they're legit. Click the no show button if you can't reach them."]);
        }

        $page = 'orders';
        return view('orders', compact('orders', 'service_types_arr', 'page'));
    }
}
