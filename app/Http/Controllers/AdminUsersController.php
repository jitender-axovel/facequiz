<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use App\User;

class AdminUsersController extends Controller
{
    public function index()
    {
    	$page = 'Users - Robodoo - Play with Robo';
    	$users = User::orderBy('user_role_id', 'ASC')->get();
    	return view('admin.users.index', compact('page', 'users'));
    }

    public function getEdit($id)
    {
    	$page = "Edit User - Robodoo - Play with Robo";
    	$user = User::find($id);
    	return view('admin.users.edit', compact('page', 'user'));
    }

    public function postEdit(Request $request, $id)
    {
    	$input = $request->input();

        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'gender' => 'in:M,F',
            'dob' => 'date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

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
        $page = "User Details - Robodoo - Play with Robo";
        $user = User::find($id);
        return view('admin.users.view', compact('page', 'user'));
    }

    public function delete($id)
    {
    	$user = User::find($id);
    	$name = $user->name;
    	$user->delete();

    	if($user->trashed()) {
    		$result['status'] = true;
    		$result['message'] = trim($name)."'s record has been deleted.";

    		return json_encode($result);
    	} else {
    		$result['status'] = false;
    		$result['message'] = $name."'s record could not deleted.";

    		return json_encode($result);
    	}
    }

    public function block($id)
    {
        $user = User::find($id);
        $name = $user->name;
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        if($user->is_blocked == 1) {
            $result['status'] = true;
            $result['message'] = trim($name)."'s record has been blocked.";

            return json_encode($result);
        } elseif($user->is_blocked == 0) {
            $result['status'] = true;
            $result['message'] = $name."'s record has been unblocked.";

            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = $name."'s record could not be updated. Kindly try again.";

            return json_encode($result);
        }
    }

    public function exportToCsv(Request $request) {
        $input = $request->input();

        $limit = $input['limit'];
        
        $input = array_intersect_key($input, User::$downloadable);

        if($limit == '') {
            $users = User::select($input)->get()->toArray();
        } else {
            $users = User::select($input)->take($limit)->get()->toArray();
        }

        $delimiter=";";

        $filename = "export.csv";

        header('Content-Type: application/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        $f = fopen('php://output', 'w');

        foreach ($users as $line) { 
            // generate csv lines from the inner arrays
            fputcsv($f, $line, $delimiter); 
        }

        return;
    }
}
