@extends('layout')

@section('content')

    <div class="row">
        <div class="col-sm-1">
            {{--  --}}
        </div>

        <div class="col-sm-4">

            <h2>Login</h2>

            <form method="post">
                <div class="form-group">
                    <label for="email">Email or Mobile number</label>
                    <input type="text" class="form-control" id="email" name="emailOrPhone" value="{{$emailOrPhone ?? ''}}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                @if(!empty($loginError))
                    <div class="alert alert-danger" role="alert">
                        {{$loginError}}
                    </div>
                @endif
                
                <button type="submit" name="action" value="login" class="btn btn-primary">Login</button>
            </form>

        </div>
        
        <div class="col-sm-1">
            {{--  --}}
        </div>

        <div class="col-sm-4">
        
            <h2>Register</h2>

            <form method="post">
                <div class="form-group">
                    <label for="name">Full name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$name ?? ''}}">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{$email ?? ''}}">
                </div>
                <div class="form-group">
                    <label for="phone">Mobile number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{$phone ?? ''}}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            
                @if(!empty($registerError))
                <div class="alert alert-danger" role="alert">
                    {{$registerError}}
                </div>
                @endif
            
                <button type="submit" name="action" value="register" class="btn btn-primary">Register</button>
            </form>
        
        </div>
    </div>

@endsection
