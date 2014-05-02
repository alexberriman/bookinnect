<?php /* @var $this Controller */ ?>
<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
    
    <link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body class='fullscreen'>
    <div class="container" id="page">        
        <div class="fullScreenContentWidth">
            <?php echo $content; ?>
        </div>
    </div><!-- /page -->
</body>
</html>
