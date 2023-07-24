{{-- Clickable image --}}
<div class="container p-0">
    <a href="{{route('post.show', $post->id)}}">
        <img src="{{$post->image}}" alt="post id {{$post->id}}" class="w-100">
    </a>
</div>
<div class="card-body">
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
    <a href="{{route('profile.show', $post->user->id)}}}" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
    &nbsp;
    <p class="d-inline fw-light">{{$post->description}}</p>
    <p class="text-uppercase text-muted small p-0">{{date('M d, Y', strtotime($post->created_at))}}</p>
    <p class="text-muted small p-0">Posted {{$post->created_at->diffForHumans()}}</p>

    {{-- Add comments --}}
    @if ($post->comments->isNotEmpty())
        <hr>
        <ul class="list-group">
            @foreach ($post->comments->take(3) as $comment)
                <li class="list-group-item border-0 p-0 mb-2">
                    <a href="#" class="text-decoration-none text-dark fw-bold">{{$comment->user->name}}</a>
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
                                    {{-- 4   -- boolean True--}}
            @if ($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0">
                    <a href="{{route('post.show', $post->id)}}" class="text-decoration-none small">View All {{$post->comments->count() }} comments</a>
                </li>
            @endif

        </ul>
    @endif
</div>
