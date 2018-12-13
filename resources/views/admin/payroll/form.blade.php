<div class="form-group{{ $errors->has('file') ? 'has-error' : ''}}">
    {!! Form::label('file', 'File', ['class' => 'control-label']) !!}
    {!! Form::file('file', ['class' => 'form-control', 'accept' => '.pdf', 'style' => 'height: auto']) !!}
    {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('month') ? 'has-error' : ''}}">
    {!! Form::label('month', 'Month', ['class' => 'control-label']) !!}
    {!! Form::select('month', Config::get('constants.months'), old('month') ? old('month') : (isset($payroll) ? null : date('m')), ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('month', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('year') ? 'has-error' : ''}}">
    {!! Form::label('year', 'Year', ['class' => 'control-label']) !!}
    {!! Form::select('year', Config::get('constants.years'), old('year') ? old('year') : (isset($payroll) ? null : date('Y')), ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('year', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('employeeId') ? 'has-error' : ''}}">
    {!! Form::label('employeeId', 'EmployeeId', ['class' => 'control-label']) !!}
    {!! Form::select('employeeId', $employees, old('employeeId') ? old('employeeId') : null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('employeeId', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
