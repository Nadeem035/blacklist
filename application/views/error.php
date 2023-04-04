<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?=APP_TITLE . " :: Error"?></title>
</head>
<body style="margin:0 auto;padding:10px;overflow:hidden;overflow-y:scroll;text-align:center;">
<!--div style="text-align:center">
	<img src="<?=IMG?>error.png">
</div-->
<h4><?php echo htmlentities($title);?></h4>
<div style="font-size:16px;position:relative;margin:0 auto;overflow:auto;width:auto;border-radius:8px;padding:5px;border:1px solid #666;box-shadow:0 0 8px #123456;clear:both;text-align:left;">
	<pre>
	<?php if(is_string($message)) echo htmlentities($message);
	else print_r($message); ?>
		</pre>
</div>

</body>
</html>