<?php
/*
Wordpress pages content
*/

//include "../../wordpress/wp-load.php";
function content()
{
    if(isset($_GET['aid']))
    {    
        global $post;
        $args = array(
            'post_type' => 'page',
            'meta_query' => array(
                    array(
                        'key' => 'page_id',
                        'value' => $_GET['aid'],
                        'compare' => '=' 
                    ),
                )
            );
        $post = get_posts($args);
		
		//echo "<pre>";
		//print_r($post);
        
		
        if($post)
        {
            $content1 = $post[0]->post_content;
            $content11 = apply_filters('the_content', $content1);
            
            $content = '';
            $content .= '<h2>'.get_the_title($post[0]->ID).'</h2>';    
            $content .= $content11;
            return $content;
        }
        else
        {
            $content = '';
            return $content;
        }
    }
    else if(logic_get_wp_page_id()!==false)
    {
       $post = get_post(logic_get_wp_page_id()); 
	          
        $content1 = $post->post_content;
        $content11 = apply_filters('the_content', $content1);
        
        $content = '';
        $content .= '<h2>'.get_the_title($post->ID).'</h2>';    
        $content .= $content11;
        return $content;
    }
    else
    {
        $content = '';
        return $content;
    }
}
