@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row gx-5">
        <div class="col-8">
            <p class="lead">Diplay Posts</p>
            @forelse ($home_posts as $post)
                <div class="card mb-4">
                    {{-- Insert Title --}}
                    @include('users.posts.contents.title')
                    {{-- Insert Body --}}
                    @include('users.posts.contents.body')

                </div>
            @empty
                {{-- If the there is no post, display this --}}
                <div class="text-center">
                    <h2>Share Photos</h2>
                    <p class="text-muted">When you share photos they'll appear on your profile.</p>
                    <a href="{{route('post.create')}}" class="text-decoration-none">Share Your First Photo</a>
                </div>
            @endforelse
        </div>
        <div class="col-4">
            <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3 mt-1">
                <div class="col-auto">
                    <a href="{{route('profile.show', Auth::user()->id)}}">
                        @if (Auth::user()->avatar)
                            <img src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}}" class="rounded-circle avatar-md">
                        @else
                            <i class="fa solid fa-circle-user text-secondary icon-md"></i>
                        @endif

                    </a>
                </div>
                <div class="col ps-0">
                    <a href="{{route('profile.show', Auth::user()->id)}}" class="text-decoration-none text-dark fw-bold mb-0">{{Auth::user()->name}}</a>
                    <p class="text-muted mb-0">{{Auth::user()->email}}</p>
                </div>
            </div>

            {{-- Suggested Users --}}
            SUGGESTIONS
        </div>
    </div>
@endsection
