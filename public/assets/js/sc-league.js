var SCApp = SCApp || {};

SCApp.League = {
  bindLeagueList: function() {
    $('.league-list-section').on('click', '.btn-league-join', function() {
      var $btn = $(this);
      var $item= $(this).closest('.league-item');
      var league_id = $item.data('league');
      var action = '';
  
      if ($item.hasClass('status-send')) {
        action = 'cancel'; 
      } else {
        action = 'send';
      }
  
      SCApp.UI.blockUI($item);
      SCApp.ajaxSetup();
      $.ajax({
        url: "/leagues/"+league_id+"/member-relationship",
        type: "POST",
        data: {'action':action},
      })
      .done(function( json, textStatus, jqXHR ) {
        SCApp.doAjaxAction(json);
        if (json.status == 'success') {
          if (action == 'send') {
            $item.addClass('status-send');
            $btn.html('Request Sent');
          } else if (action == 'cancel') {
            $item.removeClass('status-send');
            $btn.html('Join');
          }
        }
      })
      .always(function( data, textStatus, errorThrown ) {
        SCApp.UI.unblockUI($item);
      });
    });
  
    $('.league-list-section').on('click', '.btn-leave-league', function() {
      var $btn = $(this);
      var $item= $(this).closest('.league-item');
      var league_id = $item.data('league');
      var action = 'leave';
  
      eModal.confirm('Are you sure to leave league?', 'Leave League')
        .then(function() {
          SCApp.UI.blockUI('body');
          SCApp.ajaxSetup();
          $.ajax({
            url: "/leagues/"+league_id+"/member-relationship",
            type: "POST",
            data: {'action':action},
          })
          .done(function( json, textStatus, jqXHR ) {
            SCApp.doAjaxAction(json); //Refresh
          })
          .always(function( data, textStatus, errorThrown ) {
            SCApp.UI.unblockUI('body');
          });
        });
    });
  }
};

///////////////////////////////////////////////////////////////////////////////

SCApp.Team = {
  bindTeamList: function() {
    $('.team-list-section').on('click', '.btn-team-join', function() {
      var $btn = $(this);
      var $item= $(this).closest('.team-item');
      var team_id = $item.data('team');
      var action = '';
  
      if ($item.hasClass('status-send')) {
        action = 'cancel'; 
      } else {
        action = 'send';
      }
  
      SCApp.UI.blockUI($item);
      SCApp.ajaxSetup();
      $.ajax({
        url: "/teams/"+team_id+"/member-relationship",
        type: "POST",
        data: {'action':action},
      })
      .done(function( json, textStatus, jqXHR ) {
        SCApp.doAjaxAction(json);
        if (json.status == 'success') {
          if (action == 'send') {
            $item.addClass('status-send');
            $btn.html('Request Sent');
          } else if (action == 'cancel') {
            $item.removeClass('status-send');
            $btn.html('Join');
          }
        }
      })
      .always(function( data, textStatus, errorThrown ) {
        SCApp.UI.unblockUI($item);
      });
    });
  
    $('.team-list-section').on('click', '.btn-leave-team', function() {
      var $btn = $(this);
      var $item= $(this).closest('.team-item');
      var team_id = $item.data('team');
      var action = 'leave';
  
      eModal.confirm('Are you sure to leave team?', 'Leave Team')
        .then(function() {
          SCApp.UI.blockUI('body');
          SCApp.ajaxSetup();
          $.ajax({
            url: "/teams/"+team_id+"/member-relationship",
            type: "POST",
            data: {'action':action},
          })
          .done(function( json, textStatus, jqXHR ) {
            SCApp.doAjaxAction(json); //Refresh
          })
          .always(function( data, textStatus, errorThrown ) {
            SCApp.UI.unblockUI('body');
          });
        });
    });
  },
  bindTeamLeagueList: function() {
    $('.league-list-section').on('click', '.btn-league-join', function() {
      var team_slug = $('.league-list-section').data('teamslug');

      var $btn = $(this);
      var $item= $(this).closest('.league-item');
      var league_id = $item.data('league');
      
      var action = '';
  
      if ($item.hasClass('status-send')) {
        action = 'cancel'; 
      } else {
        action = 'send';
      }
  
      SCApp.UI.blockUI($item);
      SCApp.ajaxSetup();
      $.ajax({
        url: "/teams/"+team_slug+"/leagues/"+league_id+"/relationship",
        type: "POST",
        data: {'action':action},
      })
      .done(function( json, textStatus, jqXHR ) {
        SCApp.doAjaxAction(json);
        if (json.status == 'success') {
          if (action == 'send') {
            $item.addClass('status-send');
            $btn.html('Request Sent');
          } else if (action == 'cancel') {
            $item.removeClass('status-send');
            $btn.html('Join');
          }
        }
      })
      .always(function( data, textStatus, errorThrown ) {
        SCApp.UI.unblockUI($item);
      });
    });
  
    $('.league-list-section').on('click', '.btn-leave-league', function() {
      var team_slug = $('.league-list-section').data('teamslug');

      var $btn = $(this);
      var $item= $(this).closest('.league-item');
      var league_id = $item.data('league');
      var action = 'leave';
  
      eModal.confirm('Are you sure to leave league?', 'Leave League')
        .then(function() {
          SCApp.UI.blockUI('body');
          SCApp.ajaxSetup();
          $.ajax({
            url: "/teams/"+team_slug+"/leagues/"+league_id+"/relationship",
            type: "POST",
            data: {'action':action},
          })
          .done(function( json, textStatus, jqXHR ) {
            SCApp.doAjaxAction(json); //Refresh
          })
          .always(function( data, textStatus, errorThrown ) {
            SCApp.UI.unblockUI('body');
          });
        });
    });
  }
};


SCApp.Season = {
  bindDivisionTeamList: function() {
    $('.division-team-list-section').on('click', '.btn-join-season, .btn-cancel-request, .btn-allow-request, .btn-reject-request', function() {
      var $btn = $(this);
      var $item= $(this).closest('.dt-item');
      var url = $btn.data('url');
      var action = 'send';
      if ($btn.hasClass('btn-cancel-request')) {
        action = 'cancel';
      } else if ($btn.hasClass('btn-allow-request')) {
        action = 'allow';
      } else if ($btn.hasClass('btn-reject-request')) {
        action = 'reject';
      }

      SCApp.UI.blockUI($item);
      SCApp.ajaxSetup();
      $.ajax({
        url: url,
        type: "POST",
        data: {'action':action},
      })
      .done(function( json, textStatus, jqXHR ) {
        SCApp.doAjaxAction(json);
      })
      .always(function( data, textStatus, errorThrown ) {
        //SCApp.UI.unblockUI($item);
      });
    });

    $('.division-team-list-section').on('click', '.btn-leave-season', function() {
      var $btn = $(this);
      var $item= $(this).closest('.dt-item');
      var url = $btn.data('url');
      var action = 'leave';
  
      eModal.confirm('Are you sure to leave season?', 'Leave Season')
        .then(function() {
          SCApp.UI.blockUI($item);
          SCApp.ajaxSetup();
          $.ajax({
            url: url,
            type: "POST",
            data: {'action':action},
          })
          .done(function( json, textStatus, jqXHR ) {
            SCApp.doAjaxAction(json); //Refresh
          })
          .always(function( data, textStatus, errorThrown ) {
            SCApp.UI.unblockUI($item);
          });
        });
    });
  }
};