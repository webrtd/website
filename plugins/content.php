<?php
/*
    content plugin (c) 3kings.dk
    
    31-10-2012	rasmus@3kings.dk	draft
    02-11-2012	rasmus@3kings.dk	rewritten as plugin based
*/

$query_age = (isset($_GET['aid']) ? $_GET['aid'] : null);
$query_age1 = (isset($_GET['wid']) ? $_GET['wid'] : null);

//if(($query_age != '' && $query_age != 15 && $query_age != 13 && $query_age != 17 && $query_age != 7 && $query_age != 18 && $query_age != 19 && $query_age != 20 && $query_age != 21 && $query_age != 22 && $query_age != 23 && $query_age != 24 && $query_age != 25) || isset($_GET['wid']))
if(isset($_GET['wid']))
{
    plugin_register('CONTENT', 'content');
    
    require_once './plugins/content_plugins/wp_page.php';    
}
else
{
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) header("location: /");
	
	plugin_register('CONTENT', 'content');
	
	

	$content_plugins = array();
	$content_title = array();

	function content_plugin_register($keyword, $callback, $title='')
	{ 
		global $content_plugins;
		global $content_title;
        
		$content_plugins[$keyword] = $callback;
		$content_title[$keyword] = $title;                
	}
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config_content_plugins.php';

	// handle content pane	
	function content()
	{		
		global $content_plugins;
		global $content_plugin_default;
		global $content_title;
		
		foreach ($content_plugins as $key => $callback)
		{
			if (isset($_REQUEST[$key])) 
			{
				set_title($content_title[$key]);
				return $callback();
			}
		}
        $test = $content_plugins[$content_plugin_default];

		return $content_plugins[$content_plugin_default]();
	}
}
/*CUSTOM START*/

plugin_register('MEDLEMMER_COUNT', 'Medlemmer_count');
function Medlemmer_count()
{ 
	return fetch_num_active_roles("and R.rid=".MEMBER_ROLE_RID);
}

plugin_register('HONORARY_COUNT', 'honorary_count');
function honorary_count()
{ 
	return fetch_num_active_roles("and R.rid=".HONORARY_ROLE_RID);
}

plugin_register('NEWMEMBERS_COUNT', 'newmembers_count');
function newmembers_count()
{ 
$ys = logic_get_club_year_start();

	return fetch_num_active_roles("and R.rid=".MEMBER_ROLE_RID." and R.start_date>='$ys'");
}

plugin_register('LEAVINGMEMBERS_COUNT', 'leavingmembers_count');
function leavingmembers_count()
{ 
$ys = logic_get_club_year_start();
$ye = logic_get_club_year_end();	
	return fetch_num_active_roles("and R.rid=".MEMBER_ROLE_RID." and (R.end_date>'$ys' and R.end_date='$ye')");
}

plugin_register('AVGAGE_COUNT', 'avgage_count');
function avgage_count()
{ 
	return round(fetch_avg_member_age("and profile_ended>now()"));
}

plugin_register('REVOLUTION_SLIDER', 'revolution_slider');
function revolution_slider()
{ 
    if(is_user_logged_in() && $_SERVER['REQUEST_URI'] == '/') 
    {
        $contet = '<div class="page-slider-wrap">'.do_shortcode('[rev_slider homepage]').'</div>';
    }
    else if(is_user_logged_in() && isset($_GET['country']))
    {        
        $contet = '<div class="page-slider-wrap" style="display:none;">'.do_shortcode('[rev_slider homepage]').'</div>';
    }
    else if(is_user_logged_in() && isset($_GET['cid']))
    {        
        $contet = '<div class="page-slider-wrap" style="display:none;">'.do_shortcode('[rev_slider homepage]').'</div>';
    }
    else if(is_user_logged_in() && $_SERVER['REQUEST_URI'] != '/' && !isset($_GET['country']) && !isset($_GET['cid']))
    { 
        $contet = '';       
        //$contet = '<div class="col-xs-12 col-sm-8 col-md-10"></div>';
    }
    else if(!is_user_logged_in())
    {
        $contet = '';
    }
    
    if(!isset($_GET['uid'])) {
	    return $contet;
    }
    else
    {
        return '';
    }
}	

plugin_register('LOGIN_BTN', 'login_btn');
function login_btn()
{   
global $current_user;
    $cont = '';
	if(is_user_logged_in() && isset($_SESSION['user'])) {         
            
		$cont = '<ul class="user-nav">
        <li><a style="color:#fff;" href="?uid='.$_SESSION['user']['uid'].'">'.$_SESSION['user']['profile_firstname']." ".$_SESSION['user']['profile_lastname'].'</a> | </li>  
        <li><a style="color:#fff;" href="?uid='.$_SESSION['user']['uid'].'&edit">Rediger</a> | </li>  
        <li><a style="color:#fff;" href="?cid='.$_SESSION['user']['cid'].'">Min klub</a></li>       
			<li><a class="btn btn-primary btn-lg" href="/?logout">Log af</a></li>
		</ul>';
	}
	else
	{  
	    wp_logout();
		session_destroy(); //destroy the session
		setcookie('RTD_LOGIN_COOKIE','');
		$cont = '<ul class="user-nav">
			<li><a class="btn btn-primary btn-lg" href="#login-register" data-toggle="modal" title="Log in">Log Ind</a></li>
		</ul>';
	}

	return $cont;
}	

plugin_register('HOMECONTENT', 'homecontent');
function homecontent()
{
    global $current_user;
    $content = '';
    if(!is_user_logged_in()) { 
        $content = get_field('home_content',13);
        ?>
        <style>
        .index .container .home_content {display:none;}
        </style>
        <?php 
    }
    else
    {
        ?>
        <style>
        .index #page-content .container .row:first-child {display:none;}
        </style>
        <?php 
    }
    return utf8_decode($content);
}

plugin_register('MOBILELOGIN', 'mobilelogin');
function mobilelogin()
{
    global $current_user;
    $cont = '';
	if(is_user_logged_in() && isset($_SESSION['user'])) {
    $cont .= "<ul id='mobile-menu'>
                <li><a href='/?logout'>Log ud</a></li>

                <li>
                    <button class='navbar-toggle' type='button' data-toggle='collapse' data-target='.navbar-collapse'>
                        <i class='fa fa-reorder'></i>
                    </button>
                </li>
                <li><a class='btn-search' href='#'><i class='fa fa-search'></i></a></li>
            </ul>";
    }
    else
    {  
        $cont .= "<ul id='mobile-menu'>
                <li><a href='#login-register' data-toggle='modal' title='Log in'>Log ind</a></li>

                <li>
                    <button class='navbar-toggle' type='button' data-toggle='collapse' data-target='.navbar-collapse'>
                        <i class='fa fa-reorder'></i>
                    </button>
                </li>
                <li><a class='btn-search' href='#'><i class='fa fa-search'></i></a></li>
            </ul>";
    }
    return $cont;
}

plugin_register('USERSIDEBAR', 'usersidebar');
function usersidebar()
{
    $cnt = '';
    if(isset($_GET['uid']) && is_user_logged_in())
    {
        
        $cnt .= '<div class="col-xs-12 col-sm-4 col-md-2 desktop_left" id="banners">
        %%BANNER_2%%
        %%BANNER_3%%
        </div>';
    }   
    return $cnt;
}

plugin_register('GENERALSIDEBAR', 'generalsidebar');
function generalsidebar()
{
    $cnt = '';
    if(!isset($_GET['uid']) && is_user_logged_in())
    {
        
        $cnt .= '<div class="col-xs-12 col-sm-4 col-md-2 desktop_left firsadvert" id="banners">
        %%BANNER_2%%
        %%BANNER_3%%
        </div>';
    }   
    return $cnt;
}

plugin_register('NTLOGINSLIDER', 'notloginslider');
function notloginslider()
{
    $cnt = '';
    if(!is_user_logged_in())
    {
        
        $cnt .= '<div class="page-slider-wrap">'.do_shortcode('[rev_slider homepage]').'</div>';
    }   
    return $cnt;
}

/*CUSTOM END*/

?>