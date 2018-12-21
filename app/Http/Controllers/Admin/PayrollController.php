<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Payroll;
use App\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $payroll = Payroll::where('file', 'LIKE', "%$keyword%")
                ->orWhere('month', 'LIKE', "%$keyword%")
                ->orWhere('year', 'LIKE', "%$keyword%")
                ->orWhere('createdBy', 'LIKE', "%$keyword%")
                ->orWhere('createdOn', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $payroll = Payroll::latest()->paginate($perPage);
        }
        
        $users = User::all();
        foreach($users as $user) {
            if($user->hasRole('admin') || $user->hasRole('superadmin')) {
                $admins[$user->id] = $user;
            } else {
                $employees[$user->id] = $user;
            }
        }
        return view('admin.payroll.index', compact('payroll', 'employees', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::whereDoesntHave('roles', function($q) {
                    $q->where('id', '<=', 2);
                })->with('roles')->latest()->get();
        foreach($users as $user) {
            $employees[$user->id] = $user->name;
            
        }
        return view('admin.payroll.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        if (!$request->hasFile('file')) {

            return redirect('admin/payroll/create')->with('flash_error', 'No file uploaded!')->withInput();

        }
        
        $requestData = $request->all();
        $requestData['file'] = $request->file->getClientOriginalName();
        $requestData['createdBy'] = \Auth::user()->id;
        $newPayroll = Payroll::create($requestData);
        
        $request->file->storeAs(
            'payrolls', $newPayroll->id
        );
        
        return redirect('admin/payroll')->with('flash_message', 'Payroll added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $payroll = Payroll::findOrFail($id);
        
        $employee = User::findOrFail($payroll->employeeId);

        return view('admin.payroll.show', compact('payroll', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);
        $users = User::whereDoesntHave('roles', function($q) {
                    $q->where('id', '<=', 2);
                })->with('roles')->latest()->get();
        foreach($users as $user) {
            $employees[$user->id] = $user->name;
        }
        return view('admin.payroll.edit', compact('payroll', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        $payroll = Payroll::findOrFail($id);
        $requestData['createdBy'] = \Auth::user()->id;
        if ($request->hasFile('file')) {
            $requestData['file'] = $request->file->getClientOriginalName();
            $request->file->storeAs(
                'payrolls', $id
            );
        }
        $payroll->update($requestData);
        
        return redirect('admin/payroll')->with('flash_message', 'Payroll updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Payroll::destroy($id);

        return redirect('admin/payroll')->with('flash_message', 'Payroll deleted!');
    }
}
