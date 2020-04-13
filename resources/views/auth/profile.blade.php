@extends('layout')

@section('content')

<div class="row">
    <div class="col-sm-2 border-right">
        <p><a href="{{route('profile')}}">My details</a></p>
        <p><a href="{{route('logout')}}">Logout</a></p>
    </div>
    <div class="col-sm-8">
        <h2>Hello {{$user['name']}}</h2>

        @if(!empty($success))
            <div class="alert alert-success" role="alert">
                {{$success}}
            </div>
        @endif
        
        <form method="post">
            <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$user['name']}}">
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox"
                            class="custom-control-input"
                            id="seeking-assistance"
                            name="seekingAssistance"
                            value="YES"
                            @if(($user['seekingAssistance'] ?? 'NO') === 'YES')
                                checked="checked"
                            @endif
                        >
                    <label class="custom-control-label" for="seeking-assistance">I am seeking assistance</label>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox"
                            class="custom-control-input"
                            id="offering-assistance"
                            name="offeringAssistance"
                            value="YES"
                            @if(($user['offeringAssistance'] ?? 'NO') === 'YES')
                                checked="checked"
                            @endif
                        >
                    <label class="custom-control-label" for="offering-assistance">I am offering assistance</label>
                </div>
            </div>
            
            {{-- 
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
             --}}

            @if(!empty($error))
                <div class="alert alert-danger" role="alert">
                    {{$error}}
                </div>
            @endif
            
            <button type="submit" name="action" value="update" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

@endsection
