<?php
/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/


add_filter( 'wp_nav_menu_items', 'add_search_to_nav', 10, 2 );

function add_search_to_nav( $items, $args )
{
    $items .= '<li class="search-nav" style="padding-bottom: 30px;">
                <a class="btn-search" href="#"><i class="fa fa-search"></i></a>
            </li>';
    return $items;
}

function menu_item()
{
    return wp_nav_menu(array('menu' => 'top-menu', 'echo' => 0, 'menu_class' => 'collapse navbar-collapse nav slide', 'menu_id' => 'main-menu'));
}

function append_query_string( $url, $post, $leavename ) {
   
	if ( $post->post_type == 'post' ) {
		
		// $url = add_query_arg( 'foo', 'bar', $url );
		$url = str_replace('/wordpress/?p','?wid', $url);
	//	echo $url;die;
	}    
    
	return $url;
}
//add_filter( 'post_link', 'append_query_string', 10, 3 );


function append_query_string2( $url, $post ) {
    if ( 'post' == get_post_type( $post ) ) {
		
        return add_query_arg( $_GET, $url );
    }
	echo $url;die;
    return $url;
}
//add_filter( 'post_type_link', 'append_query_string2', 10, 2 );

function append_query_string3($url) {
	echo $url;die;
    return add_query_arg($_GET, $url);
}
//add_filter('the_permalink', 'append_query_string3');


function jb_modify_blog_url( $url, $post, $leavename ) {
$true = false;
// don't do it in the admin, I'm afraid the modified URL will get
// added to the URL slug field on the Edit Page screen, and get
// permanently added, with another copy of it being added every time
// the page is saved.
$test = get_post($post);

if( $test->post_type == 'page' ) {
$url = str_replace('/wordpress/?page_id','?wid', $url);
}

return $url;
}
add_filter( 'page_link', 'jb_modify_blog_url', 10, 3 );


function remove_head_scripts() { 
   remove_action('wp_head', 'wp_print_scripts'); 
   remove_action('wp_head', 'wp_print_head_scripts', 9); 
   remove_action('wp_head', 'wp_enqueue_scripts', 1);

   add_action('wp_footer', 'wp_print_scripts', 5);
   add_action('wp_footer', 'wp_enqueue_scripts', 5);
   add_action('wp_footer', 'wp_print_head_scripts', 5); 
} 
add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );

// END Custom Scripting to Move JavaScript

/*add_role( 'medlem', 'Medlem', array( 'read' => true, 'level_0' => true ) );
add_role( 'xmedlem', 'Xmedlem', array( 'read' => true, 'level_0' => true ) );
add_role( 'orlov', 'Orlov', array( 'read' => true, 'level_0' => true ) );
add_role( 'mumie', 'Mumie', array( 'read' => true, 'level_0' => true ) );
add_role( 'klubformand', 'Klubformand', array( 'read' => true, 'level_0' => true ) );
add_role( 'klubsekretær', 'Klubsekretær', array( 'read' => true, 'level_0' => true ) );
add_role( 'inspektør', 'Inspektør', array( 'read' => true, 'level_0' => true ) );
add_role( 'kasserer', 'Kasserer', array( 'read' => true, 'level_0' => true ) );
add_role( 'næstformand', 'Næstformand', array( 'read' => true, 'level_0' => true ) );
add_role( 'distriktsformand', 'Distriktsformand', array( 'read' => true, 'level_0' => true ) );
add_role( 'landsformand', 'Landsformand', array( 'read' => true, 'level_0' => true ) );
add_role( 'vicelandsformand', 'Vicelandsformand', array( 'read' => true, 'level_0' => true ) );
add_role( 'IRO', 'IRO', array( 'read' => true, 'level_0' => true ) );
add_role( 'NIRO', 'NIRO', array( 'read' => true, 'level_0' => true ) );
add_role( 'landssekretær', 'Landssekretær', array( 'read' => true, 'level_0' => true ) );
add_role( 'webmaster', 'Webmaster', array( 'read' => true, 'level_0' => true ) );
add_role( 'landskasserer', 'Landskasserer', array( 'read' => true, 'level_0' => true ) );
add_role( 'redaktør', 'Redaktør', array( 'read' => true, 'level_0' => true ) );
add_role( 'shopkeeper', 'Shopkeeper', array( 'read' => true, 'level_0' => true ) );
add_role( 'Æresmedlem', 'Æresmedlem', array( 'read' => true, 'level_0' => true ) );
add_role( 'afgående_landsformand', 'Afgående Landsformand', array( 'read' => true, 'level_0' => true ) );
add_role( 'landsarkivar', 'Landsarkivar', array( 'read' => true, 'level_0' => true ) );*/