{% extends "userbase.php" %}
{% block content %}
<div id="signup" class="simpleform">
    <h1 class="title">Admin Login</h1>
    <form action="{{ site_path }}/admin/account/authenticate" method="POST">
      <div class="form-group">
        <input type="email" name="email" class="form-control" placeholder="Email Address" />
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password" />
      </div>
      <div class="mt-5 login-buttons">
            <button class="custom-button signin-btn fluid-btn" type="submit" name="submit-login"><span class="text-button">Login</span></button><br>
      </div>
    </form>
</div>
{% endblock %}
