<?php if(!defined('INDEX_CHECK')){die('Error: Cannot access directly.');} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CybershadeCMS - Error Exception</title>
<link rel="stylesheet" href="/<?php echo root(); ?>images/exception.css" type="text/css" />
<script src="/<?php echo root(); ?>scripts/exception.js" type="text/javascript"></script>

</head>

<body>
<div id="wrapper">
	<h1><?php echo $exception->_class; ?><small><?php echo $exception->_code; ?></small></h1><br />
	<h2>Message:</h2>
	<div id="message"><?php echo str_replace("<a href='", "<a target='_blank' href='http://www.php.net/manual/en/", $exception->_message); ?></div><br />
	<h2>Source Code:<small><?php echo $exception->_file; ?> (line: <?php echo $exception->_line; ?>)</small></h2>
	<div id="source"><?php echo $exception->_source; ?></div><br />
	<h2>Stack Trace:<small id="master">[expand all]</small></h2>
	<div id="trace"><?php echo $exception->_trace; ?></div>
</div>
</body>
</html>
