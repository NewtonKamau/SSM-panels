{% extends "userbase.php" %}
{% block content %}
{% if user.errors is not empty %}
<div class="col-md-12 p-0 m-0"><div class="alert bg-danger text-white m-0">
  <ul style="text-style:none;">
	{% for error in user.errors %}
	
	<li>{{ error }}</li>
	
	{% endfor %}
	</ul>
</div></div>
{% endif %}
{% if success is not empty %}
<div class="col-md-12 p-0 m-0"><div class="alert bg-success text-white m-0">
{{ success }} - <a href="../../growth/login" class="alert-link text-white" >Login Here</a>
</div></div>
{% endif %}
<div id="signup" class="simpleform">
    <h1 class="title">Sign up to <br> managing Instagram!</h1>
    <form action="{{ site_path }}/growth/create" method="POST">
      <div class="form-group">
        <input type="text" name="f_name" class="form-control" placeholder="Firstname" />
      </div>
      <div class="form-group">
        <input type="text" name="l_name" class="form-control" placeholder="Lastname" />
      </div>
      <div class="form-group">
        <input type="email" name="acc_email" class="form-control" placeholder="Email Address" />
      </div>
      <div class="form-group">
        <select style="width:100%!important;" class="form-control" name="time_zone" id="timeZone">
              <option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
              <option value="-10.0">(GMT -10:00) Hawaii</option>
              <option value="-9.0">(GMT -9:00) Alaska</option>
              <option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
              <option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
              <option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
              <option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
              <option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
              <option value="-3.5">(GMT -3:30) Newfoundland</option>
              <option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
              <option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
              <option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
              <option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
              <option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
              <option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
              <option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
              <option value="3.5">(GMT +3:30) Tehran</option>
              <option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
              <option value="4.5">(GMT +4:30) Kabul</option>
              <option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
              <option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
              <option value="5.75">(GMT +5:45) Kathmandu</option>
              <option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
              <option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
              <option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
              <option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
              <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
              <option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
              <option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
              <option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
        </select>
      </div>
      <div class="form-group">
        <input type="password" name="acc_pass" class="form-control" placeholder="Password" />
      </div>
      <div class="form-group">
        <input type="password" name="acc_pass_confirm" class="form-control" placeholder="Confirm Password" />
      </div>
      <div class="mt-5 login-buttons">
            <button class="custom-button signin-btn fluid-btn" type="submit" name="submit-login"><span class="text-button">Get Started</span></button><br>
      </div>
    </form>
    <div class="sub">
        <div>By creating an acount you agree to our terms of service.</div>
        <a href="{{ site_path }}/growth/login">Already have an account?</a>
    </div>
</div>
{% endblock %}
