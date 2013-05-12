<?php
/*
Plugin Name: ID Archives
Plugin URI: http://paperbo.at/
Description: This plugin displays archives in a list.
Author: Indranil Dasgupta
Version: 0.4.2
Author URI: http://paperbo.at/
*/

// Archives to my liking
function id_archives()
{
	// First, let's find the oldest post...
	$first_post = get_posts('showposts=1&post_status=publish&order=ASC');

	if ($first_post) {
		$first_post = $first_post[0];

		$first_date = $first_post->post_date;
		list($first_year, $first_month, $etc) = explode('-', $first_date);
		$current_year = date('Y');

		$output = '<div class="idarchives">';
		for ($y = $first_year; $y <= $current_year; $y++) {
			
			$output .= '<p><strong><a href="'.get_year_link($y).'">'.$y.'</a></strong>';
			
			// let's go through all the months?
			for($m = 1; $m <= 12; $m++) {
				// let's see if the month has posts or not?
				$m_posts = query_posts('year='.$y.'&monthnum='.$m);
				if ($m_posts) {
					$output .= '<span><a href="'.get_month_link($y, $m).'">'.date('M',mktime(0,0,0,$m,1,$y)).'</a></span>';
				} else {
					$output .= '<span>'.date('M',mktime(0,0,0,$m,1,$y)).'</span>';
				}
			}
			
			$output .= '</p>';
		}
		$output .= '</div><!-- /idarchives -->';
		
		return $output;
	} else {
		// No posts!
		return FALSE;
	}

}

// Shortcode
// [id-archives]
function id_arch_shortcode($atts)
{
	return id_archives();
}
add_shortcode( 'id-archives', 'id_arch_shortcode' );

