<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{   
    public function addSubscriber($email)
    {
        if(!$this->subscriber($email)){
            $subscriber = new Subscriber([
                'email' => $email,
                'status' => 'subscribed'
            ]);
            $subscriber->save();
            return;
        }

        $subscriber = $this->subscriber($email);
        if($subscriber->status == 'unsubscribed' || $subscriber->status == null){
            $subscriber->status = 'subscribed';
            $subscriber->save();
        }

        return;
    }

    public function unsubscribe($email)
    {
        $subscriber = $this->subscriber($email);
        if($subscriber){
            $subscriber->status = 'unsubscribed';
            $subscriber->save();
        }

        return;
    }

    protected function subscriber($email)
    {
        $subscriber = Subscriber::where('email', $email)->first();
        return $subscriber;
    }
}
