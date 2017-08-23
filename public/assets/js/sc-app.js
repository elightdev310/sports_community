
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

SCApp.Post = {
  timelineInit: function() {
    $('.timeline-section').on('keyup', 'textarea.status-input-text', function() {
      SCApp.Post.textAreaAdjust(this);
    });
    $('.timeline-section').on('click', '.add-post-btn', SCApp.Post.addPost);
    $('.timeline-section').on('click', '.add-comment-btn', SCApp.Post.addComment);
    $('.timeline-section').on('click', '.add-reply-btn', SCApp.Post.addComment);
    $('.timeline-section').on('click', '.add-comment-link', SCApp.Post.focusCommentAdd);
    $('.timeline-section').on('click', '.comment-reply-link', SCApp.Post.focusCommentReply);
  }, 
  textAreaAdjust: function(o) {
    o.style.height = "1px";
    o.style.height = (0+o.scrollHeight)+"px";
  }, 
  getFormData: function($form) {
    var status = $form.find('.status-input-text').val();

    if (status == '') {
      return false;
    }

    return {
      'status': status
    };
  }, 
  addPost: function() {
    var $form = $(this).closest('form.post-form');
    var _url = $form.attr('action');
    var data = SCApp.Post.getFormData($form);
    if (data == false) { return false; }

    SCApp.ajaxSetup();
    $.ajax({
      url: _url,
      type: "POST",
      data: data,
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json); //Refresh
    })
    .always(function( data, textStatus, errorThrown ) {});

    return false;
  }, 
  addComment: function() {
    var $form = $(this).closest('form.post-form');
    var _url = $form.attr('action');
    var data = SCApp.Post.getFormData($form);
    if (data == false) { return false; }

    SCApp.ajaxSetup();
    $.ajax({
      url: _url,
      type: "POST",
      data: data,
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json); //Refresh
      var $post_card_item = $form.closest('.post-card-item');
      SCApp.Post.refreshPostCard($post_card_item);
    })
    .always(function( data, textStatus, errorThrown ) {});

    return false;
  }, 
  focusCommentAdd: function() {
    var $comment_card = $(this).closest('.post-card-item');
    var $txtInput = $comment_card.find('.write-comment-form')
                 .removeClass('hidden')
                 .find('.status-input-text').focus();
    // $('body').scrollTo($txtInput, 300, {
    //   offset: function() { return {top: -100, left: 0}; }, 
    //   onAfter: function() {
    //     $txtInput.focus();
    //   }
    // });
    return false;
  }, 
  focusCommentReply: function() {
    var $comment_card = $(this).closest('.comment-card-item');
    var $txtInput = $comment_card.find('.write-comment-reply-form')
                 .removeClass('hidden')
                 .find('.status-input-text').focus();
    // $('body').scrollTo($txtInput, 300, {
    //   offset: function() { return {top: -100, left: 0}; }, 
    //   onAfter: function() {
    //     $txtInput.focus();
    //   }
    // });
    return false;
  }, 
  refreshPostCard: function($post_card_item) {
    var post_id = $post_card_item.data('pid');
    var _url = '/timeline/post/'+ post_id + '/refresh';
    SCApp.ajaxSetup();
    $.ajax({
      url: _url,
      type: "GET",
    })
    .done(function( json, textStatus, jqXHR ) {
      SCApp.doAjaxAction(json); //Refresh
      if (json.status == 'success') {
        $post_card_item.html(json.post_card);
      }
    })
    .always(function( data, textStatus, errorThrown ) {});
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
