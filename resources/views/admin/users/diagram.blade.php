@extends('layouts.backend')

@section('content')
    <div class="container">
        <ul class="diagram">
        @foreach($levels as $level)
            <li>
                <ul class="diagram-level">
                @foreach($level as $user)
                    <li>
                        @if (empty($user->avatar))
                        <img src="/svg/avatar.png" />
                        @else
                        <img src="/avatar/{{ $user->id }}" />
                        @endif
                        <div>{{ $user->name }}</div>
                        <div>{{ $user->roles[0]->label }} {{ $user->department }}</div>
                    </li>
                @endforeach
                </ul>
            </li>
        @endforeach
        </ul>
    </div>
@endsection
