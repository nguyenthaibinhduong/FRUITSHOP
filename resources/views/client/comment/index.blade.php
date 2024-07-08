@php
    use Carbon\Carbon;
@endphp
@foreach($comments as $comment)
<div class="comment-box d-flex ">
        <div class="comment-avatar ">
            @if($comment->user->image_url!=null)
            <img src="{{ asset($comment->user->image_url) }}" alt="User Avatar">
            @else
            <img src="https://avatar.iran.liara.run/public/boy" alt="User Avatar">   
            @endif
        </div>
        <div id="comment_{{ $comment->id }}" class="comment-content">
            <small><b>{{  $comment->user->name }}</b> - {{ $comment->updated_at->format('d/m/Y') }}</small>
            <p>{{ $comment->body }}</p>    
        </div>
        <div class="d-flex p-0">
        @if (Auth::check() && Auth::id() == $comment->user_id)
        <button class="btn btn-link text-dark edit-comment" data-id="{{ $comment->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
        <button class="btn btn-link text-dark delete-comment" data-id="{{ $comment->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        @endif
</div>
</div>

@endforeach