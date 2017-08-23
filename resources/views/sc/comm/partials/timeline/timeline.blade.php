<div class="timeline-section">
  @if ($editable)
  @include('sc.comm.partials.timeline.add_post_panel')
  @endif

  <!-- Post Card List -->
  @if (!empty($posts))
  <div class="post-list">
    @foreach ($posts as $post_v)
    <?php $post = $post_v['post']; ?>
    <?php $comments = $post_v['comments']; ?>
      <div class="post-card-item" data-pid="{{ $post->id }}">
        @include('sc.comm.partials.timeline.post_card')
      </div>
    @endforeach
  </div>
  @endif

</div>




@push('scripts')
<script>
$(function() {
  $(document).ready(function() {
    SCApp.Post.timelineInit();
  });
});
</script>
@endpush
