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
            <div class="card-header">Bảng lương</div>

            <div class="card-body">
                @if (count($payrolls) > 0)
                <ul>
                @foreach($payrolls as $item)
                <li>
                    <a href="/pdf/{{$item->id}}" target="_blank">tháng {{$item->month}} năm {{$item->year}}</a>
                </li>
                @endforeach
                </ul>
                @else
                Bạn chưa có bảng lương nào
                @endif
                
                
            </div>
        </div>
    </div>
    
</div>
@endsection
