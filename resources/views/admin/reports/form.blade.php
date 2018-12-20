<div class="form-group{{ $errors->has('file') ? 'has-error' : ''}}">
    {!! Form::label('file', 'File', ['class' => 'control-label']) !!}
    {!! Form::file('file', ['class' => 'form-control', 'accept' => '.pdf', 'style' => 'height: auto']) !!}
    {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('viewers') ? ' has-error' : ''}}">
    {!! Form::label('viewers', 'Viewers (hold Ctrl to select multiple viewers)', ['class' => 'control-label']) !!}
    {!! Form::select('viewers[]', $viewers, isset($report_viewers) ? $report_viewers : [], ['class' => 'form-control', 'multiple' => true]) !!}
</div>

<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
