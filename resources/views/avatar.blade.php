@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Avatar</div>
                <div class="card-body">
                    @if ($ze->avatar)
                    <img src="/avatar/{{ $ze->id }}" style="max-height:200px;margin: 10px 0;" />
                    @endif
                    {!! Form::model($ze, [
                        'method' => 'POST',
                        'url' => ['/upload-avatar'],
                        'class' => 'form-horizontal',
                        'files' => true
                    ]) !!}

                    <div class="form-group{{ $errors->has('file') ? 'has-error' : ''}}">
                        {!! Form::label('file', 'File', ['class' => 'control-label']) !!}
                        {!! Form::file('file', ['class' => 'form-control', 'style' => 'height: auto']) !!}
                        {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection