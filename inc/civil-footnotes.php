<?php
/**
 * Encapsulate footnotes in a class
 */

namespace Civil_Footnotes;

use Civil_Footnotes\Formats;

/**
 * Connect namespace methods to WordPress hooks.
 *
 * @return void
 */
function setup() {
	add_action( 'the_content', __NAMESPACE__ . '\\process_footnote', 11 );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\maybe_enqueue_symbols_css' );
}

function maybe_enqueue_symbols_css() {
	if ( 'symbol' !== Formats\get_style() ) {
		return;
	}

	// Enqueue the stylesheet that adds support for footnote symbol markers.
	wp_enqueue_style(
		'civil-footnotes',
		plugins_url( 'assets/footnotes.css', dirname( __FILE__ ) ),
		[],
		CIVIL_FOOTNOTES_VERSION
	);
}

/**
 * Render the <sup> tag for a given footnote object.
 *
 * @param array $footnote Footnote associative data array.
 * @return string Rendered <sup> tag.
 */
function render_footnote_sup_tag( $footnote ) : string {
	return sprintf(
		'<sup id="%1$s"><a href="%2$s" title="%3$s" rel="footnote">%4$s</a></sup>',
		esc_attr( $footnote['ref_id'] ),
		esc_attr( $footnote['fn_href'] ),
		esc_attr( $footnote['content'] ),
		esc_html( $footnote['symbol'] )
	);
}

/**
 * Render the <li> tag for a given footnote object.
 *
 * @param array $footnote Footnote associative data array.
 * @return string Rendered <li> tag.
 */
function render_footnote_li_tag( $footnote ) : string {
	// If we are using symbols, we want to add a data-attribute to each <li>
	// which can be used to control the marker rendered :before the element.
	$using_symbols = 'symbol' === Formats\get_style();

	return sprintf(
		'<li id="%1$s">' .
		'<p %2$s>%3$s' .
		'&nbsp;<a href="%4$s" class="backlink" title="%5$s">&#8617;</a>' .
		'</p></li>',
		// %1$s: HTML ID attribute of the footnote <li> being rendered.
		esc_attr( $footnote['fn_id'] ),
		// %2$s: Maybe a data-symbol attribute, maybe the empty string.
		$using_symbols ? sprintf( 'data-symbol="%s"', esc_attr( $footnote['symbol'] ) ) : '',
		// %3$s: Footnote content.
		esc_html( $footnote['content'] ),
		// %4$s: HTML href attribute pointing back to the footnote <sup> tag.
		esc_html( $footnote['ref_href'] ),
		// %5$s: User-facing messaging for the return link.
		sprintf(
			/* translators: %s: The symbol or number of the footnote to which to return. */
			__( 'Return to footnote %s.', 'civil-footnotes' ),
			esc_attr( $footnote['symbol'] )
		)
	);
}

/**
 * Searches the text and extracts footnotes.
 * Adds the identifier links and creats footnotes list.
 * @param string $content The content of the post.
 * @return string The new content with footnotes generated.
 */
function process_footnote( $content ) {
	global $post;

	// Derive values necessary for link generation. Use full permalink in feed context.
	$permalink = is_feed() ? get_permalink( $post->ID ) : '';
	$post_id   = $post->ID;

	// Detect & process footnotes within the page content.
	$footnotes       = [];
	$footnote_number = 1;
	$mutated_content = preg_replace_callback(
		// Match footnotes surrounded by `(())` or by `<footnote></footnote>`.
		'/\s?(?:\(\(|<footnote>)(.*)(?:\)\)|<\/footnote>)/Us',
		/**
		 * For each regex match, replace the footnote placeholder with a <sup> tag
		 * and store footnote information for list generation below.
		 * @param array $match The regex match.
		 * @return string The replacement string.
		 */
		function( $match ) use ( &$footnotes, &$footnote_number, $permalink, $post_id ) : string {
			// Store footnote content so we can generate the list at the end of the post.
			$footnote = [
				'content' => $match[1],
				'fn_id'   => sprintf( 'fn%d-%d', $footnote_number, $post_id ),
				'ref_id'  => sprintf( 'rf%d-%d', $footnote_number, $post_id ),
				'number'  => $footnote_number,
				'symbol'  => Formats\format( $footnote_number ),
			];

			// Derive the href properties from the appropriate IDs.
			$footnote['fn_href']  = sprintf( '%s#%s', $permalink, $footnote['fn_id'] );
			$footnote['ref_href'] = sprintf( '%s#%s', $permalink, $footnote['ref_id'] );

			// Store footnote in footnotes array.
			$footnotes[] = $footnote;

			// Increment the current footnote number in preparation for subsequent notes.
			$footnote_number++;

			// Replace the footnote placeholder with the superscript indicator.
			return render_footnote_sup_tag( $footnote );
		},
		$content
	);

	// If we do not believe any transformation has occurred, take no further action.
	if ( 1 === $footnote_number || $content === $mutated_content ) {
		return $content;
	}

	// Render footnotes list content.
	$footnote_li_tags = array_reduce(
		$footnotes,
		/**
		 * Generate a rendered <li> item string for each footnote.
		 *
		 * @param string $li_tags  String to which we will concatenate each <li> tag.
		 * @param array  $footnote Footnote item from preg_replace_callback, above.
		 * @return string A rendered <li> string for this footnote.
		 */
		function( string $li_tags, array $footnote ) : string {
			return $li_tags . render_footnote_li_tag( $footnote );
		},
		''
	);

	// Create the footnotes.
	$using_symbols = 'symbol' === Formats\get_style();
	return $mutated_content . sprintf(
		'<hr class="footnotes"><ol class="%s">%s</ol>',
		$using_symbols ? 'footnotes symbols' : 'footnotes',
		$footnote_li_tags
	);
}
