<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateUserAddress;
use App\Http\Requests\ValidateFacebookAccount;
use App\Http\Requests\ValidateUserContactInfo;
use App\Http\Requests\ValidateUserService;
use Auth;
use App\User;
use App\Order;
use App\Bid;
use App\UserService;
use App\Services\SocialLoginServiceInterface;

class UserController extends Controller
{
    public function completeSetupStepOne(ValidateFacebookAccount $request, SocialLoginServiceInterface $facebook) {
        
        $profile_data = $facebook->getUserData();
        
        if ($profile_data) {

            $facebook_user_exists = User::where('facebook_id', $profile_data['id'])->count();

            if ($facebook_user_exists) {
                return back()->with('alert', ['type' => 'danger', 'text' => "Someone has already connected that Facebook account previously."]);
            }

            Auth::user()->update([
                'facebook_id' => $profile_data['id'],
                'photo' => $profile_data['data']['url'],
                'setup_step' => 1
            ]);

            return back();
        }

        return back()->with('alert', ['type' => 'danger', 'text' => "Sorry. We cannot find the Facebook account you're trying to connect."]);
    }


    public function completeSetupStepTwo(ValidateUserAddress $request) {

        Auth::user()->update([
            'barangay_id' => request('barangay'),
            'setup_step' => 2
        ]);

        return back();
    }


    public function completeSetupStepThree(ValidateUserContactInfo $request) {

        Auth::user()->detail->update([
            'phone_number' => request('phone_number'), 
            'messenger_id' => request('messenger_id')
        ]);

        Auth::user()->update([
            'setup_step' => 3 
        ]);

        return back();
    }


    public function completeSetupStepFour(ValidateUserService $request) {

        $selected_service_types = request('service_type');

        // note: kinda fishy
        UserService::where('user_id', Auth::id())
            ->update([
                'is_enabled' => false
            ]);

        foreach ($selected_service_types as $service_type_id) {

            // note: there might be a less fishy way of doing this
            UserService::where('user_id', Auth::id())
                ->where('service_type_id', $service_type_id)
                ->update([
                    'is_enabled' => true
                ]);

        }

        $setup_step = request()->has('_is_ios') && request('_is_ios') == 'yes' ? 5 : 4;
        if ($setup_step == 5) {
            return back()->with('alert', ['type' => 'success', 'text' => "Setup complete! You can now make requests and submit bids."]);
        }

        Auth::user()->update([
            'setup_step' => $setup_step // note: if device is iOS, skip directly to step 4 because there's no web notifications in iOS devices 
        ]);

        return back();
    }


    public function completeSetupStepFive() {
        
        Auth::user()->update([
            'fcm_token' => request('_fcm_token'),
            'setup_step' => 5,
        ]);

        return back()->with('alert', ['type' => 'success', 'text' => "Setup complete! You can now make requests and submit bids."]);
    }


    public function previousSetupStep() {
        if (Auth::user()->setup_step >= 1) {
            Auth::user()->decrement('setup_step');
        }
        return back();
    }


    public function show(User $user) {
        return [
            'name' => $user->name,
            'phone_number' => $user->detail->phone_number,
            'messenger_id' => $user->detail->messenger_id
        ];
    }

}
