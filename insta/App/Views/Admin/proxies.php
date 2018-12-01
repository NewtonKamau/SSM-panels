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
  
  $(".skeleton-aside-admin").niceScroll({
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
          <li data-type="userman" data-sidebar="show" data-icons="users" title="Users Management" class="sidebar-link"></li>
          <li data-type="proxy" data-sidebar="index" data-icons="proxies" title="Proxy Management" class="sidebar-link active"></li>
        </ul>
    </div>
    
  </nav>
{% endblock %}
{% block content %}
<div class="content-scroll" id="content" style="width:100%;">
  <nav id="topNav" class="navbar navbar-expand-md navbar-light">
      <h1 class="topbar-title">Proxies Management</h1>
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
        <aside class="skeleton-aside-admin" style="height: 550px;">
            {% if proxies is not empty %}
            <table id="accountsTable" class="table table-sm">
                <thead>
                  <tr>
                    <th style="width:8%;" scope="col">#</th>
                    <th style="width:20%;" scope="col">Proxy</th>
                    <th style="width:15%;" scope="col">Verified</th>
                    <th style="width:15%;" scope="col">Assigned</th>
                  </tr>
                </thead>
                <tbody>
                {% for p in proxies %}
                    <tr>
                      <td>{{ loop.index }}</td>
                      <td>{{ p.proxy }}</td>
                      <td>{% if( p.working == "1" ) %}<span class="success-status">WORKING</span>{% elseif( p.working == "0" ) %}<span class="warning-status">NO</span>{% else %}<span class="fail-status">FAILED</span>{% endif %}</td>
                      <td>{% if( p.userid == "0") %}<span class="success-status">FREE</span>{% else %}<span class="fail-status">ASSIGNED</span>{% endif %}</td>
                    </tr>
                {% endfor %}
              </tbody>
        </table>
            {% else %}
            <div class="alert bg-danger text-white">There is no proxies in database</div>
            {% endif %}
         </aside>
        <section id="accountResults" class="skeleton-content-admin hide-on-medium-and-down" style="height: 550px;">
            <div class="section-header clearfix">
                <h2 class="section-title">Add new proxies</h2>
            </div>
            <div class="section-content">
                <form action="{{ site_path }}/admin/proxy/proxies" method="POST">
                <div class="row m-0 mt-3 mb-3 p-0">
                    <div class="col-md-12 m-0 p-0">
                        <label for="proxies">Proxy List</label><br>
                        <textarea class="input" id="proxies" name="proxies" rows="3">Proxy1:port&#10;Proxy2:port</textarea>
                    </div>
                </div>
                <div class="clearfix mt-5">
                    <div class="row m-0 p-0">
                        <div style="text-align:center;" class="col-md-12">
                           <input class="fluid button schedule" style="width:40%;" type="submit" value="Save">
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </section>
  </div>
</div>
{% endblock %}
