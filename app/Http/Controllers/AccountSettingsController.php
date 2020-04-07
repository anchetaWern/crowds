<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateUserContactInfo;
use App\Http\Requests\ValidateChangePassword;
use App\Http\Requests\ValidateUserService;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Order;
use App\Bid;
use App\ServiceType;
use App\UserService;

class AccountSettingsController extends Controller
{
    public function edit() {
    	$detail = Auth::user()->detail;
    	$settings = Auth::user()->setting;

        $service_types = ServiceType::orderBy('id', 'ASC')->get();
        $user_services = Auth::user()->enabledServices->pluck('service_type_id')->toArray();

    	return view('account', compact('detail', 'settings', 'service_types', 'user_services'));
    }


    public function updatePassword(ValidateChangePassword $request) {

    	Auth::user()->update([
    		'password' => Hash::make(request('password'))
    	]);

    	return back()
    		->with('alert', ['type' => 'success', 'text' => 'Updated password']);
    }


    public function updateContact(ValidateUserContactInfo $request) {
    	Auth::user()->detail->update([
    		'phone_number' => request('phone_number'),
    		'messenger_id' => request('messenger_id')
    	]);

    	return back()
    		->with('alert', ['type' => 'success', 'text' => 'Updated contact details']);
    }


    public function updateNotifications() {

    	Auth::user()->setting->update([
			'is_orders_notification_enabled' => request()->has('new_order'),
			'is_bid_notification_enabled' => request()->has('new_bid'),
			'is_bid_accepted_notification_enabled' => request()->has('bid_accepted'),
			'is_bid_cancelled_notification_enabled' => request()->has('bid_cancelled'),
    	]);

    	return back()
    		->with('alert', ['type' => 'success', 'text' => 'Updated notification settings']);
    }


    public function deleteAccount() {

        Auth::user()->notifications()->delete();
        Auth::user()->detail->delete();
        $order_ids = Auth::user()->orders->pluck('id')->toArray();
        $bid_ids = Auth::user()->bids->pluck('id')->toArray();

        Order::destroy($order_ids);
        Bid::destroy($bid_ids);

        Auth::user()->delete();

        return redirect('/login')
            ->with('alert', ['type' => 'success', 'text' => 'Your account was deleted.']);
    }


    public function updateServices(ValidateUserService $request) {

        // note: all this code is just a repeat from UserController completeSetupStepFour() method
        $selected_service_types = request('service_type');

        UserService::where('user_id', Auth::id())
            ->update([
                'is_enabled' => false
            ]);

        if (request()->has('service_type')) {
            foreach ($selected_service_types as $service_type_id) {

                // note: there might be a less fishy way of doing this
                UserService::where('user_id', Auth::id())
                    ->where('service_type_id', $service_type_id)
                    ->update([
                        'is_enabled' => true
                    ]);

            }
        }

        return back()
            ->with('alert', ['type' => 'success', 'text' => 'Services was updated.']);
    }
}
