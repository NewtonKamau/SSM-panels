{% extends "base.php" %}
{% block scriptContent %}
  	<script>
$(document).ready( function() {
    
    $('#overlay').addClass('hide');
    var proxy = '';
    var imgURL = '';
    var lists = [];
    var module = 'timeline';
    
    {% if accounts is not empty %}
    {% for acc in accounts %}
        {% if loop.index == 1 %}
        var activeId = {{ acc.id }};    
        {% endif %}
    {% endfor %}
    {% else %}
    var activeId = 0;
    {% endif %}
    
    $(".content-scroll").niceScroll({
        cursorcolor:"#009efb",
        cursorwidth:"9px",
        autohidemode: "cursor"
    });
    
    $('#scheduleDate').datetimepicker();
    
    {% if notification == 'success' %}
    	$('#notificationPanel').addClass('alert bg-success text-white');
    	$('#notificationPanel').html('Your account has been activated successfuly !');
          setTimeout(function() {
             clearNortification().delay(800).fadeOut( 400 );
          }, 5000);
    {% endif %}
    
    var medias = $('#filemanager').attr('data-files');
    var folder = $('#filemanager').attr('data-folder');
    if(medias != '') {
        
        var files = jQuery.parseJSON(medias);
        if (files.length !== 0) {
            $.each(files, function(i, f) {
                var myReg = /([a-z0-9]+)\..*/;
                match = myReg.exec(f);

                $('#filemanager').append('<li class="gallery-imgs" data-url="'+match[1]+'"><img src="{{ site_path }}/'+folder+'/'+f+'" height="75px" width="75px" /><div class="file-detail img-'+match[1]+' hide" style="display: none;"><img style="margin-top:25px;margin-left:25px;" src="{{ site_path }}/img/icons/plus.png" data-url="'+match[1]+'" class="add-img" /></div></li>');
            });
        }
    
    }
    
    $('input[name=type]').on('click', function() {
        
        module = $('input[name=type]:checked').val();
        $('#addedContent').empty();
        lists = [];
        
    });
    
	$('#schedule').on('click', function() {
		
		if($('#schedule').is(":checked")) {
			
			$('#scheduleDate').prop("disabled", false);
			
		} else {
			
			$('#scheduleDate').prop("disabled", true);
			
		}
		
	});
    
    $('.gallery-imgs').bind("mouseenter focus", function(event) {
         imgURL = $(this).attr('data-url');
         $(this).children('div').show();
    });
    
    $('.gallery-imgs').bind("mouseleave", function(event) {
         $(this).children('div').hide();
    });
    
    /*$('#addedContent').bind("mouseenter focus", '.gallery-added-imgs', function(event) {
        alert('ok');
         imgURL = $(this).attr('data-url');
         $(this).children('div').show();
    });
    
    $('#addedContent').bind("mouseleave", '.gallery-added-imgs', function(event) {
         $(this).children('div').hide();
    });*/
    
    $('.add-img').on('click', function() {

        var dataURL = $(this).attr('data-url');
        var dataFolder = $(this).closest('ul').attr('data-folder');
        var dataImg = $(this).closest('li').children()[0].src;
        
        if(module == 'timeline' || module == 'story') {
            
            lists = [];
            lists.push(dataURL);
            $('#addedContent').html('<li class="gallery-added-imgs" data-url="'+dataURL+'"><img src="'+dataImg+'" height="75px" width="75px"><div class="added-file-detail img-'+dataURL+' hide" style="display: none;"><img style="margin-top:25px;margin-left:25px;" src="https://insta-insta-malawidivani00.c9users.io/img/icons/plus.png" data-url="'+dataURL+'" class="add-img"></div></li>');
        
        } else if(module == 'album') {
            
            lists.push(dataURL);
            $('#addedContent').append('<li class="gallery-added-imgs" data-url="'+dataURL+'"><img src="'+dataImg+'" height="75px" width="75px"><div class="added-file-detail img-'+dataURL+' hide" style="display: none;"><img style="margin-top:25px;margin-left:25px;" src="https://insta-insta-malawidivani00.c9users.io/img/icons/plus.png" data-url="'+dataURL+'" class="add-img"></div></li>');    
            
        }
        $('#placePreview').removeClass('placeholder');
        $('#placePreview').css("text-align", "center");
        $('#placePreview').html('<img src="'+dataImg+'" width="300px" />');
        
    });
    
    $('#postSubmit').on('click', function() {
        $('#overlay').removeClass('hide');
        var message = $('#postCaption').val();
        if(module == 'timeline') {
            
            actionType = "addpost";
            
        } else if(module == 'album') {
            
            actionType = "addalbum";
            
        } else if(module == 'story') {
            
            actionType = 'addstory';
            
        }
        
        var schedule = $('#scheduleDate').val();
        
        if(activeId != 0 && lists.length > 0) {
            
            if(schedule == '') {
                
            $.post('{{ site_path }}/task/addtask', {"lists":lists,"message":message,"action":actionType,"accid":activeId,"delay":"1m"}, function(data) {
              
              if(data == 'success') {
                	$('#notificationPanel').html('<div class="alert bg-success text-white">Your action has been scheduled !</div>');
                	$('#overlay').addClass('hide');
                  setTimeout(function() {
                     clearNortification().delay(800).fadeOut( 400 );
                  }, 5000);
              }
              
            });
            
            } else {
     
             $.post('{{ site_path }}/task/addtask', {"lists":lists,"schedule":schedule,"message":message,"action":actionType,"accid":activeId,"delay":"1m"}, function(data) {
              
              if(data == 'success') {
                	$('#notificationPanel').html('<div class="alert bg-success text-white">Your action has been scheduled !</div>');
                	$('#overlay').addClass('hide');
                  setTimeout(function() {
                     clearNortification().delay(800).fadeOut( 400 );
                  }, 5000);
              }
              
            });           
                
            }
            
        } else {
            
            if(activeId == 0) {
            
            	$('#notificationPanel').addClass('alert bg-danger text-white');
            	$('#notificationPanel').html('Add at least one Account');
                  setTimeout(function() {
                     clearNortification().delay(800).fadeOut( 400 );
                  }, 5000);
             	$('#overlay').addClass('hide');
          
            }
            
            if(lists.length == 0) {
            
            	$('#notificationPanel').addClass('alert bg-danger text-white');
            	$('#notificationPanel').html('Choose at least one file');
                  setTimeout(function() {
                     clearNortification().delay(800).fadeOut( 400 );
                  }, 5000);
             	$('#overlay').addClass('hide');
          
            }
            
        }
        
      });
    
    $(".sidebar-scroll").niceScroll({
        cursorcolor:"#009efb",
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
    
    content_resize();
    
    $(function () {
        $(".js-fm-filebrowser").click(function (event) {
            event.preventDefault();
            $('#file').trigger('click');
        });
    
        document.getElementById('file').addEventListener('change', readFile, false);
    });
    
    function readFile(e) {
        
        $('#overlay').removeClass('hide');
        clearFileNotification();
        
        var input = $(this);
        var inputFiles = this.files;
        if(inputFiles == undefined || inputFiles.length == 0) return;
        var inputFile = inputFiles[0];

        if (!inputFile.type.match(/^image\/jpeg/) && !inputFile.type.match(/^video\/mp4/)) {
        
            $('#fileError').html('<div class="alert bg-danger text-white">File Extension not allowed</div>');
            $('#overlay').addClass('hide');
            setTimeout(function() {
             clearFileNotification().delay(800).fadeOut( 400 );
            }, 2000);
        
        } else {
            
            var formData = new FormData();
            
            formData.append("file", inputFile);
            
            $.ajax({
                  url: "{{ site_path }}/accounts/upload",  
                  type: "POST",  
                  data: formData,  
                  contentType: false,  
                  processData:false,  
                  success: function(data)  
                  {
                       var res = $.parseJSON(data);
                       
                       if(res.error == undefined) {
                           
                           img = res.media;
                           co = res.code;
                           
                           location.reload();
                           
                       } else {
                           
                           $('#fileError').html('<div class="alert bg-danger text-white">'+res.error+'</div>');
                           $('#overlay').addClass('hide');
                           
                       }
                  }  
             });
            
        }
    
    }
    
    function clearNortification() {
    
      $('#notificationPanel').removeClass();
      $('#notificationPanel').html();
      $('#notificationPanel').text("");
    
    }
    
    function clearFileNotification() {

      $('#fileError').removeClass();
      $('#fileError').html();
      $('#fileError').text("");
      
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
    
    function content_resize() {
      
      $(".content").getNiceScroll().resize();
      
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
          <li data-type="accounts" data-sidebar="post" data-icons="schedule" title="Auto Posting" class="sidebar-link title-tooltip active"></li>
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
<div class="content-scroll" id="content">
  <nav id="topNav" class="navbar navbar-expand-md navbar-light">
      <h1 class="topbar-title">Auto Posting</h1>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto"></ul>
        <a class="nav-link" href="{{ site_path }}/users/logout"><i class="fa fa-sign-out"></i></a>
      </div>
    </nav>
  <div class="content" id="post">
        <div id="notificationPanel"></div>
        <form action="javascript:void(0)" data-url="https://demo.getnextpost.io/post" data-post-id="" autocomplete="off">

            <input type="hidden" name="media-ids" value="">

            <div class="container-1200">
                <div class="row-s">
                    
                    <div class="types clearfix">
                        
                        <label>
                            <input name="type" value="timeline" type="radio" checked>
                            <div>
                                <span class="sli sli-camera icon"></span>

                                <div class="type">
                                    <div class="name">
                                        <span class="hide-on-small-only">Add Post</span>
                                        <span class="hide-on-medium-and-up">Post</span>
                                    </div>
                                    <div>
                                        Photo / Video    
                                    </div>
                                </div>
                            </div>
                        </label>

                        <label>
                            <input name="type" type="radio" value="story">
                            <div>
                                <span class="sli sli-plus icon"></span>

                                <div class="type">
                                    <div class="name">
                                        <span class="hide-on-small-only">Add Story</span>
                                        <span class="hide-on-medium-and-up">Story</span>    
                                    </div>
                                    <div>
                                        Photo / Video    
                                    </div>
                                </div>
                            </div>
                        </label>

                        <label>
                            <input name="type" type="radio" value="album">
                            <div>
                                <span class="sli sli-layers icon"></span>

                                <div class="type">
                                    <div class="name">
                                        <span class="hide-on-small-only">Add Album</span>
                                        <span class="hide-on-medium-and-up">Album</span>        
                                    </div>
                                    
                                    <div>
                                        Photo / Video    
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="clearfix">
                            <div class="col s12 m6 l4">
                                <div class="hide-on-medium-and-up post-mobile-uploader">
                                    <a href="javascript:void(0)" class="js-fm-filebrowser fluid button button--dark">
                                        <span class="sli sli-cloud-upload fz-18 mr-10" style="vertical-align: -3px"></span>
                                        Pick a file from your device
                                    </a>

                                    <div class="mobile-uploader-result"></div>
                                </div>

                                <section class="section hide-on-small-only">
                                    <div class="section-header clearfix">
                                        <h2 class="section-title">Upload Media</h2>

                                        <div class="section-actions clearfix">
                                            <a class="mdi mdi-laptop icon tippy js-fm-filebrowser" 
                                               data-size="small"
                                               href="javascript:void(0)"
                                               title="Your PC"></a>

                                            <!--<a class="mdi mdi-link-variant icon tippy js-fm-urlformtoggler" 
                                               data-size="small"
                                               href="javascript:void(0)"
                                               title="URL"></a>

                                            <a class="mdi mdi-dropbox icon cloud-picker tippy"
                                               data-size="small"
                                               data-service="dropbox"
                                               href="javascript:void(0)"
                                               title="Dropbox"></a>

                                            <a class="mdi mdi-onedrive icon cloud-picker tippy"
                                               data-size="small"
                                               data-service="onedrive" 
                                               data-client-id="{{ od_clientid }}"
                                               href="javascript:void(0)"
                                               title="OneDrive"></a>

                                            <a class="mdi mdi-google-drive icon cloud-picker tippy"
                                               data-size="small"
                                               data-service="google-drive"
                                               data-api-key="{{ gd_apikey }}"
                                               data-client-id="{{ gd_clientid }}"
                                               href="javascript:void(0)"
                                               title="Google Drive"></a>-->
                                        </div>
                                    </div>

                                    <div>
                                        <div id="fileError"></div>
                                        <input type="file" id="file" name="userfile" style="display:none;"/>
                                        <ul id="filemanager" 
                                             data-folder="{{ user_folder }}"
                                             data-files="{{ medias }}"
                                             style="height: 480px"></ul>
                                    </div>
                                </section>
                            </div>

                        <div class="col s12 m6 m-last l4">
                            <section class="section">
                                <div class="section-header clearfix">
                                    <h2 class="section-title">New Post</h2>
                                    <div class="section-actions">
                                        {% if accounts is not empty %}
                                        <div class="dropdown">
                                            <span class="sli sli-social-instagram icon pe-none"></span>
                                                <select name="account">
                                                    {% for acc in accounts %}
                                                    <option value="{{ acc.id }}" {% if loop.index == 1 %}selected{% endif %}>{{ acc.account_username }}</option>
                                                    {% endfor %}
                                                </select>
                                        </div>
                                        {% else %}
                                        <a class="small button" href="{{ site_path }}/accounts/new"><img src="{{ site_path }}/img/icons/s_follower.png" class="mr-1">
                                        New Account                                
                                        </a>
                                        {% endif %}
                                    </div>
                                </div>

                                <div class="section-content controls" style="min-height: 429px;">
                                    <ul id="addedContent" class="added-imgs"></ul>

                                    <div class="tabs mb-20 ">
                                        <div class="tabheads clearfix">
                                            <a class="active" href="javascript:void(0)" style="width: 50%; border-bottom: none;" data-tab="1">Caption</a>
                                        </div>
                                        <div class="tabcontents">
                                            <div class="active pos-r" data-tab="1">
                                                <div class="caption input " data-placeholder="Write a caption" contenteditable="true" style="display: none;"></div>
                                                <div class="emojionearea caption input" role="application">
                                                    <textarea class="emojionearea-editor" placeholder="Write a caption" id="postCaption" autocomplete="off" autocorrect="off" autocapitalize="off"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="search-results none"></div>

                                    <div class="mb-20">
                                         <label>
                                            <input type="checkbox" class="checkbox" id="schedule" name="schedule" value="1">
                                            <span>Schedule</span>
                                        </label>
                                    </div>
                                    <div class="pos-r mb-20">
                                        <input type="text" class="form-control" name="schedule_date" id="scheduleDate" placeholder="{{ current_time }}" disabled>
                                    </div>
                                </div>

                                <button class="fluid large button" id="postSubmit" type="button">Post now</button>
                            </section>
                        </div>

                        <div class="col s12 m6 l4 l-last hide-on-medium-and-down">
                            <section class="section">
                                <div class="post-preview" data-type="timeline">
                                        <div class="preview-header">
                                            <img src="https://demo.getnextpost.io/assets/img/instagram-logo.png" alt="Instagram">
                                        </div>

                                        <div class="preview-account clearfix">
                                            <span class="circle"></span>
                                            <span class="lines">
                                                <span class="line-placeholder" style="width: 47.76%"></span>
                                                <span class="line-placeholder" style="width: 29.85%"></span>
                                            </span>
                                        </div>

                                        <div class="preview-media--timeline"><div id="placePreview" class="placeholder"></div></div>

                                        <div class="preview-media--story">
                                            <!-- <div class="img"></div> -->
                                            <!-- <video src="#" playsinline autoplay muted loop></video> -->    
                                        </div>
                                        <div class="story-placeholder"></div>

                                        <div class="preview-media--album">
                                            <!-- <div class="img"></div> -->
                                            <!-- <video src="http://demo.thepostcode.co/nextpost/assets/uploads/1/instagram/19026330_428324574201218_2358753720650432512_n.mp4" playsinline autoplay muted loop class="video-preview"></video> -->    
                                        </div>

                                        <div class="preview-caption-wrapper">
                                            <div class="preview-caption-placeholder" style="">
                                                <span class="line-placeholder"></span>
                                                <span class="line-placeholder" style="width: 61.19%"></span>
                                            </div>

                                            <div class="preview-caption" style=""></div>
                                        </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </form>
  </div>
</div>
{% endblock %}
