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

    $('.timeline-section').on('click', '.show-all-comments', SCApp.Post.showAllComments);
    $('.timeline-section').on('click', '.show-all-replies', SCApp.Post.showAllReplies);

    // Load first feed page
    SCApp.Post.loadNextPosts(0, 'start');
    // Infinite Scroll
    $(window).scroll(function() {
        if (Math.ceil($(window).scrollTop()) >= $(document).height() - $(window).height()) {
            var _page = $('.timeline-section .post-list').attr('data-page');
            SCApp.Post.loadNextPosts(_page);
        }
    });

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
    // Show all replies
    $comment_card.find('.show-all-replies').each(function() {
      $(this).trigger('click');
    })
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
  }, 
  // Show all comments
  showAllComments: function() {
    var $list = $(this).closest('.comment-list');
    $list.find('.comment-box.hidden-comment').each(function() {
        $(this).removeClass('hidden-comment');
    });

    $(this).closest('.comment-box').remove();
    return false;
  }, 
  // Show all replies
  showAllReplies: function() {
    var $list = $(this).closest('.comment-replies-section').find('.reply-list');
    $list.removeClass('hidden-reply-list');

    $(this).closest('.reply-summary-box').remove();
    return false;
  }, 

  loadNextPosts: function(page, start='next') {
    var $section = $('.timeline-section .post-list');
    if (start == 'start') {
        $section.attr('data-page', 0);
        $section.removeClass('loading-end');
        $section.html('');
    }
    if ($section.hasClass("loading-posts") || $section.hasClass('loading-end')) {
        return;
    }

    var _url  = $section.data('url');
    SCApp.ajaxSetup();
    $.ajax({
        url:    _url,
        type:   'POST',
        data:   {page: page}, 
        beforeSend: function(jqXHR, settings) {
            $section.addClass("loading-posts");
            $section.append($('<div class="next-page-loading"></div>'));
            SCApp.UI.blockUI($section.find('.next-page-loading'));
        },
        error: function() {},
        success: function(json) {
            setTimeout(function(){
                $section.removeClass("loading-posts");
                SCApp.UI.unblockUI($section.find('.next-page-loading'));
                $section.find('.next-page-loading').remove();

                if (json.status == "success") {
                    if (page == 0) {
                        $section.html($(json.posts).hide().fadeIn(300));
                    } else {
                        $section.append($(json.posts).hide().fadeIn(300));
                    }
                    var prevPage = $section.attr('data-page');
                    if (prevPage == json.nextPage) {
                        $section.addClass('loading-end');
                    } else {
                        $section.attr('data-page', json.nextPage);
                    }

                    if (!SCApp.UI.checkScrollBar()) {
                      var _page = $section.attr('data-page');
                      SCApp.Post.loadNextPosts(_page);
                    }
                } else {
                    if (json.msg != "") { alert(json.msg); }
                }
            }, 300);
        }, 
        complete: function(jqXHR, textStatus) {}
    }); 
  },
};
