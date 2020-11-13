<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite; //⇦追記
use DB;
use App\Models\User;

class SocialAccountController extends Controller
{
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * 取得した連携SNSアカウントのmailがすでに登録されているユーザーのemailと同じなら、そのユーザーのSNSカラムに追記
     */
    public function handleProviderCallback($provider) {
        try {
          $providerUser = Socialite::driver($provider)->stateless()->user();
    
          $user = DB::table('users')->where('email', $providerUser->getEmail())->first();
    
          if( is_null($user) ){
    
            if( is_null($providerUser->getNickname()) ){
              $providerUserNickName = $providerUser->getName();
            }else{
              $providerUserNickName = $providerUser->getNickname();
            }
    
            $userd = User::create([
              'name' => $providerUserNickName,
              'email' => $providerUser->getEmail(),
            ]);
    
          }else{
            $userd = User::find( $user->id );
          }
    
          switch ($provider) {
            case "google":
              if( is_null($userd->google_id) ){
                $userd->google_id = $providerUser->getId();
                if( is_null($providerUser->getNickname()) ){
                  $userd->google_name = $providerUser->getName();
                }else{
                  $userd->google_name =$providerUser->getNickname();
                }
              }
              break;
            case "twitter":
              if( is_null($userd->twitter_id) ){
                $userd->twitter_id = $providerUser->getId();
                if( is_null($providerUser->getNickname()) ){
                  $userd->twitter_name = $providerUser->getName();
                }else{
                  $userd->twitter_name = $providerUser->getNickname();
                }
              }
              break;
          }
          $userd->save();
    
          auth()->login($userd, true);
          return redirect()->to('/home');
    
        } catch (\Exception $e) {
          return redirect("/");
        }
    
      }
}
