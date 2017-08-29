
var SCApp = {
  ajaxSetup: function() {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    if (csrf_token) {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': csrf_token
          }
      });
    }
  }, 

  doAjaxAction: function(json) {
    if (json.message) {
      eModal.alert({
        'message': json.message, 
        'title' : "Error", 
        'buttons': false
      });
    }
    
    SCApp.ajaxReloadPage(json.action);
  }, 
  ajaxReloadPage: function(type) {
    if (type == 'reload') {
      SCApp.UI.reloadPage();
    }
    else if (type == 'reload_opener') {
      SCApp.UI.reloadPage('_opener');
    }
    else if (type == 'reload_parent') {
      SCApp.UI.reloadPage('_parent');
    }
  }
};

SCApp.UI = {
  reloadPage: function(target) {
    if (typeof target == 'undefined') {
      target = '_blank';
    }

    if (target == '_blank') {
      window.location.reload(true);
    } else if (target == '_opener') {
      window.opener.location.reload(true);
      window.close();
    } else if (target == '_parent') {
      parent.location.reload(true);
    }
  }, 
  modalIframe: function() {
    var $this = $(this);
    var url, title='', size='lg';
    url = $this.data('url');
    title = $this.data('title');

    if ($this.data('size')) {
      size = $this.data('size');
    }

    var options = {
      url: url, 
      title: title, 
      size: size, 
    };
    eModal.setModalOptions({backdrop: false, keyboard: false});
    var modal = eModal.iframe(options);
  }, 
  modalAjax: function() {
    var $this = $(this);
    var url, title='', size='lg';
    url = $this.data('url');
    title = $this.data('title');

    if ($this.data('size')) {
      size = $this.data('size');
    }

    var options = {
      url: url, 
      title: title, 
      size: size, 
      buttons: false, 
    };
    eModal.setModalOptions({backdrop: false, keyboard: false});
    var modal = eModal.ajax(options);
  },
  fitModalWindow: function() {
    var m_height = $('.modal-wrapper').height();
    var iframe = window.parent.$('.embed-responsive-item');
    if (iframe.length) {
      iframe.height(m_height);
    }
  }, 

  blockUI: function(selector) {
    $(selector).block({ 
      message: '<span class="fa fa-circle-o-notch fa-spin fa-3x text-primary"></span><div class="h4">Loading</div>', 
      css: { 
        border: 'none', 
        background: 'transparent', 
        opacity: 1, 
        color: '#fff' 
      }
    });
  }, 
  unblockUI: function(selector) {
      $(selector).unblock();
  }
};

SCApp.Photo = {
  removePhoto: function(action_url, data) {
    var $this = $(this);
    eModal.confirm('Are you sure to remove photo?', 'Remove Photo')
      .then(function() {
              SCApp.UI.blockUI('.photo-panel-section');
              SCApp.ajaxSetup();
              $.ajax({
                url: action_url,
                type: "POST",
                data: data,
              })
              .done(function( json, textStatus, jqXHR ) {
                SCApp.doAjaxAction(json); //Refresh
              })
              .always(function( data, textStatus, errorThrown ) {
                SCApp.UI.unblockUI('.photo-panel-section');
              });
            }, null);
  }
};

SCApp.Friend = {
  doAction: function(action_url, action_type) {
    SCApp.UI.blockUI('body');
    SCApp.ajaxSetup();
    $.ajax({
      url: action_url,
      type: "POST"
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json); //Refresh
    })
    .always(function( data, textStatus, errorThrown ) {
      SCApp.UI.unblockUI('body');
    });
  }
};

$(function () {
  "use strict";
  $(document).ready(function() {
    $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

    eModal.setEModalOptions({
        loadingHtml: '<div class="emodal-loading"><span class="fa fa-circle-o-notch fa-spin fa-3x text-primary"></span><div class="h4">Loading</div></div>',
    });
    $('.emodal-iframe').click(SCApp.UI.modalIframe);
    $('.emodal-ajax').click(SCApp.UI.modalAjax);
  });
});
