<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
public function index(){
$reservations = Reservation::all();
return $reservations;
}

public function show($id)
{
$reservation = Reservation::find($id);
return $reservation;
}
public function destroy($id)
{
reservation::find($id)->delete();
}
public function store(Request $request)
{
$reservation = new Reservation();
$reservation->author = $request->author;
$reservation->title = $request->title;
$reservation->save();
}

public function update(Request $request, $id)
{
$reservation = Reservation::find($id);
$reservation->author = $request->author;
$reservation->title = $request->title;
}

//Hány darab előjegyzése van a bejelentkezett felhasználónak?
public function reserve_count (){
    $user = Auth::user();
    $reservations = DB::table('reservations as r')
        ->where('r.user_id', $user->id)
        ->count();
        return $reservations;
}

//hány olyan előjegyzés van amit x napig jegyeztek elő?
    //whereRaw/selectRaw/havingRaw -> nyers sql-t lehet berakni!!
public function older ($day){
    $user = Auth::user();
    $reservations = DB::table('reservations as r')
        ->select('r.book_id', 'r.start')
        ->where('r.user_id', $user->id)
        ->whereRaw('DATEDIFF(CURRENT_DATE, r.start) >?', $day)
        ->get();
        return $reservations;
}

public function deleteOldReservs(){
    $reservations= DB::table('reservations')
        ->where('status', 1)
        ->delete();
    return $reservations;
}

public function osszElo($user){
    $reservations = DB::table('reservations')
        ->where('user_id', '=', $user)
        ->get();
    return $reservations;
}



}