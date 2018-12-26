<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Report;
use App\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
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
            $reports = Report::where('file', 'LIKE', "%$keyword%")
                ->orWhere('createdBy', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $reports = Report::latest()->paginate($perPage);
        }
        
        $users = User::all();
        foreach($users as $user) {
            if($user->hasRole('admin') || $user->hasRole('superadmin')) {
                $admins[$user->id] = $user;
            } else {
                $employees[$user->id] = $user;
            }
        }
        return view('admin.reports.index', compact('reports', 'employees', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        foreach(User::all() as $user) {
            $viewers[$user->id] = $user->name . ' (id: ' . $user->id . ')';
        }
        return view('admin.reports.create', compact('viewers'));
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
            return redirect('admin/reports/create')->with('flash_error', 'No file uploaded!')->withInput();
        }
        
        $requestData = $request->all();
        $requestData['file'] = $request->file->getClientOriginalName();
        $requestData['createdBy'] = \Auth::user()->id;
        $newReport = Report::create($requestData);
        
        $request->file->storeAs(
            'reports', $newReport->id
        );
        
        if ($request->has('viewers')) {
            foreach ($request->viewers as $viewer) {
                $newReport->users()->attach($viewer);
            }
        }
        
        return redirect('admin/reports')->with('flash_message', 'Report added!');
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
        $report = Report::findOrFail($id);

        return view('admin.reports.show', compact('report'));
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
        foreach(User::all() as $user) {
            $viewers[$user->id] = $user->name . ' (id: ' . $user->id . ')';
        }
        $report = Report::findOrFail($id);
        foreach($report->users as $viewer) {
            $report_viewers[] = $viewer->id;
        }
        
        return view('admin.reports.edit', compact('report', 'viewers', 'report_viewers'));
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
        if ($request->hasFile('file')) {
            $requestData['file'] = $request->file->getClientOriginalName();
            $request->file->storeAs(
                'reports', $id
            );
        }
        $report = Report::findOrFail($id);
        $report->update($requestData);
        $report->users()->detach();
        if ($request->has('viewers')) {
            foreach ($request->viewers as $viewer) {
                $report->users()->attach($viewer);
            }
        }
        
        return redirect('admin/reports')->with('flash_message', 'Report updated!');
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
        Report::destroy($id);

        return redirect('admin/reports')->with('flash_message', 'Report deleted!');
    }
    
}
