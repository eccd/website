<?php theme_print_sidebar('header-widget-area'); ?>


    <div class="art-shapes">
        
            </div>

<?php if (!theme_has_header_image()) : ?>
<div class="art-slider art-slidecontainerheader" data-width="1000" data-height="450">
    <div class="art-slider-inner">
<div class="art-slide-item art-slideheader0">


</div>
<div class="art-slide-item art-slideheader1">


</div>

    </div>
</div>
<?php endif; ?>


<?php if (!theme_has_header_image()) : ?>
<div class="art-slidenavigator art-slidenavigatorheader" data-left="1" data-top="1">
<a href="#" class="art-slidenavigatoritem"></a><a href="#" class="art-slidenavigatoritem"></a>
</div>
<?php endif; ?>



<?php if(theme_get_option('theme_header_show_headline')): ?>
	<?php $headline = theme_get_option('theme_'.(is_home()?'posts':'single').'_headline_tag'); ?>
	<<?php echo $headline; ?> class="art-headline">
    <a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a>
</<?php echo $headline; ?>>
<?php endif; ?>
<?php if(theme_get_option('theme_header_show_slogan')): ?>
	<?php $slogan = theme_get_option('theme_'.(is_home()?'posts':'single').'_slogan_tag'); ?>
	<<?php echo $slogan; ?> class="art-slogan"><?php bloginfo('description'); ?></<?php echo $slogan; ?>>
<?php endif; ?>





<?php if (theme_get_option('theme_use_default_menu')) { wp_nav_menu( array('theme_location' => 'primary-menu') );} else { ?><nav class="art-nav">
    <div class="art-nav-inner">
    <?php
	echo theme_get_menu(array(
			'source' => theme_get_option('theme_menu_source'),
			'depth' => theme_get_option('theme_menu_depth'),
			'menu' => 'primary-menu',
			'class' => 'art-hmenu'
		)
	);
	get_sidebar('nav'); 
?> 
        </div>
    </nav><?php } ?>

                    
