<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payroll;
use App\Report;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ze = \Auth::user();
        $payrolls = Payroll::where('employeeId', $ze->id)->get();
        $reports = $ze->reports;
        return view('home', compact('payrolls', 'reports'));
    }
    
    public function pdf($id)
    {
        $ze = \Auth::user();
        $payroll = Payroll::findOrFail($id);
        if($ze->hasRole('admin') || $ze->hasRole('superadmin') || $payroll->employeeId == $ze->id) {
            return response()->file(
                '../storage/app/payrolls/' . $id
            );
        } else {
            abort(404);
        }
    }
    
    public function report($id)
    {
        $ze = \Auth::user();
        $report = Report::findOrFail($id);
        if($ze->hasRole('admin') || $ze->hasRole('superadmin') || $report->users->contains('id', $ze->id)) {
            return response()->file(
                '../storage/app/reports/' . $id
            );
        } else {
            abort(404);
        }
    }
    
    public function avatar($id)
    {
        $ze = \Auth::user();
        if($ze->hasRole('admin') || $ze->hasRole('superadmin') || $ze->id == $id) {
            return response()->file(
                '../storage/app/avatar/' . $id
            );
            return Storage::response('../storage/app/avatar/' . $id, $ze->avatar);
        } else {
            abort(404);
        }
    }
    
    public function uploadAvatar(Request $request)
    {
        $ze = \Auth::user();
        if ($request->isMethod('post')) {
            if ($request->hasFile('file')) {
                
                $ze->avatar = $request->file->getClientOriginalName();
                $request->file->storeAs(
                    'avatar', $ze->id
                );
                $ze->save();
            }
        }
        return view('avatar', compact('ze'));
    }
}
