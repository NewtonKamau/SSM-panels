{% extends "base.php" %}
{% block scriptContent %}
  	<script>
$(document).ready( function() {
    
  $('#overlay').addClass('hide');
  
  var current = '{{current}}';
  {% if current != ''%}
    browse_sections(current);
  {% else %}
    browse_sections();
  {% endif %}
  
  {% if notif != '' %}
    $('#notificationPanel').addClass('alert bg-danger text-white');
    $('#notificationPanel').text('Please complete registration !');
  {% endif %}
  
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
  
  $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    
  $('#adminBrowseMenu').on('click', 'a', function() {
        $('.admin-menu-link').removeClass('active');
        var adminActiveMenu = $(this).attr('data-menu');
        $(this).addClass('active');
        browse_sections(adminActiveMenu);
    });
    
  function browse_sections(actMenu) {
      
      if(actMenu === undefined) {
          var i = 0;
          $('.admin-menu-link').each(function(i, obj) { 
              if(i == 0) {
                $(obj).addClass('active');
              }
              if($(obj).hasClass('active')) {
                  var activeMenu = $(obj).attr('data-menu');
                  hide_all_sections();
                  $('#'+activeMenu).show();
              }
              i++;
          });
          
      } else {
          
          hide_all_sections();
          $('.admin-menu-link').each(function(i, obj) { 
              if($(obj).attr('data-menu') == actMenu) {
                $(obj).addClass('active');
              }
          });
          $('#'+actMenu).show();
          
      }
  }
  
  function hide_all_sections() {
        $('.admin-set-content').hide();
    }
    
  function clearNortification() {
    
      $('#notificationPanel').removeClass();
      $('#notificationPanel').html();
      $('#notificationPanel').text("");
  }
  
  function style_sidebar() {
        
      $('.sidebar-link').each(function(i, obj) {
          var ico = $(this).attr('data-sidebar');

              $(this).css({"background": "url({{ site_path }}/img/icons/"+ico+".png) no-repeat scroll", "background-position": "25px"})

      });   
        
    }

});
  	</script>
{% endblock %}
{% block aside %}
  <nav class="sidebar-scroll" id="sidebar">
    <div class="hor-menu">
        <span class="main-nav ml-3">APPLICATION</span>
        <ul class="mt-3 mb-5">
          <li data-sidebar="instagram" class="sidebar-link"><a href="{{ site_path }}/accounts/index">Instagram Account</a></li>
          <li data-sidebar="instalike" class="sidebar-link"><a href="{{ site_path }}/accounts/likes">Get Likes</a></li>
        </ul>
        <span class="main-nav ml-3">SETTINGS</span>
        <ul class="mt-3 mb-5">
          <li data-sidebar="accounts" class="sidebar-link active"><a href="{{ site_path }}/settings/index">Account Settings</a></li>
        </ul>
    </div>
    
  </nav>
{% endblock %}
{% block content %}
<div class="content-scroll" id="content" style="width:100%;">
  <nav id="topNav" class="navbar navbar-expand-md navbar-light bg-white fixed-top">
      <a class="navbar-brand" href="#">INSTApp</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto"><!--
          <li class="nav-item active">
            <a class="nav-link" href="{{ site_path }}/accounts/index">Accounts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ site_path }}/friends/request">Friends </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ site_path }}/groups/request">Groups </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ site_path }}/pages/index">Pages </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ site_path }}/scraper/friends">Scraper </a>
          </li>
        --></ul>
        <a class="nav-link" href="{{ site_path }}/users/logout"><i class="fa fa-sign-out"></i></a>
      </div>
    </nav>
  <div class="content">
        <div class="row m-0 p-0">
            <div class="col-md-12 p-0">
                <div class="preview-content">
                    <div class="row m-0 p-0">
                        <div class="col-md-3 p-0">
                            <div id="adminBrowseMenu" class="admin-menu-content">
                                
                                <span class="content-menu-nav">Account Settings</span>
                                <ul class="admin-menu-list mt-4">
                                    <li><a data-menu="current" class="admin-menu-link">Account Informations</a></li>
                                    <li><a data-menu="trialperiod" class="admin-menu-link">Subscription</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9 p-0">
                            <div class="admin-set-content add-content" id="current">
                                <div class="admin-settings-content">
                                  <form method="POST" action="{{ site_path }}/settings/update">
                                    <div id="notificationPanel"></div>
                              			{% if errors is not empty %}
                              				{% for error in errors %}
                              						<div class="alert bg-danger text-white m-0">{{ error }}</div>
                              				{% endfor %}
                              			{% endif %}
                                      <div class="form-group mt-4">
                                        <label for="accCat">Account Category</label>
                                        <select name="acc_cat" class="form-control" id="accCat">
                                          <option value="fashion">Fashion & Beauty</option>
                                          <option value="food">Food & Receipes</option>
                                          <option value="tech">Technology & Internet</option>
                                          <option value="spirit">Spiritual & Religion</option>
                                        </select>
                                      </div>
                                      <div class="form-group">
                                          <label for="accName">User Name</label>
                                          <input type="text" name="acc_name" class="form-control" id="accName" value="{{ user.account_username }}" readonly/>
                                      </div>
                                      <div class="form-group">
                                          <label for="accEmail">Email Address</label>
                                          <input type="text" name="acc_email" class="form-control" id="accEmail" placeholder="{% if user.account_email == '' %}Your Email Address{% else %}{{ user.account_email }}{% endif %}" />
                                      </div>
                                      <div class="form-group">
                                          <label for="accPass">Password</label>
                                          <input type="password" name="acc_pass" class="form-control" placeholder="Password" id="accPass" />
                                      </div>
                                      <div class="form-group">
                                          <label for="accPassConfirm">Confirm Password</label>
                                          <input type="password" name="acc_pass_confirm" class="form-control" placeholder="Confirm Password" id="accPassConfirm" />
                                      </div>
  
                                      <div class="mt-5" style="text-align:center;">
                                        <button type="submit" class="btn btn-primary" style="width:20%;" ><span class="text-button">SUBMIT</span></button>
                                      </div>
                                    </form>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</div>
{% endblock %}
