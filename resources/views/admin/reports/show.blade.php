@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Report {{ $report->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/reports') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/reports/' . $report->id . '/edit') }}" title="Edit Report"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/reports', $report->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete Report',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> File </th><td> {{ $report->file }} </td></tr>
                                    <tr><th> CreatedBy </th><td> {{ $report->createdBy }} </td></tr>
                                    <tr><th> Name </th><td> {{ $report->name }} </td></tr>
                                    <tr>
                                        <th> Viewers </th>
                                        <td> 
                                            <ul>
                                                @foreach($report->users as $user)
                                                <li>{{ $user->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
