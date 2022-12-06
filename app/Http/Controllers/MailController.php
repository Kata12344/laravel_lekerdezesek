<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemoMail;

class MailController extends Controller
{
    public function index()
   {
       $mailData = [
        'title' => 'Kata <3',
           'body' => '- Hogy hívják drakula hátsóját?
           - ??????
           - Rémlik'
       ];
       
       foreach (['vetka.adi@gmail.com', 'vitayz60@gmail.com'] as $fogadok){
        Mail::to($fogadok)
            ->send(new DemoMail($mailData));
       }
       

       dd("Email elküldve!");
   }

}
