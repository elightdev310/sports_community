<div class="timeline-section">
  @if (isset($postable) && !empty($postable))
  @include('sc.comm.partials.timeline.add_post_panel')
  @endif

  <!-- Post Card List -->
  <div class="post-list" data-page="0" data-url="{{ $posts_url or '' }}">
    <!-- loading the posts -->
  </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/sc-post.js') }}" type="text/javascript"></script>
<script>
$(function() {
  $(document).ready(function() {
    SCApp.Post.timelineInit();
  });
});
</script>
@endpush
