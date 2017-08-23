<div class="comment-box comment-card-item">
  <div class="author-photo">
    {!! SCUserLib::avatarImage($currentUser, 32) !!}
  </div>
  <div class="mentions-container">
    <div class="">
      <span class="author-name">{{ $comment->author->name }}</span> - 
      <span class="comment-date">{{ SCHelper::strDTime($comment->created_at) }}</span>
    </div>
    <div class="comment-content card-content">
      <div class="comment-status">{{ $comment->text }}</div>
    </div>
    <div class="comment-reply">
      <a href='#' class="comment-reply-link">Reply</a>
    </div>
  </div>

  <div class="comment-replies-section">
    @if (!empty($replies))
    <div class="reply-list">
      @foreach ($replies as $reply)
        <div class="reply-box comment-box comment-reply-item">
          <div class="author-photo">
            {!! SCUserLib::avatarImage($currentUser, 32) !!}
          </div>
          <div class="mentions-container">
            <div class="">
              <span class="author-name">{{ $reply->author->name }}</span> - 
              <span class="comment-date">{{ SCHelper::strDTime($reply->created_at) }}</span>
            </div>
            <div class="comment-content card-content">
              <div class="comment-status">{{ $reply->text }}</div>
            </div>
            <div class="comment-reply">
              <a href='#' class="comment-reply-link">Reply</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    @endif

    @include('sc.comm.partials.timeline.write_reply_panel')
    
  </div>
</div>
