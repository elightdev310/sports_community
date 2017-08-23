<div class="post-card-w-hint">
  <form action="{{ route('timeline.post.add.post', ['group'=>$node->id]) }}" class="add-post-form post-form">
    <div class="post-card">
      <div class="post-field">
        <div class="post-box">
          <div class="author-photo">
            {!! SCUserLib::avatarImage($currentUser, 32) !!}
          </div>
          <div class="mentions-container">
            <div class="mentions-input">
              <textarea class="status-input-text" row="1" placeholder="Write a post"></textarea>
            </div>
          </div>
          <div class="post-area clearfix">
            <div class="button-container pull-right">
              <a href="#" class="btn btn-primary btn-sm add-post-btn">Post</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
