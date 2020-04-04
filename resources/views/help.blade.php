@extends('layout', [
    'title' => 'Ways to Help',
    'description' => 'There are loads of ways to do your part to help everyone out during this crisis.'
])

@section('content')
    
<div class="row">
    <div class="col-lg-8">

        <p>There are loads of ways to do your part to help everyone out during this crisis.</p>
        
        <h4 class="mt-4">1. Follow the guidance</h4>
        <p>The most important thing to do is follow the government's guidance on how to reduce the spread and flatten the curve.</p>
        <p>
            <a target="_blank" href="https://www.gov.uk/coronavirus">Read the Gov.UK Guidance &raquo;</a>
        </p>

        <h4 class="mt-4">2. Track your symptoms</h4>
        <p>Report your symptom (or lack of them) daily using COVID Sympton Tracker app to help track the spread of the coronavirus.</p>
        <p>
            <a target="_blank" href="https://covid.joinzoe.com/">Get the app at covid.joinzoe.com &raquo;</a>
        </p>
        
        <h4 class="mt-4">3. Share this website</h4>
        <p>We're working hard to make this the best place to find support during these tough times, but it's only useful if the people who need to find support can find us. Share us on social media so people who might need help can find it.</p>
        <p>
            <a target="_blank" href="https://twitter.com/Covid_Collectiv">
                <i class="fab fa-twitter"></i>
                &nbsp;
                @Covid_Collectiv  &raquo;
            </a>
            <br>
            <a target="_blank" href="https://www.facebook.com/CovidCollectiveUK">
                <i class="fab fa-facebook-f"></i>
                &nbsp;
                @CovidCollectiveUK  &raquo;
            </a>
        </p>
        
        <h4 class="mt-4">4. Join a local support group</h4>
        <p>There are support groups all over the country. Find and join yours today.</p>
        <p>
            <a href="{{route('groups')}}">Find a support group &raquo;</a>
        </p>
        
        <h4 class="mt-4">5. Lend us a hand</h4>
        <p>This is a one-man project currently, but you can contibute through GitHub.</p>
        <p>
            <a target="_blank" href="https://github.com/mchristie/Covid-Collective">Fork me on GitHub &raquo;</a>
        </p>

    </div>
</div>

@endsection
