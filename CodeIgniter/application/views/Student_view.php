<!DOCTYPE html>
<html>
<head>
	<title>CRUD for Students in CI</title>
</head>
<body>
<a href="<?php echo base_url(); ?>/index.php/StudentAddView"></a>
<table border="1">
	<?php
	echo "tr";
	echo "<td> Roll No </td>";
	echo "<td> Name </td>";
	echo "<td> Delete</td>";
	echo "</tr>";

		foreach ($record as $r) {
			echo "tr";
			echo "<td> $r->Roll No </td>";
			echo "<td> $r->Name </td>";
			echo "<td> <a href='" .base_url(). "index.php/Student/delete".$r->roll_no."'>Delete</a></td> ";
			echo "</tr>";
		}

	?>
</table>
</body>
</html>