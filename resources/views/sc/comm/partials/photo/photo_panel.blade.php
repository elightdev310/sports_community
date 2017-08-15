<div class="photo-panel-section row">
  @if (count($photos))
    @foreach ($photos as $photo)
    <div class="image-item col-xs-6 col-sm-4 col-md-3 col-lg-2">
      <div class="image-content hover-pane" data-photo="{{ $photo->id }} ">
        <a class="fm_file_sel info" href="{{ $photo->file->path() }}" title="{{ $photo->file->name }}" data-gallery="#profile-photo" 
        data-toggle="tooltip" data-placement="top" title="" upload="" data-original-title="{{ $photo->file->name }}">
          <img src="{{ $photo->file->path() }}?s=300" width="100%"/>
        </a>
        <a class="photo-action-link hover-action-link">
          <i class="fa fa-trash-o" aria-hidden="true"></i>
        </a>
      </div>
    </div>
    @endforeach 

    <div id="blueimp-gallery" class="blueimp-gallery">
      <div class="slides"></div>
      <h3 class="title"></h3>
      <a class="prev">‹</a>
      <a class="next">›</a>
      <a class="close">×</a>
      <a class="play-pause"></a>
      <ol class="indicator"></ol>
    </div>
  @else
    <div class="text-center p20">
      <span>No Image</span>
    </div>
  @endif
</div>


@push('styles')
<link href="{{ asset('assets/plugins/blueimp-gallery/css/blueimp-gallery.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/blueimp-gallery/css/blueimp-gallery-indicator.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/blueimp-gallery/js/blueimp-helper.js') }}"></script>
<script src="{{ asset('assets/plugins/blueimp-gallery/js/blueimp-gallery.js') }}"></script>
<script src="{{ asset('assets/plugins/blueimp-gallery/js/blueimp-gallery-fullscreen.js') }}"></script>
<script src="{{ asset('assets/plugins/blueimp-gallery/js/blueimp-gallery-indicator.js') }}"></script>
<script src="{{ asset('assets/plugins/blueimp-gallery/js/jquery.blueimp-gallery.js') }}"></script>
@endpush
