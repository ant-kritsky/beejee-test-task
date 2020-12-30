<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/jquery-ui.css"/>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            jQuery.extend(jQuery.validator.messages, {
                required: "<?php echo _("This field is required.")?>",
                remote: "<?php echo _("Please fix this field.")?>",
                email: "<?php echo _("Please enter a valid email address.")?>",
                maxlength: jQuery.validator.format("<?php echo _("Please enter no more than {0} characters.")?>"),
                minlength: jQuery.validator.format("<?php echo _("Please enter at least {0} characters.")?>")
            });
        })
    </script>
</head>
<body>
<div id="content" class="container">
	<div class="row">
		<div class="span12 navigation">
		<?php if ($auth->isAuth()): ?>
			<a href="/admin/logout">Logout</a>
		<?php else: ?>
			<a href="/admin/login">Login</a>
		<?php endif ?>
		
		</div>
	</div>
    <?php echo $content ?>

</div>
</body>
</html>