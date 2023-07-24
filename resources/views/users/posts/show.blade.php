@extends('layouts.app')

@section('title', 'Show Post')

<style>
    .col-4{
        overflow: scroll;
    }
    .card-body{
        position: absolute;
        top: 65px;
    }
</style>

@section('content')
    <div class="row border shadow">
        <div class="col p-0 border-end">
            <img src="{{$post->image}}" alt="post id {{$post->id}}" class="w-100">
        </div>
        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                <div class="card-header py-3 bg-white">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="{{route('profile.show', $post->user->id)}}">
                                @if ($post->user->avatar)
                                    <img src="{{$post->user->avatar}}" alt="{{$post->user->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0">
                            <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-secondary">{{$post->user->name}}</a>
                        </div>
                        <div class="col-auto">
                            @if (Auth::user()->id === $post->user->id)
                                <div class="dropdown">
                                    <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    {{-- If you are the OWNER of the post, you can edit or delete the post --}}
                                    <div class="dropdown-menu">
                                            <a href="{{route('post.edit', $post->id)}}" class="dropdown-item text-warning">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </a>
                                            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                                            <i class="fa-regular fa-trash-can"></i> Delete
                                            </button>
                                    </div>
                                        {{-- Insert a modal --}}
                                        @include('users.posts.contents.modals.delete')
                                </div>
                            @else
                                    {{-- If you are NOT the OWNER of the post, then show a Follow/Unfollow button. To be discussed later --}}
                                    {{-- Display a follow button for now --}}
                                    {{-- <div class="dropdown-menu"> --}}

                                        @if ($post->user->isFollowed())
                                            <form action="{{route('follow.destroy', $post->user->id)}}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-transparent p-0 text-secondary">Following</button>
                                            </form>
                                        @else
                                            <form action="{{route('follow.store', $post->user->id)}}" method="post" class="d-inline">
                                                @csrf
                                                <button type="submit" class="border-0 bg-transparent p-0 text-primary">Follow</button>
                                            </form>
                                        @endif

                                    {{-- </div> --}}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body w-100">
                    {{-- Heart button + no of likes a post has --}}
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if ($post->isLiked())
                                            <form action="{{route('like.destroy', $post->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-solid fa-heart text-danger"></i></button>
                                            </form>
                                        @else
                                                <form action="{{route('like.store', $post->id)}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-regular fa-heart"></i></button>
                                                </form>
                                        @endif
                                    </div>
                                    <div class="col-auto px-0">
                                        <span>{{$post->likes->count()}}</span>
                                    </div>
                                    <div class="col text-end">
                                        @foreach ($post->categoryPost as $category_post)
                                            <div class="badge bg-secondary bg-opacity-50">
                                                {{$category_post->category->name}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Display the name of the user who created the post + description --}}
                                <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
                                &nbsp;
                                <p class="d-inline fw-light">{{$post->description}}</p>
                                <p class="text-uppercase text-muted small p-0">{{date('M d, Y', strtotime($post->created_at))}}</p>
                                <p class="text-muted small p-0">Posted {{$post->created_at->diffForHumans()}}</p>

                                {{-- Add comments --}}
                                    <ul class="list-group">
                                        @foreach ($post->comments as $comment)
                                            <li class="list-group-item border-0 p-0 mb-2 ms-2">
                                                <a href="{{route('profile.show', $comment->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$comment->user->name}}</a>
                                                &nbsp;
                                                <p class="d-inline fw-light">{{$comment->body}}</p>

                                                <form action="{{route('comment.destroy', $comment->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <span class="text-uppercase text-muted small">{{ date('M d, Y', strtotime($comment->created_at))}}</span>

                                                    {{-- Show only the button to the owner of the comment --}}
                                                    @if (Auth::user()->id === $comment->user->id)
                                                        &middot;
                                                        <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                                                    @endif
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <form action="{{route('comment.store', $post->id)}}" method="post">
                                        @csrf
                                        <div class="input-group">
                                            <textarea name="comment_body{{$post->id}}" rows="1" class="form-control form-control-sm" placeholder="Add comment...">{{old('comment_body' . $post->id)}}</textarea>
                                            <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                                        </div>
                                        @error('comment_body' . $post->id)
                                            <p class="text-danger sm">{{$message}}</p>
                                        @enderror
                                    </form>


                            </div>
                        </div>
                    </div>
                </div>

@endsection
