<form action="{{ route('timeline.post.comment.add.post', ['post'=>$post->id]) }}" class="write-comment-form post-form">
  <div class="comment-box">
    <div class="author-photo">
      {!! SCUserLib::avatarImage($currentUser, 32) !!}
    </div>
    <div class="mentions-container">
      <div class="mentions-input">
        <textarea class="status-input-text" row="1" placeholder="Write a comment"></textarea>
      </div>
    </div>
    <div class="comment-area post-area clearfix">
      <div class="button-container pull-right">
        <a href="#" class="btn btn-primary btn-sm add-comment-btn">Write</a>
      </div>
    </div>
  </div>
</form>
