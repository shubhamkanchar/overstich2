<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard(){
        return view('backend.user.dashboard');
    }
    
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('backend.admin.user.index');
    }
}
