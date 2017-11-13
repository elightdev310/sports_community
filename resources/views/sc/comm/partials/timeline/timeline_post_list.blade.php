@if (isset($posts) && !empty($posts))
@foreach ($posts as $post_v)
    <?php $post = $post_v['post']; ?>
    <?php $comments = $post_v['comments']; ?>
    <div class="post-card-item" data-pid="{{ $post->id }}">
        @include('sc.comm.partials.timeline.post_card')
    </div>
@endforeach
@endif
