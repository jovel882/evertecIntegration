<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		if (session()->has('orderData')) {
			session()->forget('orderData');
		}    
        return view('home');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function unreadNotification(string $idNotification)
    {
        $notification = auth()
            ->user()
            ->notifications()
            ->findOrFail($idNotification);
        $notification->markAsRead();
        return redirect($notification->data['url']);		
    }
}
