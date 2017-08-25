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
