@extends('layout', [
    'title' => 'Support Groups',
    'description' => 'There are thousands of local groups supporting people in their area, find yours now.'
])

@section('content')

    <p>Find your local support group, kindly maintained by <a href="https://covidmutualaid.org/">covidmutualaid.org</a>.</p>

    <iframe src="https://covidmutualaid.cc/" frameborder="0" width="100%" height="100%" class="min-vh-100" title="Covid-19 Mutual Aid Groups"
        aria-label="United Kingdom local authority districts (2018) Symbol map" scrolling="no" style="border: none;"
        frameborder="0">
    </iframe>

    {{--
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">City</th>
                <th scope="col">Area</th>
                <th scope="col">Contact</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->city }}</td>
                    <td>{{ $group->area }}</td>
                    <td>
                        @if($group->facebook)
                            <a href="{{$group->facebook}}" class="btn btn-light group-link">
                                    <i class="fab fa-facebook-square icon facebook"></i> Facebook
                            </a>
                        @endif
                        &nbsp;
                        @if($group->whatsapp)
                            <a href="{{$group->whatsapp}}" class="btn btn-light group-link">
                                    <i class="fab fa-whatsapp-square icon whatsapp"></i> WhatsApp
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    --}}

@endsection
