<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php Loader::element('header_required'); ?>
<link rel="stylesheet" type="text/css" href="<?php print $this->getStyleSheet('main.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php print $this->getStyleSheet('typography.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php print $this->getStyleSheet('slider_styles.css'); ?>" />
<!--
<script language="javascript" type="text/javascript" src="<?php print $this->getThemePath(); ?>/scripts/mootools-1.2.1-core.js"></script>
<script language="javascript" type="text/javascript" src="<?php print $this->getThemePath(); ?>/scripts/mootools-1.2-more.js"></script>
<script language="javascript" type="text/javascript" src="<?php print $this->getThemePath(); ?>/scripts/slideitmoo-1.1.js"></script>
-->
<script language="javascript" type="text/javascript">
	window.addEvents({
		'domready': function(){
			/* thumbnails example , div containers */
			new SlideItMoo({
						overallContainer: 'SlideItMoo_outer',
						elementScrolled: 'SlideItMoo_inner',
						thumbsContainer: 'SlideItMoo_items',		
						itemsVisible: 4,
						elemsSlide: 2,
						duration: 300,
						itemsSelector: '.SlideItMoo_element',
						itemWidth: 204,
						showControls:1});
		},
		
	});
</script>

</head>
<body>

<div id="templatemo_body_wrapper">
	<div id="templatemo_wrapper">
    	
        <div id="templatemo_header">
            <div id="site_title"><h1><a href="<?php echo DIR_REL?>/">
            <?php     
  				$block = Block::getByName('My_Site_Name');
  				if($block && $block->bID) $block->display();
  				else echo SITE;
  			?>
  			</a></h1></div>
            <div id="templatemo_menu">
    <?php
    $bt_nav = BlockType::getByHandle('autonav');
    $bt_nav->controller->displayPages = 'top';
    $bt_nav->controller->orderBy = 'display_asc';
    $bt_nav->controller->displaySubPages = 'none';
    $bt_nav->render('view');
    ?>
            </div> <!-- end of templatemo_menu -->
        </div><!-- end of header -->
        
        <div id="templatemo_middle">
            <div id="mid_left">
                <div id="mid_title">Lorem ipsum dolor sit amet</div>
                <p>Sectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<p>nostrud exercitation ullamco laboris nisi ut aliquip exa com consequat. Duis aute irure dolor in reprehenderit.</p>
                <a href="http://www.templatemo.com/page/1" class="viewall"></a>
            </div>
            <img src="images/templatemo_icon_01.png" alt="free for job" />
        </div> <!-- end of middle -->
        
        <div id="templatemo_main">
            
            <div class="cbox_fw">
            	<div class="cbox_large float_l">
    <?php
    $a = new Area('Main');
    $a->display($c);
    ?>
    <div class="cleaner h20"></div>
    				<div class="cbox_small float_l">
    <?php
    $a = new Area('U Main L');
    $a->display($c);
    ?>
					</div>
                    <div class="cbox_small float_r">
    <?php
    $a = new Area('U Main R');
    $a->display($c);
    ?>
    				</div>
                </div>
                <div class="cbox_small float_r">
    <?php
    $a = new Area('Sidebar');
    $a->setBlockWrapperStart('<div>');
    $a->setBlockWrapperEnd('</div>');
    $a->display($c);
    ?>
                </div>
                <div class="cleaner"></div>
            </div>
            
        </div> <!-- end of main -->
        
        <div id="latest_works">
        	<h2>Old Design Collection</h2>
            <div id="SlideItMoo_outer">	
                <div id="SlideItMoo_inner">			
                    <div id="SlideItMoo_items">
                        <div class="SlideItMoo_element">
                        	<span></span>
                                <a href="http://www.templatemo.com/page/1" target="_parent">
                                <img src="images/gallery/01.jpg" alt="product 1" /></a>
                        </div>	
                        <div class="SlideItMoo_element"><span></span>
                                <a href="http://www.templatemo.com/page/2" target="_parent">
                                <img src="images/gallery/04.jpg" alt="product 1" /></a>
                        </div>
                        <div class="SlideItMoo_element"><span></span>
                                <a href="http://www.templatemo.com/page/3" target="_parent">
                                 <img src="images/gallery/03.jpg" alt="product 1" /></a>
                        </div>
                        <div class="SlideItMoo_element"><span></span>
                                <a href="http://www.templatemo.com/page/4" target="_parent">
                                <img src="images/gallery/02.jpg" alt="product 1" /></a>
                        </div>
                        <div class="SlideItMoo_element"><span></span>
                                <a href="http://www.templatemo.com/page/5" target="_parent">
                               <img src="images/gallery/05.jpg" alt="product 1" /></a>
                        </div>
                        <div class="SlideItMoo_element"><span></span>
                                <a href="http://www.templatemo.com/page/6" target="_parent">
                                <img src="images/gallery/06.jpg" alt="product 1" /></a>
                        </div>
                    </div>			
                </div>
			</div> 
            <a href="#" class="more float_r"><span>&gt;&gt;</span> View More</a>
      	</div> <!-- end of templatemo_middle -->
    
    </div>
</div>

<div id="templatemo_footer_wrapper">
    <div id="templatemo_footer">
        Copyright © <?php print date('Y') . ' ' . SITE; ?> <a href="#">Your Company Name</a> | Designed by <a href="http://www.templatemo.com" target="_parent">Free CSS Templates</a>
        <div class="cleaner"></div>
    </div>
</div>
<?php Loader::element('footer_required'); ?>
</body>
</html>