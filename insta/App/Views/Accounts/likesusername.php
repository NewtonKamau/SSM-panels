{% extends "base.php" %}
{% block scriptContent %}
  	<script>
$(document).ready( function() {
    
  var activeId = 0;
  var tags = [];
  
  $('#overlay').addClass('hide');
    
  $(".content-scroll").niceScroll({
        cursorcolor:"#614385",
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
    
    var typeTag = $('#postTags').val();
    if(jQuery.inArray(typeTag, tags) == -1) {
      tags.push(typeTag);
    }
    $('.tags-elements').html('<ul class="tags-lists">'+add_tags_elements()+'</ul>');
    $('#postTags').val('');

  });
  
  $('#accountResults').on('click', '.close-tag', function() {
    var closeTag = $(this).attr('data-tag');

    tags = jQuery.grep(tags, function(value) {
      return value != closeTag;
    });
    $('.tags-elements').html('<ul class="tags-lists">'+add_tags_elements()+'</ul>');
    
  });
  
  $('#accountResults').on('click', '.schedule', function() {
    
    $('#overlay').removeClass('hide');
    
    var maxHour = $('#maxHour').val();
    var maxDay = $('#maxDay').val();
    var maxTotal = $('#maxTotal').val();
    
    $.post('{{ site_path }}/task/addtask', {"lists":tags,"action":"autolikeusername","accid":activeId,"delay":"1h","threads":maxHour,"max":maxDay,"job_max":maxTotal}, function(data) {
      
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
    $('#overlay').removeClass('hide');
    clearAsideLinks();
    
    var accId = $(this).attr('data-accid');
    activeId = accId;
    
    $(this).addClass('active');
    
    $.post('{{ site_path }}/accounts/loadaccount/likesusername', {"accid":accId}, function(data) {
      $('#accountResults').html(data);
      $('#overlay').addClass('hide');
    });
    
  });
  
  $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    
  function add_tags_elements() {
    var html = '';
    $.each(tags, function( index, value ) {
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
          <li data-type="accounts" data-sidebar="likes" data-icons="likes" title="Likes" data-tooltip-content="#tooltip_content_likes" class="sidebar-link content-tooltip-likes active"></li>
          <li data-type="accounts" data-sidebar="comments" data-icons="comments" title="Get Comments" class="sidebar-link title-tooltip"></li>
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
            <li class="active"><a href="{{ site_path }}/accounts/likes/username">Auto Like by Username</a></li>
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
      <h1 class="topbar-title">Auto Likes by Username</h1>
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
                        <p>Please select an account from left side list to follow.</p>
                    </div>
                </section>
  </div>
</div>
{% endblock %}
