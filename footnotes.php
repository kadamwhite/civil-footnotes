<?php
/*
Plugin Name: Civil Footnotes
Plugin URI: https://defomicron.net/projects/civil_footnotes/
Version: 1.0
Description: Parses and displays footnotes. Based on <a href="http://elvery.net/drzax/wordpress-footnotes-plugin">WP-Foonotes</a> by <a href="http://elvery.net">Simon Elvery</a>
Author: <a href="https://defomicron.net/colophon/">Austin Sweeney</a>
*/

// Some important constants
define('WP_FOOTNOTES_OPEN', " ((");  //You can change this if you really have to, but I wouldn't recommend it.
define('WP_FOOTNOTES_CLOSE', "))");  //Same with this one.
define('WP_FOOTNOTES_VERSION', '1.0');

// Instantiate the class
$swas_wp_footnotes = new swas_wp_footnotes();

// Encapsulate in a class
class swas_wp_footnotes {
	var $current_options;
	var $default_options;

	/**
	 * Constructor.
	 */
	function swas_wp_footnotes() {

		// Define the implemented option styles
		$this->styles = array(
			'decimal' => '1,2...10',
			'decimal-leading-zero' => '01, 02...10',
			'lower-alpha' => 'a,b...j',
			'upper-alpha' => 'A,B...J',
			'lower-roman' => 'i,ii...x',
			'upper-roman' => 'I,II...X',
			'symbol' => 'Symbol'
		);

		// Hook me up
		add_action('the_content', array($this, 'process'), 11);
	}


	/**
	 * Searches the text and extracts footnotes.
	 * Adds the identifier links and creats footnotes list.
	 * @param $data string The content of the post.
	 * @return string The new content with footnotes generated.
	 */
	function process($data) {
		global $post;

		// Check for and setup the starting number
		$start_number = (preg_match("|<!\-\-startnum=(\d+)\-\->|",$data,$start_number_array)==1) ? $start_number_array[1] : 1;

		// Regex extraction of all footnotes (or return if there are none)
		if (!preg_match_all("/(".preg_quote(WP_FOOTNOTES_OPEN)."|<footnote>)(.*)(".preg_quote(WP_FOOTNOTES_CLOSE)."|<\/footnote>)/Us", $data, $identifiers, PREG_SET_ORDER)) {
			return $data;
		}

		$display = true;

		$footnotes = array();

		$style = 'decimal';

		// Create 'em
		for ($i=0; $i<count($identifiers); $i++){
			// Look for ref: and replace in identifiers array.
			if (substr($identifiers[$i][2],0,4) == 'ref:'){
				$ref = (int)substr($identifiers[$i][2],4);
				$identifiers[$i]['text'] = $identifiers[$ref-1][2];
			}else{
				$identifiers[$i]['text'] = $identifiers[$i][2];
			}

			// if we're combining identical notes check if we've already got one like this & record keys
				for ($j=0; $j<count($footnotes); $j++){
					if ($footnotes[$j]['text'] == $identifiers[$i]['text']){
						$identifiers[$i]['use_footnote'] = $j;
						$footnotes[$j]['identifiers'][] = $i;
						break;
					}
				}



			if (!isset($identifiers[$i]['use_footnote'])){
				// Add footnote and record the key
				$identifiers[$i]['use_footnote'] = count($footnotes);
				$footnotes[$identifiers[$i]['use_footnote']]['text'] = $identifiers[$i]['text'];
				$footnotes[$identifiers[$i]['use_footnote']]['symbol'] = $identifiers[$i]['symbol'];
				$footnotes[$identifiers[$i]['use_footnote']]['identifiers'][] = $i;
			}
		}

		// Footnotes and identifiers are stored in the array

		$use_full_link = false;
		if (is_feed()) $use_full_link = true;

		if (is_preview()) $use_full_link = false;

		// Display identifiers
		foreach ($identifiers as $key => $value) {

			$id_num = ($style == 'decimal') ? $value['use_footnote']+$start_number : $this->convert_num($value['use_footnote']+$start_number, $style, count($footnotes));
			$id_id = "rf".$id_num."-".$post->ID;
			$id_href = ( ($use_full_link) ? get_permalink($post->ID) : '' ) . "#fn".$id_num."-".$post->ID;
			$id_title = str_replace('"', "&quot;", htmlentities(html_entity_decode(strip_tags($value['text']), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'));
			$id_replace = '<sup id="'.$id_id.'"><a href="'.$id_href.'"  title="'.$id_title.'">'.$id_num.'</a></sup>';
			if ($display) $data = substr_replace($data, $id_replace, strpos($data,$value[0]),strlen($value[0]));
			else $data = substr_replace($data, '', strpos($data,$value[0]),strlen($value[0]));

		// Display footnotes
			$datanote = $datanote.'<li id="fn'.$id_num.'-'.$post->ID.'"><p>';
			$datanote = $datanote.$value['text'];
			$datanote = $datanote.'&nbsp;<a href="#'.$id_id.'"';

			$datanote = $datanote.' class="backlink" title="Return to footnote '.$id_num.' in the text.">&#8617;</a></li>';

			}

		foreach ($footnotes as $key => $value) {
			$data = $data.'<hr><ol class="footnotes">'.$datanote.'</ol>';

		return $data;

		}
	}

	function upgrade_post($data){
		$data = str_replace('<footnote>',WP_FOOTNOTES_OPEN,$data);
		$data = str_replace('</footnote>',WP_FOOTNOTES_CLOSE,$data);
		return $data;
	}
}

?>