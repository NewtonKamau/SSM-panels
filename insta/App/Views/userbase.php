
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico">

    <title>INSTApp</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ site_path }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ site_path }}/css/stylesheet.css" rel="stylesheet">

    <script src="https://use.fontawesome.com/98fada8a29.js"></script>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	
{% block scriptContent %}{% endblock %}

  </head>

  <body style="overflow:auto!important;" class="lightbg">
  {% block content %}{% endblock %}
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ site_path }}/js/vendor/popper.min.js"></script>
    <script src="{{ site_path }}/js/bootstrap.min.js"></script>
  </body>
</html>
