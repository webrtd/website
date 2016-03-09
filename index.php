<?php
//phpinfo();
	require_once 'config.php';
	require_once 'config_terms.php';
	require_once './includes/logic.php';
	require_once './includes/cache.php';
	require_once './includes/sessionhandler.php';

	include './wordpress/wp-load.php';

	if (defined("FORCE_SECURE_CONNECTION") && FORCE_SECURE_CONNECTION)
	{
		if (empty($_SERVER['HTTPS']))
		{
			header("location: https://{$_SERVER['SERVER_NAME']}");
            header('Content-Type: text/html; charset=utf-8');
			die();
		}
	}    
       
    global $current_user,$post;
	$plugins = array();
    	        
	if(empty($_SESSION))
	{
        ?>
        <style>
        .menu-top-menu-container {display:none;}
        </style>
        <?php		  
	}
    
    if(isset($_GET['wid']))
    {
        $post = get_post($_GET['wid']);                 
	   $title = get_the_title($post->ID);
    }    
    else
    {
        $title = '--NOT SET--';    
    }

	function set_title($t)
	{
		global $title;
        if(isset($_GET['mid']) && $_GET['mid'] == '-1')
        {
		    $title = 'M&oslash;de';
        }
        else
        {
            $title = $t;
        }
	}

	function get_title()
	{ 
		global $title;
		return $title;
	}


	function plugin_register($keyword, $callback)
	{
		global $plugins;
		$plugins[$keyword] = $callback;
	}


	function sanitize_output($buffer)
	{
	    $search = array(
	        '/\>[^\S ]+/s', //strip whitespaces after tags, except space
	        '/[^\S ]+\</s', //strip whitespaces before tags, except space
	        '/(\s)+/s'  // shorten multiple whitespace sequences
	        );
	    $replace = array(
	        '>',
	        '<',
	        '\\1'
	        );
	    $buffer = preg_replace($search, $replace, $buffer);

	    return $buffer;
	}

	require_once './config_plugins.php';

	/*if (!session_start())
	{
		die("Error starting PHP session!");
	}*/


	setlocale(LC_ALL,RT_LOCALE);



  if (isset($_REQUEST['print']))
  {
    $template_html = file_get_contents(RT_TEMPLATE_PRINT);
  }
  else
  {
	$template_html = file_get_contents(RT_TEMPLATE);
  }

	foreach ($plugins as $keyword => $callback)
	{
		$value = $callback();
		$template_html = str_replace("%%$keyword%%", $value, $template_html);
	}

	logic_update_tracker();
	if (logic_is_member()) logic_update_last_page_view();

	$template_html = str_replace("%%TITLE%%", $title, $template_html);

	echo $template_html;

	// echo "<!---- ".print_r($_SESSION,true)."--->";

/*if(isset($_GET['aid']) && $_GET['aid'] == '15')
{ 
    header("location: http://dev.rtd.dk/?news"); //to redirect back to "index.php" after logging out
    exit();
}
else if(isset($_GET['aid']) && $_GET['aid'] == '13')
{
    header("location: http://dev.rtd.dk/?mummy"); //to redirect back to "index.php" after logging out
    exit();
}*/


if(is_user_logged_in())
{
    ?>
    <script>
    jQuery(document).ready(function($) {
                
		if(!$('#page-content').hasClass('not_home'))
		{
        	//$('.col-xs-12.home-right.desktop_left').insertBefore('#boxed .col-xs-12.col-md-10:eq(0)');
		}
		else
		{
			//$('.col-xs-12#banners.desktop_left').insertBefore('#boxed .col-xs-12.col-md-10:eq(0)');
		}

        $('#page-content').prev('div.col-md-10').prev('div.col-md-2').addClass('firsadvert');

        if(!$('body').hasClass('not-loggin')) {
            if($('.col-sm-4.col-md-2').hasClass('home-right')) {
                $('.container-light.statistik .col-xs-12.random_mem').insertBefore('div.firsadvert .banner2');
            }
            else
            {
                $('.container-light.statistik .col-xs-12.random_mem').insertBefore('.col-sm-4.col-md-2 .banner2');
            }
        }

        if($('.col-sm-4.col-md-2').hasClass('home-right')) {
            $('body').addClass('homepage');
        }

        if(jQuery('#page-content .container #latestmemberss').hasClass('container-image'))
        {
            jQuery('body').addClass('homepage');
        }
        
        if(jQuery('.homepage .news-page .post-content .text img').length > 0)
        {
        jQuery(document).on('click','.homepage .news-page .post-content .text img',function(){
            var hrf = $(this).parent('p').parent('div.text').prev('.title').children('h2').children('a').attr('href');
            if(hrf != '')
            {
            window.location = hrf;
            }
        });
        }
        
        jQuery(document).on('click','.homepage #content .title-section > .fa-plus',function(){
            jQuery('.homepage #content .title-section > .fa-plus').addClass('fa-minus');
            jQuery('.homepage #content .title-section > .fa-plus').removeClass('fa-plus');
            jQuery('.homepage #content .title-section > .fa-minus p').text('Skjul aktuelt');
            jQuery('#notify_build').slideToggle('slow');
        });
        
        jQuery(document).on('click','.homepage #content .title-section > .fa-minus',function(){
            jQuery('.homepage #content .title-section > .fa-minus').addClass('fa-plus');
            jQuery('.homepage #content .title-section > .fa-minus').removeClass('fa-minus');
            jQuery('.homepage #content .title-section > .fa-plus p').text('Vis aktuelt');
            jQuery('#notify_build').slideToggle('slow');
        });
        
        if($('.meeting_technog h3.metting_title').length > 0)
        {
            var nxt = $('.meeting_technog h3.metting_title').next();

            if(nxt.length <= 0)
            {
                $('.meeting_technog h3.metting_title').hide();
            }
        }

    });
    </script>

    <style>
    .nivoSlider img{height:497px !important;}
    /*.page_content #banners.col-md-2, .page_content .col-xs-12.col-md-10 #content .col-md-2.home-right {display:none !important;}
    #page-content .container #banners.col-md-2, #page-content .container .col-xs-12.col-md-10 #content .col-md-2.home-right {display:none !important;}
    .user_pages #page-content .container #banners.col-md-2 {display:block !important;}
	#page-content .container .col-md-2.home-right, .page_content .col-md-2.home-right {display:none !important;}*/
    /*#page-content .container .page-slider-wrap {display:none !important;}
    #page-content .container .right-part .grid-wrap #projects {margin-left:-80px !important;}*/

	#content .title-section h1 {clear:both;}
    object embed {width:350px; height:200px;}
    #latestmemberss {clear:both;}
    </style>
    <?php
}
else
{
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('body').addClass('not-loggin');
        $('.container .right-part').addClass('col-xs-12 col-sm-8 col-md-10');
    });
    </script>
    <?php
}

if(isset($_GET['country']))
{
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('body').addClass('country_pages');

        $(document).on('click','#country_future_minutes li .slotholder .tp-bgimg',function(){
            var href = $(this).parent('.slotholder').parent('li').data('href');
            window.location = '/'+href;
        });
    });
    </script>
    <?php
}

if(isset($_GET['uid']))
{
    ?>   
    <script>
    jQuery(document).ready(function(){
        $('body').addClass('user_pages homepage');
        jQuery('#page-content .container .col-md-10:eq(0) .meetstatistic_data').insertAfter("#page-content");
        jQuery('#page-content .container .col-md-10:eq(0) .container.container-image').insertAfter(".container.container-light:eq(0)");

        if($('.userpage li a.facebook').attr('href') == '')
        {
            $('.userpage li a.facebook').hide();
        }
        if($('.userpage li a.linkedin').attr('href') == '')
        {
            $('.userpage li a.linkedin').hide();
        }
        if($('.userpage li a.twitter').attr('href') == '')
        {
            $('.userpage li a.twitter').hide();
        }

        if($('.userpage li a.facebook').attr('href') == '' && $('.userpage li a.facebook').attr('href') == '' && $('.userpage li a.twitter').attr('href') == '')
        {
            $('ul.userpage').hide();
        }
    })
    </script>
    <?php
}
else
{
    if(is_user_logged_in()) {
    ?>
    <script>
    jQuery(document).ready(function(){
        //jQuery('#page-content .container .col-md-10:eq(0)').wrap("<div class='page_content'></div>");
        //jQuery('#page-content .container .page_content').insertBefore('#page-content');
    })
    </script>
    <?php
    }
}

if(isset($_GET['cal']))
{
    ?>
    <style>
    /*#page-content.not_home {width:80%; display:block; padding:0 0 0 10px;}
    #banners + .col-xs-12.col-md-10 {display:none;}*/
    </style>
    <?php
}

if(isset($_GET['cid']))
{
    ?>
    <script>
    $(document).ready(function(e) {
        if($('.club_social li a.mail').attr('href') == '')
        {
            $('.club_social li a.mail').hide();
        }
        if($('.club_social li a.linkedin').attr('href') == '')
        {
            $('.club_social li a.linkedin').hide();
        }
        if($('.club_social li a.twitter').attr('href') == '')
        {
            $('.club_social li a.twitter').hide();
        }

        if($('.club_social li a.mail').attr('href') == '' && $('.club_social li a.linkedin').attr('href') == '' && $('.club_social li a.twitter').attr('href') == '')
        {
            $('ul.country_social').hide();
        }
    });

    $(window).load(function(){
       $('.page_content .col-xs-12 .container.clubpg_last_sec').insertAfter('#page-content .container');
    });
    </script>
    <?php
}
?>

<script type="text/javascript">
$(window).load(function(){
    $('.menu-top-menu-container').show();
    menu_coten();        
    $('#main-menu ul.sub-menu').show();
});

function menu_coten()
{
    $('ul#main-menu li').each(function(index, element) {
        var title = jQuery(this).children('a').attr('title');
        if($(this).hasClass('menu-item-has-children'))
        {
            if(title != '' && typeof title != 'undefined')
            {
                jQuery(this).children('a').append('<i class="carret"></i><span>'+title+'</span>');
            }
            else
            {
                jQuery(this).children('a').append('<i class="carret"></i>');
            }
        }
        else
        {
            if(title != '' && typeof title != 'undefined')
            {
                jQuery(this).children('a:eq(0)').append('<span>'+title+'</span>');
            }
        }
    });
}
</script>

<script>
jQuery(document).ready(function($) {
    var hre = $('.user-nav li a.btn-lg').attr('href');   
    console.log($('.index').hasClass('homepage'));
    if($('.index').hasClass('homepage') && hre == '#login-register')
    {                 
        window.location = "/";
        return false;
    } 
    else
    {
        $('.menu-top-menu-container').show();
    }
});
</script>

<?php
if(isset($_GET['country']))
{
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('.col-md-10:eq(0) .page-slider-wrap').hide();
        $('.page_content .tp-banner-container').insertAfter('.col-md-10:eq(0) .page-slider-wrap');


        if($('.country_social li a.facebook').attr('href') == '')
        {
            $('.country_social li a.facebook').hide();
        }
        if($('.country_social li a.linkedin').attr('href') == '')
        {
            $('.country_social li a.linkedin').hide();
        }
        if($('.country_social li a.twitter').attr('href') == '')
        {
            $('.country_social li a.twitter').hide();
        }

        if($('.country_social li a.facebook').attr('href') == '' && $('.country_social li a.linkedin').attr('href') == '' && $('.country_social li a.twitter').attr('href') == '')
        {
            $('ul.country_social').hide();
        }
    });
    </script>
    <?php
}

if(isset($_GET['aid']))
{
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('body').addClass('article_pages');
    });
    </script>
    <?php
    if(!is_user_logged_in())
    {
        ?>        
        <script> 
        jQuery(document).ready(function($) {            
            //$('#page-content .container .row .col-sm-12:eq(0)').hide();
        });
        </script>
        <style>
        .article_pages #page-content .container .row .col-sm-12 #content .title.title-section {display:none;}
        .article_pages #page-content .container .row .col-xs-12.col-md-10 {float:none; width:95%;}
        </style>
        <?php
    }
}

if($_SERVER['REQUEST_URI'] == "/?mummy" && !is_user_logged_in())
{
    ?>
    <style>
    .not-loggin #page-content .container .row .col-sm-12 #content .title.title-section {display:none;}
    .not-loggin #page-content .container .row .col-xs-12.col-md-10 {float:none; width:95%;}
    </style>
    <?php
}

if(isset($_GET['wid']))
{
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('#boxed .page_content').addClass('wp_page');
    });
    </script>
    <?php
    if(!is_user_logged_in())
    {
       ?>      
        <script>
        jQuery(document).ready(function($) {  
            $('.not-loggin #boxed .page-slider-wrap').remove();          
            //$('.not-loggin #page-content .container .row .col-sm-12:eq(0)').hide();
        });
        </script>
        <?php 
    }
}

if(isset($_GET['search']))
{
    if(!is_user_logged_in())
    {
       ?>
        <script>
        jQuery(document).ready(function($) { 
            $('.not-loggin #boxed .page-slider-wrap').remove();             
            $('.not-loggin #page-content .container .row .col-sm-12:eq(0)').hide();
        });
        </script>
        <?php 
    }
}
?>
    

<script>
  $(function() {
        $(window).scroll(function(){
            
         if ($(this).scrollTop() >= 1800 && $(this).scrollTop() <= 3200){
         if(!$('.meetstatistic tr td .skill .bar').hasClass('animated_done')) {
            $('.meetstatistic tr td .skill .bar').each(function(index, element) {
                $(this).addClass('animated_done');
                var main_val = '';
                if($(this).data('value') > 100)
                { 
                    main_val = 100;
                }
                else
                { 
                    main_val = $(this).data('value');      
                } 
                
                var length = parseInt(main_val)+'%';
                var txt_val = $(this).data('value')+'%';
                $(this).text(txt_val);
                $(this).animate({
                  backgroundColor: "#007aff",
                  color: "#fff",
                  width: length,
                }, 'fast' );
            });
         }
         }
    });
  });
  </script>
 
  