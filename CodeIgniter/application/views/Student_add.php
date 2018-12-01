<!DOCTYPE html>
<html>
<head>
	<title>CRUD functionality for Student Database</title>
</head>
<body>
<form method="" action="">
<?php
 echo form_open('Student_controller/addStudent');
 echo form_label('Roll No.');
 echo form_input(array('id'=>'name', 'name'=> 'name'));
 echo "<br>";
 echo form_submit(array('id'=>'submit', 'value'=> 'Add'));
 echo form_close();
?>
</form>


</body>
</html>