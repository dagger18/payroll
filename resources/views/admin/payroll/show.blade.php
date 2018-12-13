@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Payroll {{ $payroll->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/payroll') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/payroll/' . $payroll->id . '/edit') }}" title="Edit Payroll"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['admin/payroll', $payroll->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete Payroll',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Employee </th><td> {{ $employee->name }} </td></tr>
                                    <tr><th> Month </th><td> {{ $payroll->month }} </td></tr>
                                    <tr><th> Year </th><td> {{ $payroll->year }} </td></tr>
                                    <tr><th> File </th>
                                        <td> {{ $payroll->file }} 
                                            <div id="pdf" style="height: 600px;"></div>
                                            
                                            
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
@section('scripts')
<script type="text/javascript">
PDFObject.embed("/pdf/{{$payroll->id}}", "#pdf");
</script>
@endsection