<div class="section-header clearfix">
    <div style="padding: 15px 0!important;" class="section-title">Tasks</div>
    <div class="form-group m-0 float-right">
          <select id="tasksType" class="form-control">
            <option {% if type == 'all' %}selected{% endif %} value="all">Show All</option>
            {% for t in tasks_types %}
                <option {% if t.task_url == type %}selected{% endif %} value="{{ t.task_url }}">{{ t.task_name }}</option>
            {% endfor %}
          </select>
      </div>
</div>
<div id="taskStat">
    {% if type == 'all' %}
    <div style="text-align:right" class="alert bg-danger text-white mb-0">Please choose task type from top to STOP/RESUME tasks</div>
    {% else %}
       {% if tasks is not empty %}
          {% for id,q in tasks %}
            {% if q.is_done == '1' %}
                <div class="alert bg-warning text-white mb-0">This task has been finished</div>
            {% elseif q.is_stopped == '1' and q.is_done == '0' %}
                <div class="alert bg-danger text-white mb-0">This task has been stopped: <a href="#" data-action="{{ q.type }}" data-id="{{ id }}" data-type="resume" class="alert-link text-white actionTask">Resume it <img src="{{ site_path }}/img/icons/play.png" class="mb-1" /></a></div>
            {% else %}
                <div class="alert bg-success text-white mb-0">This task is running: <a href="#" data-action="{{ q.type }}" data-id="{{ id }}" data-type="stop" class="alert-link text-white actionTask">Stop it <img src="{{ site_path }}/img/icons/stop.png" class="mb-1" /></a></div>
            {% endif %}
          {% endfor %}
      {% endif %}
    {% endif %}
</div>
<section class="section-content cd-timeline js-cd-timeline">
   <div class="cd-timeline__container">
       {% if tasks is not empty %}
           {% for id,q in tasks %}
              {% for rslt in q.results %}
              <div data-type="{{ q.type }}" class="cd-timeline__block js-cd-block">
                 <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                     <div class="img--container">
                     <img src="{{site_path }}/img/icons/{{ q.type }}_blue.png">
                     </div>
                 </div>
                 <div class="cd-timeline__content js-cd-content">
                    {% if q.type == "getlikes" %}
                    <p>{{ rslt.username }} has liked your media ( <a href="https://www.instagram.com/p/{{ rslt.mediacode }}" target="_blank">Explore media</a> )</p>
                    {% elseif q.type == "autolikelocations" or q.type == "autoliketags" or q.type == "autolikeusername" %}
                    <p>You liked media ( <a href="https://www.instagram.com/p/{{ rslt.mediacode }}" target="_blank">Explore media</a> )</p>
                    {% elseif q.type == "getcomments" %}
                    <p>{{ rslt.username }} has commented your media ( <a href="https://www.instagram.com/p/{{ rslt.mediacode }}" target="_blank">Explore media</a> )</p>
                    {% elseif q.type == "automessage" %}
                    <p>You sent message to {{ rslt.username }}</p>
                    {% elseif q.type == "autofollowtags" or q.type == "autofollowlocations" or q.type == "autofollowusername" %}
                    <p>You are following {{ rslt.username }}</p>
                    {% elseif q.type == "autounfollows" %}
                    <p>You are unFollowing {{ rslt.username }}</p>
                    {% elseif q.type == "addpost"%}
                    <p>You added post with following caption : {{ rslt.message }} (<a href="{{ site_path }}/{{ user_folder }}/{{ rslt.mediacode }}.jpg" class="mr-2" target="_blank">Explore Media</a>)</p>
                    {% elseif q.type == "addstory" %}
                    <p>You added post with following caption : {{ rslt.message }} (<a href="{{ site_path }}/{{ user_folder }}/{{ rslt.mediacode }}.jpg" class="mr-2" target="_blank">Explore Media</a>)</p>                   
                    {% elseif q.type == "addalbum" %}
                    <p>You added an album with following caption : {{ rslt.message }} (<a href="{{ site_path }}/{{ user_folder }}/{{ rslt.mediacode }}.jpg" class="mr-2" target="_blank">Explore Media</a>)</p>
                    {% endif %}
                 </div>
              </div><br>
              {% endfor %}
          {% endfor %}
      {% else %}
        <div class="alert bg-danger text-white mb-0">No Tasks for this category</div>
      {% endif %}
   </div>
</section>