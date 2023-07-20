<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function getUsers()
    {
        if (request()->ajax()) {
            $users = User::latest()->get();

            return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row){
                        $actionBtn = "<a href='javascript:void(0)' id='show' class='show btn btn-success btn-sm'>Show</a>
                                      <a href='javascript:void(0)' id='edit' class='edit btn btn-success btn-sm'>Edit</a>
                                      <button onclick='deleteUser($row->id)' id='delete' class='delete btn btn-danger btn-sm'>Delete</button>";
                        return $actionBtn;
                    })
                    ->addColumn('drag', function ($row) use($users){
                        $count = count($users);
                        $dragLink = "<i class='h2 text-primary bi bi-grip-horizontal'></i>
                                    <span class='hidden' data-total='{$count}'></span>";
                        return $dragLink;
                    })
                    ->rawColumns(['action', 'drag'])
                    ->make(true);
        }   
    }

    public function deleteUser()
    {
        $user = User::find(request('id'));
        $user->delete();
        return response()->json(['success'=>'User Deleted!']);
    }
}
