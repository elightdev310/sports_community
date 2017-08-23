<div class="post-card">
  <div class="post-field">
    <div class="post-box">
      <div class="author-photo">
        {!! SCUserLib::avatarImage($currentUser, 32) !!}
      </div>
      <div class="mentions-container">
        <div class="">
          <span class="author-name">{{ $post->author->name }}</span> - 
          <span class="post-date">{{ SCHelper::strDTime($post->created_at) }}</span>
        </div>
        <div class="post-content card-content">
          <div class="post-status">{{ $post->text }}</div>
        </div>
        <div class="comment-link">
          <a href='#' class="add-comment-link">Comment</a>
        </div>
      </div>
    </div>
  </div>
  <div class="post-field comment-section">
    @if (!empty($comments))
    <div class="comment-list">
      @foreach ($comments as $comment_v)
        <?php $comment = $comment_v['comment']; ?>
        <?php $replies = $comment_v['replies']; ?>
        @include('sc.comm.partials.timeline.comment_card')
      @endforeach
    </div>
    @endif

    @include('sc.comm.partials.timeline.write_comment_panel')
  </div>
</div>
