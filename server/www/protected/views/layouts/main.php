<?php /* @var $this Controller */ ?>
<?php Yii::app()->bootstrap->register(); ?>
<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container" id="page">
        <div class="topbar clearfix">
            <div id="tagLineHolder">
                <div class="defaultContentWidth clearfix">
                    <p class="left info">University of Technology, Sydney - Analytics Capstone B - Alex Berriman (11012313)</p>
                    <ul class="social-icons right clearfix">
                        <li class="left"><a href="https://github.com/alexberriman/bookinnect" target="_blank"><img src="http://os.alfajango.com/images/github-icon.png" height="24" width="24" alt="Github" title="Github" /></a></li>
                    </ul>
                </div>
            </div>
        </div><!-- /topbar !-->
        
        <header id="branding" role="banner">
            <div class="defaultContentWidth clearfix">
                <div id="logo" class="left">
                    <a class="trademark" href="<?php print Yii::app()->controller->createUrl('site/index') ?>">
                        <img src="/images/logo.png" alt="logo" />
                    </a>
                </div>
                <nav id="access" role="navigation">
                    <h3 class="assistive-text">Main menu</h3>
                    <nav class="mainmenu">
                        <ul id="menu-main-menu" class="menu">
                            <li>
                                <a href="/">Home</a>
                            </li>
                            <li>
                                <a href="/genre" class="has-submenu">Genres</a>
                                <ul class="sub-menu">
                                    <?php foreach (Genre::model()->root()->alphabetical()->findAll() as $genre): ?>
                                        <li><?php print CHtml::link(CHtml::encode($genre->name), array('genre/view', 'id' => $genre->id)) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </nav>
            </div>
        </header><!-- /header !-->
        
        <div id="directory-search" data-interactive="yes">
			<div class="defaultContentWidth clearfix">
				<form action="" id="dir-search-form" method="get" class="dir-searchform">
                    <div id="dir-search-inputs">
                        <div id="dir-holder">
                            <div class="dir-holder-wrap">
								<input type="text" name="s" id="dir-searchinput-text" placeholder="Search keyword..." class="dir-searchinput">
							</div>
                            <div class="clearfix"></div>
						</div>
                    </div>
                    <div id="dir-search-button">
                        <input type="submit" value="Search" class="dir-searchsubmit">
                    </div>
                    <input type="hidden" name="dir-search" value="yes">
                </form>
			</div>
		</div>
        
        <div id="main" class="defaultContentWidth">
            <div id="wrapper-row">
                <div id="primary">
                    <?php echo $content; ?>
                </div>
                <div id="secondary" class="widget-area">
                    <aside class="widget widget_search">
                        <form role="search" method="get" id="searchform" class="searchform" action="">
                            <div>
                                <label class="screen-reader-text" for="s">Search for:</label>
                                <input type="text" value="" name="s" id="s">
                                <input type="submit" id="searchsubmit" value="Search">
                            </div>
                        </form>
                    </aside>
                </div>
            </div>
        </div>

    </div><!-- /page -->
</body>
</html>
