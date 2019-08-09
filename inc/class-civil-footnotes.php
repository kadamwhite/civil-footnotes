<?php
/**
 * Encapsulate footnotes in a class
 */
class Civil_Footnotes {
	/**
	 * Constructor.
	 */
	public function __construct() {
		// Hook me up
		add_action( 'the_content', array( $this, 'process' ), 11 );
	}

	/**
	 * Searches the text and extracts footnotes.
	 * Adds the identifier links and creats footnotes list.
	 * @param $data string The content of the post.
	 * @return string The new content with footnotes generated.
	 */
	public function process( $data ) {
		global $post;

		// Check for and setup the starting number
		$start_number = ( preg_match( '|<!\-\-startnum=(\d+)\-\->|', $data, $start_number_array ) === 1 ) ?
			$start_number_array[1] :
			1;

		// Regex extraction of all footnotes (or return if there are none)
		if ( ! preg_match_all( '/(' . preg_quote( WP_FOOTNOTES_OPEN, '/' ) . '|<footnote>)(.*)(' . preg_quote( WP_FOOTNOTES_CLOSE, '/' ) . '|<\/footnote>)/Us', $data, $identifiers, PREG_SET_ORDER ) ) {
			return $data;
		}

		$display = true;

		$footnotes = array();

		// Create 'em
		$identifier_count = count( $identifiers );
		for ( $i = 0; $i < $identifier_count; $i++ ) {
			// Look for ref: and replace in identifiers array.
			if ( substr( $identifiers[ $i ][2], 0, 4 ) === 'ref:' ) {
				$ref                       = (int) substr( $identifiers[ $i ][2], 4 );
				$identifiers[ $i ]['text'] = $identifiers[ $ref - 1 ][2];
			} else {
				$identifiers[ $i ]['text'] = $identifiers[ $i ][2];
			}

			if ( ! isset( $identifiers[ $i ]['use_footnote'] ) ) {
				// Add footnote and record the key
				$identifiers[ $i ]['use_footnote']                                  = count( $footnotes );
				$footnotes  [ $identifiers[ $i ]['use_footnote'] ]['text']          = $identifiers[ $i ]['text'];
				$footnotes  [ $identifiers[ $i ]['use_footnote'] ]['symbol']        = ( array_key_exists( 'symbol', $identifiers[ $i ] ) ) ?
					$identifiers[ $i ]['symbol'] :
					'';  // Bugfix submitted by Greg Sullivan
				$footnotes  [ $identifiers[ $i ]['use_footnote'] ]['identifiers'][] = $i;
			}
		}

		// Footnotes and identifiers are stored in the array

		$use_full_link = false;
		if ( is_feed() ) {
			$use_full_link = true;
		}

		if ( is_preview() ) {
			$use_full_link = false;
		}

		// Display identifiers
		$datanote = ''; // Bugfix submitted by Greg Sullivan
		foreach ( $identifiers as $key => $value ) {

			$id_num     = $value['use_footnote'] + $start_number;
			$id_id      = 'rf' . $id_num . '-' . $post->ID;
			$id_href    = ( ( $use_full_link ) ? get_permalink( $post->ID ) : '' ) . '#fn' . $id_num . '-' . $post->ID;
			$id_title   = str_replace( '"', '&quot;', htmlentities( html_entity_decode( wp_strip_all_tags( $value['text'] ), ENT_QUOTES, 'UTF-8' ), ENT_QUOTES, 'UTF-8' ) );
			$id_replace = sprintf(
				'<sup id="%1$d"><a href="%2$s" title="%3$s" rel="footnote">%4$d</a></sup>',
				esc_attr( $id_id ),
				esc_attr( $id_href ),
				esc_attr( $id_title ),
				esc_html( $id_num )
			);

			if ( $display ) {
				$data = substr_replace( $data, $id_replace, strpos( $data, $value[0] ), strlen( $value[0] ) );
			} else {
				$data = substr_replace( $data, '', strpos( $data, $value[0] ), strlen( $value[0] ) );
			}

			// Display the footnotes (here is where you can change the output)

			// Create each footnote
			$datanote = $datanote . sprintf(
				'<li id="fn%1$d-%2$d">' .
				'<p>%3$s&nbsp;' .
				'<a href="#%4$s" class="backlink" title="%5$s">&#8617;</a>' .
				'</p></li>',
				// %1$d: Number of the footnote being rendered (1-indexed).
				esc_attr( $id_num ),
				// %2$d: ID of the post being rendered.
				$post->ID,
				// %3$s: Footnote content.
				esc_html( $value['text'] ),
				// %4$s: HTML ID attribute of the footnote being rendered.
				esc_attr( $id_id ),
				// %5$s: User-facing messaging for the return link.
				sprintf(
					/* translators: %d: The number of the footnote to which to return. */
					__( 'Return to footnote %d.', 'civil-footnotes' ),
					esc_attr( $id_num )
				)
			);
		}

		// Create the footnotes
		foreach ( $footnotes as $key => $value ) {
			$data = $data . '<hr class="footnotes"><ol class="footnotes"'; // Before the footnotes
			if ( '1' !== $start_number ) {
				$data = $data . ' start="' . $start_number . '"';
			}
			$data = $data . '>';
			$data = $data . $datanote; // Don't change this
			$data = $data . '</ol>'; // After the footnotes

			return $data;
		}
	}
}
