<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class AdminUsersController extends Controller
{
    public function index()
    {
    	$page = 'Users - Admin';
    	$users = User::get();
    	return view('admin.users.index', compact('page', 'users'));
    }

    public function getEdit($id)
    {
    	$page = "Edit User - Admin";
    	$user = User::find($id);
    	return view('admin.users.edit', compact('page', 'user'));
    }

    public function postEdit(Request $request, $id)
    {
    	$input = $request->input();

    	$input = array_intersect_key($input, User::$updatable);
    	if(User::where('id', $id)->update($input)) {
    		$request->session()->flash('success', 'Record updated successfully');
    		return redirect('admin/users');
    	} else {
    		$request->session()->flash('error', "Record cann't be updated");
    		return redirect('admin/users');
    	}
    }
    public function view($id)
    {
        $page = "User Details - Admin";
        $user = User::find($id);
        return view('admin.users.view', compact('page', 'user'));
    }

    public function delete($id)
    {
    	$user = User::find($id);
    	$name = $user->first_name.' '.$user->last_name;
    	$user->delete();

    	if($user->trashed()) {
    		$result['status'] = true;
    		$result['message'] = $name."'s record has been deleted.";

    		return json_encode($result);
    	} else {
    		$result['status'] = false;
    		$result['message'] = $name."'s record could not deleted.";

    		return json_encode($result);
    	}
    }
}
