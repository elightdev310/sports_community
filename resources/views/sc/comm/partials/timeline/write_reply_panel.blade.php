<form action="{{ route('timeline.post.comment.reply.post', ['comment'=>$comment->id]) }}" class="write-comment-reply-form post-form hidden">
  <div class="reply-box comment-box">
    <div class="author-photo">
      {!! SCUserLib::avatarImage($currentUser, 32) !!}
    </div>
    <div class="mentions-container">
      <div class="mentions-input">
        <textarea class="status-input-text" row="1" placeholder="Write a reply"></textarea>
      </div>
    </div>
    <div class="comment-area post-area clearfix">
      <div class="button-container pull-right">
        <a href="#" class="btn btn-primary btn-sm add-reply-btn">Reply</a>
      </div>
    </div>
  </div>
</form>
