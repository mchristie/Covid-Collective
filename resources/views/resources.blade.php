@extends('layout', [
    'title' => 'Resources',
    'description' => 'We\'ve collected loads of online resources to help everyone from parents to businesses through self-isolation, you\'ll find them all here'
])

@section('content')

    {{-- <h1>Resources</h1> --}}

    <div class="row">
        <div class="col-sm-3 mb-3">
            <form method="get">
                <div class="card">
                    <div class="card-header">
                        Search
                    </div>

                    @php
                        $filters = [
                            'Category' => [
                                'Entertainment',
                                'Finance',
                                'Fitness',
                                'Information',
                                'Mental heath',
                                'News',
                                'Research',
                                'Social',
                                'Support',
                                'Teaching',
                                'Volunteering',
                            ],
                            'Audience' => [
                                'Anyone',
                                'Business',
                                'Kids',
                                'LGBT',
                                'Parents',
                                'Vulnerable',
                            ],
                            'Cost' => [
                                'Free',
                                'Freemium',
                                'Paid',
                            ],
                            'Media' => [
                                'App',
                                'Audio',
                                'Social Media',
                                'Text',
                                'Video',
                                'Website',
                            ]
                        ]
                    @endphp

                    @foreach($filters as $title => $options)
                        <div class="card-body border-bottom">
                            <div class="card-title">
                                <a data-toggle="collapse"
                                    href="#filter-group-{{$title}}"
                                    role="button"
                                    aria-expanded="true"
                                    style="color: inherit;"
                                >
                                    <strong>{{$title}}</strong>
                                </a>
                            </div>
                            <ul class="list-group list-group-flush collapse" id="filter-group-{{$title}}">
                                @foreach($options as $i => $option)
                                    <li class="list-group-item">
                                    <input type="checkbox"
                                            class="form-check-input"
                                            name="{{$title}}[]"
                                            value="{{$option}}"
                                            id="{{$title.'-'.$i}}"
                                            @if(in_array($option, $selected[$title] ?? []))
                                                checked
                                            @endif
                                        >
                                        <label class="form-check-label" for="{{$title.'-'.$i}}">{{$option}}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach

                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        &nbsp;
                        <a href="/resources" class="btn btn-light">Clear</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-sm-9">
            @forelse($resources as $resource)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            <strong>
                                <a href="{{$resource->url}}" style="color: inherit;" class="stretched-link">
                                    {{$resource->title}}
                                </a>
                            </strong>
                        </h5>
                        <p class="card-subtitle mb-2 row text-muted" style="font-size: 1em;">
                            <span class="d-inline-block col-sm 3">
                                <i class="fas fa-folder-open"></i> &nbsp; {{$resource->category}}
                            </span>
                            <span class="d-inline-block col-sm 3">
                                <i class="fas fa-users"></i> &nbsp; {{$resource->audience}}
                            </span>
                            <span class="d-inline-block col-sm 3">
                                <i class="fas fa-coins"></i> &nbsp; {{$resource->cost}}
                            </span>
                            <span class="d-inline-block col-sm 3">
                                <i class="fas fa-photo-video"></i> &nbsp; {{$resource->media}}
                            </span>
                        </p>

                        {{$resource->description}}
                    </div>
                </div>
            @empty
                <div class="alert alert-info" role="alert">
                    Sorry, no resources matched your search.
                </div>
            @endforelse
        </div>
    
    </div>

@endsection
