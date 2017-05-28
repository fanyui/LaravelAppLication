<?php

namespace App\Http\Controllers;
use App\Notification;
use Illuminate\Http\Request;

use App\Http\Requests;

class NotificationController extends Controller
{
	public function __construct(){
		$this->middleware("notification");
	}

	//delete the notification with key $notifs
    public function destroy(Request $request,Notification $notif){

    	$notif->delete();

    	return redirect("/notification");
    	
    }

    public function index(Request $request){
    	return "All notifications from Dbase";
    }
}
