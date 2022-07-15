<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
Use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke($id, $token)
    {
        if(!$id || !$token){
            abort(404);
        }

        $user = User::where('id', $id)->first();

        if(!$user){
            abort(404);
        }

        if($user->email_verified_at){
            return view('auth.email-verified', ['msg' => __('Il tuo account è già verificato. Verrai reindirizzato alla pagina di accesso a breve.')]);
        }

        if(!$token == $user->token){
            return view('auth.email-verified', ['msg' => __('Questo token non è valido.')]);
        }

        $user->email_verified_at = (new DateTime('now', new DateTimeZone('Europe/Rome')))->format('Y-m-d H:i:s');
        $user->save();

        if($user->email_verified_at){
            return view('auth.email-verified', ['msg' => __('Il tuo account è verificato. L\'amministratore del sito lo attiverà e potrai accedere.')]);
        }
    }

    /**
     * Send new verification email if user has not verified his account
     */
    public function sendNewVerificationEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
       
        $user = User::where('email', $request->get('email'))->first();
    
        if(!$user){
            return redirect()->back()->with('message', __('L\'account non esiste'));
        }

        if($user->email_verified_at){
            return redirect()->back()->with('message', __('Questo account è già verificato'));
        }

        $user->sendEmailVerificationNotification();
        return redirect()->back()->with('message', __('Email is sent'));
    }
}
