@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">Tài liệu</div>

            <div class="card-body">
                @if (count($reports) > 0)
                <ul>
                @foreach($reports as $item)
                <li>
                    <a href="/report/{{$item->id}}" target="_blank">{{$item->name}}</a>
                </li>
                @endforeach
                </ul>
                @else
                Bạn chưa có tài liệu nào
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
