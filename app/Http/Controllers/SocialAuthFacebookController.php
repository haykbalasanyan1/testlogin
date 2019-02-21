<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Edbizarro\LaravelFacebookAds\FacebookAds;
//use Laravel\Socialite\Facades\Socialite;
Use Edbizarro\LaravelFacebookAds\Facades\FacebookAds;
use Illuminate\Support\Facades\Auth;
use Socialite;

class SocialAuthFacebookController extends Controller
{
    /**
     * Create a redirect method to facebook api.
     *
     * @return void
     */
    public function redirect()
    {
        return Socialite::driver('facebook')->scopes(['ads_management'])->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(Request $request)
    {

        $user = Socialite::driver('facebook')->user();
//        ->scopes(['ads_management','email'])
         session(['token' => $user->token]);


        
        return redirect()->route('ads');
    }

    public function ads(){
        FacebookAds::init(session('token'));

        $ads = FacebookAds::adAccounts()->all()->map(function ($adAccount) {

            return $adAccount->ads(
                [
                    'name',
                    'account_id',
                    'account_status',
                    'status',
                    'email'
                ]
            );
        });
            return view('home', compact('ads'));

    }


}
