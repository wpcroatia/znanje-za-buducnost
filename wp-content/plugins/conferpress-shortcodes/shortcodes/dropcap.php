<?php
function parse_leaf_dropcap($atts, $content){
	$html = '<span class="dropcap font-2">'.$content.'</span>';
	return $html;
}
add_shortcode( 'dropcap', 'parse_leaf_dropcap' );




















