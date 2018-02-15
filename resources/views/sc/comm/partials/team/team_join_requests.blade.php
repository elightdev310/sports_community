<!-- Join Requests -->
<!-- TO DO: Change Peopele Actions -->
<div class="page-panel mt10">
  <div class="panel-header">
    <div class="panel-title">Join Requests</div>
  </div>
  <div class="panel-content">
    @if (count($requests))
      <div class="team-member-list people-list-section row no-margin">
      @foreach ($requests as $people) 
      <div class="col-md-6 no-padding">
        @include('sc.comm.partials.user.people_list_item')
      </div>
      @endforeach 
      </div>
    @else
      <div class="text-center p10">No member</div>
    @endif
  </div>
</div>
