{% extends "userbase.php" %}
{% block scriptContent %}
  	<script>
$(document).ready( function() {
    $('#overlay').addClass('hide');
});
  	</script>
{% endblock %}
{% block content %}
    <div class="twosidepage">
      <div class="leftbg"></div>
      <div class="rightbg"></div>
			{% if user.errors is not empty %}
				{% for error in user.errors %}
				<div class="col-md-12 p-0 m-0"><div class="alert bg-danger text-white m-0">{{ error }}</div></div>
				{% endfor %}
			{% endif %}
			{% if success == 'true' %}
        <div class="col-md-12 p-0 m-0"><div class="alert bg-success text-white m-0">Account created, Please login using your credentials</div></div>
			{% endif %}
      <div class="rightside">
        <div class="innerwrp">
            <h2 class="section-title">Sign up</h2>
            <p class="subinfo">It’s absolutely free and takes less than 30 seconds.</p>

            <a class="signup-button signin-btn custom-button button-outline" href="{{ site_path }}/growth/signup">Sign up</a>
        </div>
      </div>
      <div class="leftside">
        <div class="innerwrp">
        <form class="mt-3" method="POST" action="{{ site_path }}/growth/signin">
          <div class="form-group">
            <input type="email" name="email" placeholder="email" class="form-control" id="emailInput" value="{{ user.email }}" required />
          </div>
          <div class="form-group">
            <input type="password" placeholder="password" name="password" class="form-control" id="passwordInput" />
          </div>
          <div class="mt-5 login-buttons">
            <button class="custom-button signin-btn fluid-btn" type="submit" name="submit-login"><span class="text-button">SIGN IN</span></button><br>
          </div>
        </form>          
        </div>
      </div>
    </div>
{% endblock %}
