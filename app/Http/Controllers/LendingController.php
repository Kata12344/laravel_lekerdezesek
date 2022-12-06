<?php

namespace App\Http\Controllers;

use App\Models\Copy;
use App\Models\Lending;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    //
    public function index(){
        $lendings =  Lending::all();
        return $lendings;
    }

    public function show ($user_id, $copy_id, $start)
    {
        $lending = Lending::where('user_id', $user_id)->where('copy_id', $copy_id)->where('start', $start)->get();
        return $lending[0];
    }
    public function destroy($user_id, $copy_id, $start)
    {
        LendingController::show($user_id, $copy_id, $start)->delete();
    }

    public function store(Request $request)
    {
        $lending = new Lending();
        $lending->user_id = $request->user_id;
        $lending->copy_id = $request->copy_id;
        $lending->start = $request->start;
        $lending->save();
    }

    public function update(Request $request, $user_id, $copy_id, $start)
    {
        $lending = LendingController::show($user_id, $copy_id, $start);
        $lending->user_id = $request->user_id;
        $lending->copy_id = $request->copy_id;
        $lending->start = $request->start;
        $lending->save();
    }

    public function userLendingsList()
    {
        $user = Auth::user();	//bejelentkezett felhasználó
        $lendings = Lending::with('user_c')->where('user_id','=', $user->id)->get();
        return $lendings;
    }

    public function userLendingsCount()
    {
        $user = Auth::user();	//bejelentkezett felhasználó
        $lendings = Lending::with('user_c')->where('user_id','=', $user->id)->distinct('copy_id')->count();
        return $lendings;
    }

    //view-k:
    public function newView()
    {
        //új rekord(ok) rögzítése
        $users = User::all();
        $copies = Copy::all();
        return view('lending.new', ['users' => $users, 'copies' => $copies]);
    }

    //Bejelentkezett felhasználó azon kölcsönzéseit add meg (copy_id és db), ahol egy példányt legalább db-szor (paraméteres fg) kölcsönzött ki! (együtt)
    public function reserve_db ($db){
    $user = Auth::user();
    $lendings = DB::table('lendings')
        ->selectRaw('count(copy_id) as number_of_copies, copy_id')
        ->where('user_id', $user->id)
        ->groupBy('copy_id')
        ->having('number_of_copies', '>=', $db)
        ->get();
        return $lendings;
    }

    //hány előjegyzés van az adott könyvre- nem példányra
    
    //jelenítsd meg azon könyveket, amik jelenleg nálam vannak, szerző nevével, címmel
    public function my_books (){
        $user = Auth::user();
        $books = DB::table('lendings as l')
        ->join('copies as c', 'l.copy_id', '=', 'c.copy_id')
        ->join('books as b', 'c.book_id', '=', 'b.book_id')
        ->select('b.author', 'b.title')
        ->where('l.user_id', '=', $user->id)
        ->where('l.end is null')
        ->get();
        return $books;
    }


    //azon felhasználók törlése, akiknek nincs kölcsönzése
    public function delete_users(){
        $users = DB::table('users as u')
        ->select('id')
        ->join('lendings as l', 'l.user_id', 'u.id')
        ->whereNotInRaw('select user_id from lendings')
        ->delete();
        return $users;
    }
}
