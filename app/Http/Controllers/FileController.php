<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
   {
       return view('fileUpload');
   }
public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:txt,pdf,png|max:10000',
        ]);
   
        $fileName = time().'.'.$request->file->extension();  
 
        $request->file->move(public_path('uploads'), $fileName);
 
        /*  
            Write Code Here for
            Store $fileName name in DATABASE from HERE
        */
   
        return back()

        ->with('success','Ügyi vagy feltöltötted!!.')
        ->with('file', $fileName);

}

}
