<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

// Models
use App\Invite;

class InviteVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $inviteCode     = $request->route('code');
        $section        = $request->route('section');
        $verify         = $request->session()->get('verify');

        if(!$inviteCode) {
            return redirect('invitation/error');
        }

        // Check if verified email is same as main guests email
        $isVerified = false;
        if($verify) {
            $invite = Invite::where('code', $inviteCode);

            if($invite->count() == 1) {
                $invite = $invite->first();
                $mainGuest = $invite->main_guest->person;

                if($mainGuest->email == $verify) {
                    $isVerified = true;
                }
            }
        }

        if($isVerified || $section == 'verify') {
            return $next($request);
        }

        return redirect('invitation/'.$inviteCode.'/verify');

        
    }
}
