<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\App\Policycheck::pv('admin'))
        {
            $users = User::orderBy('id')->paginate(8);
            return view('dashboard.users.index', compact('users'))
                ->with('i', (request()->input('page', 1) - 1) * 8);
        }
        elseif (\App\Policycheck::pv('supervisor'))
        {
            $products = Product::where('needReview' , '=', 1)->orderBy('id')->paginate(8);
            return view('dashboard.users.index', compact('products'))
                ->with('i', (request()->input('page', 1) - 1) * 8);
        }
        elseif (\App\Policycheck::pv('editor')){

            $products = Product::orderBy('id')->paginate(8);
//            $userProducts = $products->where('added_by',Session::get('userId'))->count();
            $userProducts = $products->where('added_by',Session::get('userId'));
//            $shownProducts = $products->where('needReview',0)->where('added_by',Session::get('userId'))->count();
            return view('dashboard.users.index', compact('products','userProducts'))
                ->with('i', (request()->input('page', 1) - 1) * 8);
        }
        else {
            echo 'You don\'t have the policy';
            dd(Session::get('userId'));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roleOptions = User::getRoleOptions();
        return view('dashboard.users.create', compact('roleOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logName' => 'required',
            'password' => 'required',
            'fullName' => 'required',
            'role' => 'required',
        ], [
            'logName.required' => 'please enter log name',
            'password.required' => 'please enter password',
            'fullName.required' => 'please enter full name',
            'role.required' => 'please enter role',
        ]);
        $user = new User();
        $user->logName = request('logName');
        $user->password = Hash::make(request('logName'));
        $user->fullName = request('fullName');
        $user->role = request('role');
        $user->isActive = true;
        // admin 1 - editor 2 - supervisor 3
        if ($user->role == 'editor')
        {
            $policyId = 2;
        }
        else if ($user->role == 'supervisor')
        {
            $policyId = 3;
        }
        $user->save();
        $user->policies()->attach($policyId);
        return redirect()->route('users.index')
            ->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('dashboard.users.show', compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roleOptions = User::getRoleOptions();
        return view('dashboard.users.edit', compact('user', 'roleOptions'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        request()->validate([
            'logName' => 'required',
            'password' => 'required',
            'fullName' => 'required',
            'role' => 'required',
        ], [
            'logName.required' => 'please enter log name',
            'password.required' => 'please enter password',
            'fullName.required' => 'please enter full name',
            'role.required' => 'please enter role',
        ]);
        $user->logName = request('logName');
        $user->password = Hash::make(request('logName'));
        $user->fullName = request('fullName');
        $user->role = request('role');
        $user->isActive = request('isActive');
        $user->save();
        return redirect()->route('admins.index')
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Member deleted successfully.');
    }
    public function isActive(User $user)
    {
        if($user->isActive == 0){
            $user->isActive = 1;
        }
        else{
            $user->isActive = 0;
        }

        $user->save();
        return redirect()->route('users.index')
            ->with('success','User status changes successfully');
    }
}
