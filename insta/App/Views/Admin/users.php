{% extends "base.php" %}
{% block scriptContent %}
  	<script>
$(document).ready( function() {
    
  var activeId = 0;
  var posts = [];
  
  $('#overlay').addClass('hide');
    
  $("#accountResults").niceScroll({
        cursorcolor:"#3b7cff",
        cursorwidth:"9px",
        autohidemode: "cursor"
  });
  
  style_sidebar();
  
  $('.sidebar-link').tooltipster({
    theme: 'tooltipster-borderless',
    animation: 'fade',
    delay: 200,
    side: 'right'
  });
  
  $('#accountResults').on('click', '.schedule', function() {
    
    $('#overlay').removeClass('hide');
    
    var maxHour = '20';
    var maxDay = '150';
    var maxTotal = $('#maxTotal').val();
    var category = $('#instaCat').val();
    
    $.post('{{ site_path }}/task/addtask', {"lists":posts, "category":category,"action":"getlikes","accid":activeId,"delay":"1h","threads":maxHour,"max":maxDay,"job_max":maxTotal}, function(data) {
      
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
    
    window.location.replace("{{ site_path }}/admin/"+type+"/"+destination);
    
  });
  
  $('.aside-list-item').on('click', function() {
    
    clearAsideLinks()
    
    var accId = $(this).attr('data-accid');
    activeId = accId;
    
    $(this).addClass('active');
    
    $.post('{{ site_path }}/admin/userman/loadaccount', {"accid":accId}, function(data) {
      $('#accountResults').html(data);
    });
    
  });
  
  $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    
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
  
  function content_scroll() {
    
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
          <li data-type="userman" data-sidebar="show" data-icons="users" title="Users Management" class="sidebar-link active"></li>
          <li data-type="proxy" data-sidebar="index" data-icons="proxies" title="Proxy Management" class="sidebar-link"></li>
        </ul>
    </div>
    
  </nav>
{% endblock %}
{% block content %}
<div class="content-scroll" id="content" style="width:100%;">
  <nav id="topNav" class="navbar navbar-expand-md navbar-light">
      <h1 class="topbar-title">User Management</h1>
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
                {% for u in users %}
                    <div data-accid="{{ u.id }}" class="aside-list-item js-list-item ">
                       <div class="clearfix">
                            <!--<span class="circle"><img src="{{ acc.account_profile }}" width="40px" class="rounded-circle"></span>-->
                            <div class="inner">
                                <div class="title">{{ u.user_name }}</div>
                                <div class="sub"><strong>Email : </strong>{{ u.user_email }}</div>
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
                        <p>Please select an account from left side for more details.</p>
                    </div>
                </section>
  </div>
</div>
{% endblock %}
