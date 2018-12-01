{% extends "base.php" %}
{% block scriptContent %}
  	<script>
$(document).ready( function() {
    
  $('#overlay').addClass('hide');
  
  $(".sidebar-scroll").niceScroll({
        cursorcolor:"#c7c9c9",
        cursorwidth:"9px",
        autohidemode: "cursor"
    });
    
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
  
  $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    
  $('.sidebar-link').on('click', function() {
    var destination = $(this).attr('data-sidebar');
    var type = $(this).attr('data-type');

    if(destination != 'follows' && destination != 'likes') {
      window.location.replace("{{ site_path }}/"+type+"/"+destination);
    }
    
  });
    
  function clearNortification() {
    
      $('#notificationPanel').removeClass();
      $('#notificationPanel').html();
      $('#notificationPanel').text("");
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
          <li data-type="accounts" data-sidebar="index" data-icons="insta" title="Accounts" class="sidebar-link title-tooltip active"></li>
          <li data-type="accounts" data-sidebar="post" data-icons="schedule" title="Auto Posting" class="sidebar-link title-tooltip"></li>
          <li data-type="accounts" data-sidebar="likes" data-icons="likes" title="Likes" data-tooltip-content="#tooltip_content_likes" class="sidebar-link content-tooltip-likes"></li>
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
      <h1 class="topbar-title">Saved Accounts</h1>
      <a class="topbar-special-link" href="{{ site_path }}/accounts/new">
          <img src="{{ site_path }}/img/icons/s_follower_blue.png" class="mr-1" />New Account</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
        </ul>
        <a class="nav-link" href="{{ site_path }}/users/logout"><i class="fa fa-sign-out"></i></a>
      </div>
    </nav>
  <div class="content">
        {% if errors is not empty %}
        <div id="notificationPanel">
          {% for err in errors %}
          <div class="alert bg-danger">{{ err }}</div>
          {% endfor %}
        </div>
        {% endif %}
        <div class="row content">
          {% if accounts is empty %}
            <div class="no-data">
              <p>You haven't add any Instagram account yet. Click the button below to add your first account.</p>
              <a class="small button" href="{{ site_path }}/accounts/new"><img src="{{ site_path }}/img/icons/s_follower.png" class="mr-1" />
                  New Account                                
              </a>
            </div>
          {% else %}
          {% for account in accounts %}
            <div class="col-md-3 account-holder">
              <div class="account-container">
                <ul>
                  <li><img src="{{ account.account_profile }}" width="90px" class="rounded-circle" alt="Cinque Terre" /></li>
                  <li>{{ account.account_username }}</li>
                  <li class="sub">Added on {{ account.account_added }}</li>
                </ul>
              </div>
              <div class="account-button-container">
                <a href="https://instagram.com/{{ account.account_username }}" target="_blank" class="sub">VIEW ON TIMELINE</a>
              </div>
            </div>
          {% endfor %}
          {% endif %}
        </div>
  </div>
</div>
{% endblock %}
