<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Payroll;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        if (!empty($keyword)) {
            $users = User::where('id', '>', 2)
                        ->where(function($q) use ($keyword) {
                            $q->where('name', 'LIKE', "%$keyword%")
                                ->orWhere('email', 'LIKE', "%$keyword%");
                        });
        } else {
            $users = User::where('id', '>', 2);
        }
        
        $ze = \Auth::user();
        if ($ze->hasRole('admin')) {
            
            $users->whereDoesntHave('roles', function($q) {
                $q->where('name','admin');
            });
        }
        
        $users = $users->with('roles')->latest()->paginate($perPage);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $ze = \Auth::user();
        if ($ze->hasRole('admin')) {
            $roles = Role::where('id', '>', 2)->select('id', 'name', 'label')->get();
        } else {
            $roles = Role::where('id', '!=', 1)->select('id', 'name', 'label')->get();
        }
        $roles = $roles->pluck('label', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users',
                'password' => 'required',
                'roles' => 'required',
                'department' => ''
            ]
        );

        $data = $request->except('password');
        $data['password'] = bcrypt($request->password);
        
        $user = User::create($data);
        
        if ($request->hasFile('file')) {
                
            $user->avatar = $request->file->getClientOriginalName();
            $request->file->storeAs(
                'avatar', $user->id
            );
            $user->save();
        }
        
        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect('admin/users')->with('flash_message', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $payrolls = Payroll::where('employeeId', $user->id)->get();
        return view('admin.users.show', compact('user', 'payrolls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        
        $ze = \Auth::user();
        if ($ze->hasRole('admin')) {
            $roles = Role::where('id', '>', 2)->select('id', 'name', 'label')->get();
        } else {
            $roles = Role::where('id', '!=', 1)->select('id', 'name', 'label')->get();
        }
        $roles = $roles->pluck('label', 'name');

        $user = User::with('roles')->select('id', 'name', 'email', 'department', 'avatar')->findOrFail($id);
        $user_roles = [];
        foreach ($user->roles as $role) {
            $user_roles[] = $role->name;
        }

        return view('admin.users.edit', compact('user', 'roles', 'user_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int      $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users,email,' . $id,
                'roles' => 'required',
                'department' => ''
            ]
        );

        $data = $request->except('password');
        if ($request->has('password') && $request->password != '') {
            $data['password'] = bcrypt($request->password);
        }
        
        if ($request->hasFile('file')) {
            $data['avatar'] = $request->file->getClientOriginalName();
            $request->file->storeAs(
                'avatar', $id
            );
        }
        $user = User::findOrFail($id);
        $user->update($data);

        $user->roles()->detach();
        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect('admin/users')->with('flash_message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('admin/users')->with('flash_message', 'User deleted!');
    }
    
    public function diagram()
    {
        $users = User::whereDoesntHave('roles', function($q) {
                    $q->where('id', '<=', 2);
                })->with('roles')->latest()->get();
        $levels = [];
        foreach($users as $user) {
            $levels[$user->roles[0]->level][] = $user;
        }
        ksort($levels);
        return view('admin.users.diagram', compact('levels'));
        
    }
    
}
