@extends('layout', [
    'title' => 'Volunteer',
    'description' => "We're working on tools to help people support those in need, if you'd like to be updated when these are available enter
    your email address below and we'll let you know."
])

@section('content')

<div class="row">
    <div class="col-lg-8">
                
        {{-- <h1>Volunteer</h1> --}}

        @if($thanks || false)
            <div class="alert alert-success" role="alert">
                Thanks, we'll email you when there's some news!
            </div>
        @endif

        <p>We're working on tools to help people support those in need, if you'd like to be updated when these are available enter your email address below and we'll let you know.</p>

        <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>

@endsection
