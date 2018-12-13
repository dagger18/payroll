<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payroll;

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
        return view('home', compact('payrolls'));
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
}
