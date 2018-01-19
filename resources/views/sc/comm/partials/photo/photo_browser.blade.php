<div class="photo-panel-section row">
  @if (count($photos))
    @foreach ($photos as $photo)
    <div class="image-item col-xs-3">
      <div class="image-content hover-pane" data-photo="{{ $photo->id }}" data-url="{{ $photo->path() }}">
        <img src="{{ $photo->path(400) }}" width="100%"/>
      </div>
    </div>
    @endforeach 
  @else
    <div class="text-center p20">
      
    </div>
  @endif
</div>
