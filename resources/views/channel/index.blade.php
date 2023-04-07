@extends('layouts.app')

@section('content')
    <div class="p-5 mb-4 bg-primary">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">{{ $channel->name }}</h1>
            <p class="fs-4">{{ $channel->description }}</p>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ $channel->picture }}" class="rounded-circle me-3" height="130px;" width="130px;">
                <div>
                    <h3>{{ $channel->name }}</h3>
                    {{-- <p>{{ $channel->subscribers() }} Subscribers</p> --}}
                </div>
            </div>
            <div>
                @can('update', $channel)
                    <a href="{{ route('channel.edit', $channel) }}" class="btn btn-primary">Edit Channel</a>
                @endcan
            </div>
        </div>

        <div>
            <div class="row my-4">
                @foreach ($channel->videos as $video)
                    <div class="col-12 col-md-6 col-lg-4">
                        <a href="{{ route('video.watch', $video) }}" class="card-link">
                            <div class="card mb-4" style="width: 333px; border:none;">
                                <img class="card-img-top" src="{{ asset($video->thumbnail) }}" alt="Card image cap"
                                    style="height: 174px; width:333px">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('/images/' . $video->channel->image) }}" height="40px"
                                            class="rounded circle">

                                        <h4 class="ms-3">{{ $video->title }}</h4>

                                    </div>
                                    <p class="text-gray mt-3 font-weight-bold" style="line-height: 0.2px">
                                        {{ $video->channel->name }}
                                    </p>
                                    <p class="mt-3 gray-text font-weight-bold" style="line-height: 0.2px">
                                        {{ $video->views }}
                                        views •
                                        {{ $video->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>

                    </div>
                @endforeach
            </div>

        </div>

    </div>
@endsection
