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
                    <input type="text" class="form-control" id="email" name="emailOrPhone" value="{{$emailOrPhone}}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                @if($error)
                    <div class="alert alert-danger" role="alert">
                        {{$error}}
                    </div>
                @endif
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
        
        <div class="col-sm-1">
            {{--  --}}
        </div>

        <div class="col-sm-4">
        
            <h2>Register</h2>

        
        </div>
    </div>

@endsection
