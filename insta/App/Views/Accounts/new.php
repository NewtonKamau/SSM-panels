{% extends "base.php" %}
{% block scriptContent %}
  	<script>
$(document).ready( function() {
    
  $('#overlay').addClass('hide');
  var proxy = '';
  
  {% if notification == 'success' %}
    	$('#notificationPanel').addClass('alert bg-success text-white');
    	$('#notificationPanel').html('Your account has been activated successfuly !');
      setTimeout(function() {
         clearNortification().delay(800).fadeOut( 400 );
      }, 5000);
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
    
  $('#addAccount').on('click', function() {
    
    var username = $('#instaUsername').val();
    var password = $('#instaPassword').val();
    var category = $('#instaCat').val();
    proxy = $('#instaProxy').val();
    
    if(username != '' && password != '' && category != '') {
     
      $('#overlay').removeClass('hide');
      $.post('{{ site_path }}/accounts/check', {"username":username, "password":password, "category":category, "proxy":proxy}, function(data) {
        var res = $.parseJSON(data);
        
        if(res.error != undefined) {

        	$('#notificationPanel').addClass('alert bg-danger text-white');
        	$('#notificationPanel').html(res.error);
          setTimeout(function() {
             clearNortification().delay(800).fadeOut( 400 );
          }, 5000);
          $('#overlay').addClass('hide');
      
        } else if(res.success != undefined) {
          
          window.location.replace("{{ site_path }}/accounts/new/success");
          
        } else {

          $('#accountId').val(res.accid);
          
          $('.challenge-choice').removeClass('hide');
          $('.account-add').addClass('hide');
          $('#overlay').addClass('hide');
        
        }
        
      });
    
    } else {
      
      
    	$('#notificationPanel').addClass('alert bg-danger text-white');
    	$('#notificationPanel').html('Please fill in all required fields !');
      setTimeout(function() {
         clearNortification().delay(800).fadeOut( 400 );
      }, 5000);
      
    }
    
    
  });
  
  $('.challenge-choice').on('click', 'a', function() {
    
    var accId = $('#accountId').val();
    var choice = $(this).attr('data-choice');
    
    $('#overlay').removeClass('hide');
    $.post('{{ site_path }}/accounts/verify', {"account":accId, "choice":choice}, function(data) {
      var res = $.parseJSON(data);
      
      $('#accountIdConfirm').val(res.accid);    
      
      $('.challenge-confirm').removeClass('hide');
      $('.challenge-choice').addClass('hide');
      $('#overlay').addClass('hide');
      
    });
    
  });
  
  $('.challenge-confirm').on('click', 'a', function() {
    
    var captcha = $('#sixDigits').val();
    var accId = $('#accountIdConfirm').val();
    
    $('#overlay').removeClass('hide');
    $.post('{{ site_path }}/accounts/activate', {"account":accId, "captcha":captcha}, function(data) {
      
      if(data == 'success') {
        
        window.location.replace("{{ site_path }}/accounts/new/success");
        
      } else {
        
      	$('#notificationPanel').addClass('alert bg-danger text-white');
      	$('#notificationPanel').html('Please fill in all required fields !');
        setTimeout(function() {
           clearNortification().delay(800).fadeOut( 400 );
        }, 5000);
        
      }
      
    });
    
    
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
      <h1 class="topbar-title">Add new account</h1>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto"></ul>
        <a class="nav-link" href="{{ site_path }}/users/logout"><i class="fa fa-sign-out"></i></a>
      </div>
    </nav>
  <div class="content">
        <div id="notificationPanel"></div>
        <div class="row content">
            <div class="challenge-choice no-data hide">
              <p>You need to verify your account, please choose a method.</p>
              <input type="hidden" id="accountId" />
              <a data-choice="1" class="small button challenge-button" href="#">
                  Via email                               
              </a>
              <a data-choice="0" class="small button challenge-button" href="#">
                  Via phone                               
              </a>
            </div>
            <div class="challenge-confirm no-data hide">
              <p>Paste in the 6 digits code received </p>
              <input type="hidden" id="accountIdConfirm" />
              
              <input type="text" id="sixDigits" class="form-controler" placeholder="6-Digits" />
              <a class="small button challenge-button" href="#">
                  Confirm                              
              </a>
            </div>
            <div class="col-md-4 account-add account-holder">
            <div class="new-account-container">
                  <div class="form-group">
                      <input id="instaUsername" type="text" class="form-control" placeholder="Username *" />
                  </div>
                  <div class="form-group">
                      <input id="instaPassword" type="password" class="form-control" placeholder="¨Password *" />
                  </div>
                  <div class="form-group">
                      <select id="instaCat" class="form-control">
                        <option selected val="">Account Category *</option>
                        <option value="all">General</option>
                        <option value="carsnbikes">Cars & Bikes</option>
                        <option value="fahsionnstyle">Fashion & Style</option>
                        <option value="personalntalent">Personal & Talent</option>
                        <option value="petsnanimals">Pets & Animals</option>
                        <option value="fitnessnsports">Fitness & Sports</option>
                        <option value="foodnnutrition">Food & Nutrition</option>
                        <option value="quotesntextes">Quotes & Textes</option>
                        <option value="humournmemes">Humour & Memes</option>
                        <option value="luxurynmotivation">Luxury & Motivation</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <input id="instaProxy" type="text" class="form-control" placeholder="Proxy (Optional)" />
                  </div>
                  <ul class="field-tips">
                      <li>Proxy should match following pattern: http://ip:port OR http://username:password@ip:port</li>
                      <li>It's recommended to to use a proxy belongs to the country where you've logged in this acount in Instagram's official app or website.</li>
                  </ul>
            </div>
            <div class="account-button-container">
              <a id="addAccount" style="cursor:pointer;" class="sub">ADD ACCOUNT</a>
            </div>
          </div>
        </div>
  </div>
</div>
{% endblock %}
