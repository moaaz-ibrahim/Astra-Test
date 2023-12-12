<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    //
    public function showForm()
    {
        return view('import');
    }
    public function import(Request $request)
    {
        $file = $request->file('file');


        $newUser = Excel::import(new UserImport, $file);
        // dd($newUser);


        return redirect('/')->with('success', 'Users imported successfully!');
    }
    public function showUsers(){
        $users = User::all();
        return view('index', compact('users'));
    }
    public function export(Request $request)
{
    // dd($request->input());
    $columns= $request->input('columns');
    $rowsLimit= $request->input('row_limit');
    $data = ['columns' => $columns, 'rowsLimit' => $rowsLimit];
    // dd($columns);
    return Excel::download(new UserExport($data), 'users.xlsx');
}
}
