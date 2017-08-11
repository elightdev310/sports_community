
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
    if (json.action == 'reload') {
      SCApp.UI.reloadPage();
    }
    else if (json.action == 'reload_opener') {
      SCApp.UI.reloadPage('_opener');
    }
    else if (json.action == 'reload_parent') {
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
      size: size
    };
    eModal.iframe(options);
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

$(function () {
  "use strict";
  $(document).ready(function() {
    eModal.setEModalOptions({
        loadingHtml: '<div class="emodal-loading"><span class="fa fa-circle-o-notch fa-spin fa-3x text-primary"></span><div class="h4">Loading</div></div>',
    });
    $('.emodal-iframe').click(SCApp.UI.modalIframe);
  });
});
