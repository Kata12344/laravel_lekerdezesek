<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Copy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CopyController extends Controller
{
    //
    public function index(){
        $copies =  Copy::all();
        return $copies;
    }
    
    public function show($id)
    {
        $copies = Copy::find($id);
        return $copies;
    }
    public function destroy($id)
    {
        Copy::find($id)->delete();
    }
    public function store(Request $request)
    {
        $copy = new Copy();
        $copy->book_id = $request->book_id;
        $copy->hardcovered = $request->hardcovered;
        $copy->publication = $request->publication;
        $copy->status = 0;
        $copy->save(); 
    }

    public function update(Request $request, $id)
    {
        //a book_id ne változzon! mert akkor már másik példányról van szó
        $copy = Copy::find($id);
        $copy->hardcovered = $request->hardcovered;
        $copy->publication = $request->publication;
        $copy->status = $request->status;
        $copy->save();        
    }

    public function copies_pieces($title)
    {	
        $copies = Book::with('copy_c')->where('title','=', $title)->count();
        return $copies;
    }

    

    //view-k:

    public function newView()
    {
        //új rekord(ok) rögzítése
        $books = Book::all();
        return view('copy.new', ['books' => $books]);
    }

    public function editView($id)
    {
        $books = Book::all();
        $copy = Copy::find($id);
        return view('copy.edit', ['books' => $books, 'copy' => $copy]);
    }

    public function listView()
    {
        $copies = Copy::all();
        //copy mappában list blade
        return view('copy.list', ['copies' => $copies]);
    }

    public function bookCopyCount($title){
        $copies = DB::table('copies as c')
        ->join('books as b', 'c.book_id', '=', 'b.book_id')
        ->where('b.title', '=', $title)
        ->count();
        
        return $copies;
    }

    public function hardcoveredCopyCount($hardcovered){
        $copies = DB::table('copies as c')
        ->select('author', 'title')
        ->join('books as b', 'c.book_id', '=', 'b.book_id')
        ->where('c.hardcovered', '=', $hardcovered)
        ->get();

        return $copies;
    }

    public function publicationCopyCount($publication){
        $copies = DB::table('copies as c')
        ->select('author', 'title')
        ->join('books as b', 'c.book_id', '=', 'b.book_id')
        ->where('c.publication', '=', $publication)
        ->get();

        return $copies;
    }

    public function statusCopyCount(){
        $copies = DB::table('copies as c')
        ->where('c.status', '=', 0)
        ->orWhere('c.status', '=', 2)
        ->count();

        return $copies;
    }
    
    public function pubCopyCount($publication, $book_id){
        $copies = DB::table('copies as c')
        ->where('c.publication', '=', $publication)
        ->where('c.book_id', '=', $book_id)
        ->where('c.status', '=', 0)
        ->orWhere('c.status', '=', 2)
        ->count();

        return $copies;
    }

    public function hatosfel($book_id){
        $copies = DB::table('copies as c')
        ->select('l.user_id', 'l.copy_id', 'l.start')
        ->join('lendings as l', 'c.copy_id', '=', 'l.copy_id')
        ->where('c.book_id', '=', $book_id)
        ->get();

        return $copies;
    }

    public function adminTorolSelejt(){
        $copies = DB::table('copies as c')
        ->where('c.status', '=', 1)
        ->delete();
        return $copies;
    }

    public function adminTorolHard(){
        $copies = DB::table('copies as c')
        ->where('c.hardcovered', '=', 1)
        ->delete();
        return $copies;
    }

    public function elott(){
        $copies = DB::table('copies as c')
        ->where('c.publication', '<', 1999)
        ->get();
        return $copies;
    }
}
