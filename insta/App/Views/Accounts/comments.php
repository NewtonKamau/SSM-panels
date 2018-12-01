{% extends "base.php" %}
{% block scriptContent %}
  	<script>
$(document).ready( function() {
    
  var activeId = 0;
  var comments = [];
  var posts = [];
  
  $('#overlay').addClass('hide');

  $(".sidebar-scroll").niceScroll({
        cursorcolor:"#c7c9c9",
        cursorwidth:"9px",
        autohidemode: "cursor"
    });
    
  $("#accountResults").niceScroll({
        cursorcolor:"#3b7cff",
        cursorwidth:"9px",
        autohidemode: "cursor"
  });
  
  style_sidebar();
  
  $('.title-tooltip').tooltipster({
    theme: 'tooltipster-borderless',
    animation: 'fade',
    delay: 200,
    side: 'right'
  });
  
  $('.content-tooltip').tooltipster({
    content: $('#tooltip_content'),
    theme: 'tooltipster-custom',
    // if you use a single element as content for several tooltips, set this option to true
    contentCloning: false,
    interactive: true,
    delay: 200,
    side: 'right'
  });
  
  $('.content-tooltip-likes').tooltipster({
    content: $('#tooltip_content_likes'),
    theme: 'tooltipster-custom',
    // if you use a single element as content for several tooltips, set this option to true
    contentCloning: false,
    interactive: true,
    delay: 200,
    side: 'right'
  });

  
  $('#accountResults').on('click', '.load-button', function() {
    $('#overlay').removeClass('hide');
    var postUrl = $('#postLink').val();

    $.post('{{ site_path }}/accounts/loadpost', {'post_url':postUrl, 'accid':activeId}, function(data) {
      
      var postData = $.parseJSON(data);
      posts.push(postData.p_id);
      
      $('.form-result').html('<div class="row m-0 p-0"><div class="col-md-4"><img src="'+postData.p_img+'" width="250px" /></div><div class="col-md-8"><ul class="field-data"><li><strong>Title : </strong>'+postData.p_title+'</li><li><strong>Likes : </strong>'+postData.p_likes+'</li><li><strong>Comments : </strong>'+postData.p_comments+'</li><li><strong>Post ID : </strong>'+postData.p_id+'</li></ul></div></div>');
      $('#overlay').addClass('hide');
    });
    content_rescroll();
    
  });
  
  $('#accountResults').on('click', '.load-comments', function() {
    
    var typeComment = $('#postComments').val();
    if(jQuery.inArray(typeComment, comments) == -1) {
      comments.push(typeComment);
    }
    $('.tags-elements').html('<ul class="tags-lists">'+add_comments_elements()+'</ul>');
    $('#postComments').val('');
    content_rescroll();
    
  });
  
  $('#accountResults').on('click', '.close-tag', function() {
    var closeTag = $(this).attr('data-tag');

    comments = jQuery.grep(comments, function(value) {
      return value != closeTag;
    });
    $('.tags-elements').html('<ul class="tags-lists">'+add_comments_elements()+'</ul>');
    
  });
  
  $('#accountResults').on('click', '.schedule', function() {
    
    $('#overlay').removeClass('hide');
    
    var maxHour = '20';
    var maxDay = '150';
    var maxTotal = $('#maxTotal').val();
    var category = $('#instaCat').val();
    
    $.post('{{ site_path }}/task/addtask', {"lists":posts, "message":comments,"category":category,"action":"getcomments","accid":activeId,"delay":"1h","threads":maxHour,"max":maxDay,"job_max":maxTotal}, function(data) {
      
      if(data == 'success') {
        	$('#notificationPanel').html('<div class="alert bg-success text-white">Your action has been scheduled !</div>');
        	$('#overlay').addClass('hide');
          setTimeout(function() {
             clearNortification().delay(800).fadeOut( 400 );
          }, 5000);
      }
      
    });
    
  });
  
  $('.sidebar-link').on('click', function() {
    var destination = $(this).attr('data-sidebar');
    var type = $(this).attr('data-type');
    
    if(destination != 'follows' && destination != 'likes') {
      window.location.replace("{{ site_path }}/"+type+"/"+destination);
    }
    
  });
  
  $('.aside-list-item').on('click', function() {
    
    clearAsideLinks()
    
    var accId = $(this).attr('data-accid');
    activeId = accId;
    
    $(this).addClass('active');
    
    $.post('{{ site_path }}/accounts/loadaccount/comments', {"accid":accId}, function(data) {
      $('#accountResults').html(data);
    });
    
  });
  
  $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    
  function add_comments_elements() {
    var html = '';
    $.each(comments, function( index, value ) {
      html += '<li>'+value+'<img src="{{ site_path }}/img/icons/close.png" class="ml-2 close-tag" data-tag="'+value+'"/></li>';
    });
    return html;
    
  }
    
  function clearNortification() {
    
      $('#notificationPanel').removeClass();
      $('#notificationPanel').html();
      $('#notificationPanel').text("");
  }
  
  function clearAsideLinks() {
    $('.aside-list-item').each(function(i, obj) {
      $(this).removeClass('active');
    });
  }
  
  function style_sidebar() {
      
    $('.sidebar-link').each(function(i, obj) {
        var ico = $(this).attr('data-icons');
        if($(this).hasClass('active')) {
            $(this).css({"background": "url({{ site_path }}/img/icons/"+ico+"_blue.png) no-repeat scroll", "background-position": "20px"})
        } else {
            $(this).css({"background": "url({{ site_path }}/img/icons/"+ico+".png) no-repeat scroll", "background-position": "20px"})
        }
    });   
      
  }
  
  function content_rescroll() {
    
    $("#accountResults").getNiceScroll().resize();
    
  }

});
  	</script>
{% endblock %}
{% block aside %}
  <nav class="sidebar-scroll" id="sidebar">
    <div class="hor-menu">
        <span class="main-nav ml-2 mt-2"><img src="{{ site_path }}/img/logo.png" /></span>
        <ul class="mt-3 mb-5">
          <li data-type="accounts" data-sidebar="index" data-icons="insta" title="Accounts" class="sidebar-link title-tooltip"></li>
          <li data-type="accounts" data-sidebar="post" data-icons="schedule" title="Auto Posting" class="sidebar-link title-tooltip"></li>
          <li data-type="accounts" data-sidebar="likes" data-icons="likes" title="Likes" data-tooltip-content="#tooltip_content_likes" class="sidebar-link content-tooltip-likes"></li>
          <li data-type="accounts" data-sidebar="comments" data-icons="comments" title="Get Comments" class="sidebar-link title-tooltip active"></li>
          <li data-type="accounts" data-sidebar="follows" data-icons="follows" title="Auto Follows" data-tooltip-content="#tooltip_content" class="sidebar-link content-tooltip"></li>
          <li data-type="accounts" data-sidebar="unfollows" data-icons="unfollows" title="Auto Unfollow" class="sidebar-link title-tooltip"></li>
          <li data-type="accounts" data-sidebar="direct" data-icons="messages" title="Direct Message" class="sidebar-link title-tooltip"></li>
          <hr>
          <li data-type="task" data-sidebar="list" data-icons="statistics" title="Tasks Progress" class="sidebar-link title-tooltip"></li>
        </ul>
    </div>
    
  </nav>
  
  <div class="tooltip_templates">
      <div id="tooltip_content">
        <div class="sidebar-sub-links">
          <ul>
            <li><a href="{{ site_path }}/accounts/follows/username">Autofollow by Username</a></li>
            <li><a href="{{ site_path }}/accounts/follows/location">Autofollow by Location</a></li>
            <li><a href="{{ site_path }}/accounts/follows/hashtags">Autofollow by Hashtags</a></li>
          </ul>
        </div>
      </div>
      <div id="tooltip_content_likes">
        <div class="sidebar-sub-links">
          <ul>
            <li><a href="{{ site_path }}/accounts/likes/getlikes">Get Likes</a></li>
            <li><a href="{{ site_path }}/accounts/likes/username">Auto Like by Username</a></li>
            <li><a href="{{ site_path }}/accounts/likes/location">Auto Like by Location</a></li>
            <li><a href="{{ site_path }}/accounts/likes/hashtags">Auto Like by Hashtags</a></li>
          </ul>
        </div>
      </div>
  </div>
{% endblock %}
{% block content %}
<div class="content-scroll" id="content" style="width:100%;">
  <nav id="topNav" class="navbar navbar-expand-md navbar-light">
      <h1 class="topbar-title">Get Comments</h1>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto"></ul>
        <a class="nav-link" href="{{ site_path }}/users/logout"><i class="fa fa-sign-out"></i></a>
      </div>
    </nav>
  <div class="clearfix">
        <div id="notificationPanel"></div>
        <aside class="skeleton-aside" style="height: 550px;">
                <div class="aside-list js-loadmore-content" data-loadmore-id="1">
                {% for acc in accounts %}
                    <div data-accid="{{ acc.id }}" class="aside-list-item js-list-item ">
                       <div class="clearfix">
                            <span class="circle"><img src="{{ acc.account_profile }}" width="40px" class="rounded-circle"></span>
                            <div class="inner">
                                <div class="title">{{ acc.account_username }}</div>
                                <div class="sub">Level {{ acc.account_level }}</div>
                            </div>
                        <a class="full-link js-ajaxload-content" href="#"></a>
                        </div>
                    </div>
                {% endfor %}
                </div>
                </aside>
                <section id="accountResults" class="skeleton-content hide-on-medium-and-down" style="height: 550px;">
                    <div class="no-data">
                        <span class="no-data-icon sli sli-drawer"></span>
                        <p>Please select an account from left side list to add new post links.</p>
                    </div>
                </section>
  </div>
</div>
{% endblock %}
