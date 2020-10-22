<?php
if (isset($_POST['name'])) $name = $_POST['name'];
else $name = "(Not entered)";
?>
<html> 
<head><title>Get View Post</title> </head>
<body>
your name í: <?php echo $name ?><br>
<form method="post" action="">
what is yo9u name ?
<input type="text" name="name">
<input type="submit">
</form>
</body>
</html>
