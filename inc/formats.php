<?php
/**
 * Formatters for the various footnote styles.
 */

namespace Civil_Footnotes\Formats;

/**
 * Expose a mapping of style names to example strings.
 * Used as the argument to the `civil_footnotes_style` filter.
 *
 * @return array Styles mapping.
 */
function styles() : array {
	return [
		'decimal'     => 'decimal',
		'lower-roman' => 'lower-roman',
		'upper-roman' => 'upper-roman',
		'lower-alpha' => 'lower-alpha',
		'upper-alpha' => 'upper-alpha',
		'lower-greek' => 'lower-greek',
		'upper-greek' => 'upper-greek',
		'symbol'      => 'symbol',
	];
}

/**
 * Determine the style to use when rendering footnote indicators & list items.
 * Themes may opt in to a format by hooking into the footnotes_style filter.
 *
 * @return string
 */
function get_style() : string {
	/**
	 * Filters the style to be used when rendering footnote markers.
	 *
	 * @since 2.0.0
	 *
	 * @param string $style  The string name of the style to use.
	 * @param array  $styles The array of viable style names as a self-referential dictionary.
	 */
	return apply_filters( 'footnotes_style', 'decimal', styles() );
}

/**
 * Convert an integer to the selected format. A theme may opt in to a specific
 * format by hooking into the footnotes_style filter.
 *
 * @param integer $num The number of the footnote to render.
 *
 * @return string The character, number or symbol to use for the footnote.
 */
function format( int $num ) : string {
	$selected_style = get_style();

	switch ( $selected_style ) {
		case 'upper-roman':
			return int_to_roman( $num );
		case 'lower-roman':
			return strtolower( int_to_roman( $num ) );
		case 'upper-alpha':
			return int_to_alpha( $num );
		case 'lower-alpha':
			return strtolower( int_to_alpha( $num ) );
		case 'upper-greek':
			return int_to_upper_greek( $num );
		case 'lower-greek':
			return int_to_lower_greek( $num );
		case 'symbol':
			return int_to_symbol( $num );
		case 'decimal':
		default:
			return strval( $num );
	}
}

/**
 * For any arbitrary alphabet (defaulting to upper-case Roman letters), convert
 * an integer into its corresponding character. Values above the length of the
 * alphabet will be prepended with a letter indicating sequence, e.g. 27 would
 * become AA, etcetera.
 *
 * h/t https://stackoverflow.com/a/42177363
 *
 * @param int   $num      The number to convert to alphabetical representation.
 * @param array $alphabet The alphabet of characters to use.
 *
 * @return string The rendered alphabetical representation of $num.
 */
function int_to_alpha( int $num, array $alphabet = [] ): string {
	if ( $num < 1 ) {
		// Out of bounds, return as-is.
		return strval( $num );
	}

	if ( empty( $alphabet ) ) {
		// Default to A..Z.
		$alphabet = range( 'A', 'Z' );
	}

	$count = count( $alphabet );
	if ( $num <= $count ) {
			return $alphabet[ $num - 1 ];
	}
	$alpha = '';
	while ( $num > 0 ) {
		$modulo = ( $num - 1 ) % $count;
		$alpha  = $alphabet[ $modulo ] . $alpha;
		$num    = floor( ( ( $num - $modulo ) / $count ) );
	}
	return $alpha;
}

/**
 * Convert an integer to an alphabetic representation using the lower-case
 * greek alphabet. Corresponds to `list-style-type=lower-greek;`
 *
 * @param int $num Integer to convert.
 *
 * @return string Lower-case Greek alphabetic representation of number.
 */
function int_to_lower_greek( int $num ) : string {
	return int_to_alpha(
		$num,
		[
			'&alpha;',   // α
			'&beta;',    // β
			'&gamma;',   // γ
			'&delta;',   // δ
			'&epsilon;', // ε
			'&zeta;',    // ζ
			'&eta;',     // η
			'&theta;',   // θ
			'&iota;',    // ι
			'&kappa;',   // κ
			'&lambda;',  // λ
			'&mu;',      // μ
			'&nu;',      // ν
			'&xi;',      // ξ
			'&omicron;', // ο
			'&pi;',      // π
			'&rho;',     // ρ
			'&sigma;',   // σ
			'&tau;',     // τ
			'&upsilon;', // υ
			'&phi;',     // φ
			'&chi;',     // χ
			'&psi;',     // ψ
			'&omega;',   // ω
		]
	);
}

/**
 * Convert an integer to an alphabetic representation using the upper-case
 * greek alphabet. Corresponds to `list-style-type=upper-greek;`
 *
 * @param int $num Integer to convert.
 *
 * @return string Upper-case Greek alphabetic representation of number.
 */
function int_to_upper_greek( int $num ) : string {
	return int_to_alpha(
		$num,
		[
			'&Alpha;',   // Α
			'&Beta;',    // Β
			'&Gamma;',   // Γ
			'&Delta;',   // Δ
			'&Epsilon;', // Ε
			'&Zeta;',    // Ζ
			'&Eta;',     // Η
			'&Theta;',   // Θ
			'&Iota;',    // Ι
			'&Kappa;',   // Κ
			'&Lambda;',  // Λ
			'&Mu;',      // Μ
			'&Nu;',      // Ν
			'&Xi;',      // Ξ
			'&Omicron;', // Ο
			'&Pi;',      // Π
			'&Rho;',     // Ρ
			'&Sigma;',   // Σ
			'&Tau;',     // Τ
			'&Upsilon;', // Υ
			'&Phi;',     // Φ
			'&Chi;',     // Χ
			'&Psi;',     // Ψ
			'&Omega;',   // Ω
		]
	);
}

/**
 * Convert an integer to a roman numeral. Returns the input unchanged for out-
 * of-bounds values.
 *
 * @param int $num The number to convert to roman numeral.
 *
 * @return string The converted numeral string, or the original integer as a string.
 */
function int_to_roman( int $num ) : string {
	$result = '';

	// Define the mapping of Roman numerals to corresponding integers.
	$numerals_mapping = [
		'M'  => 1000,
		'CM' => 900,
		'D'  => 500,
		'CD' => 400,
		'C'  => 100,
		'XC' => 90,
		'L'  => 50,
		'XL' => 40,
		'X'  => 10,
		'IX' => 9,
		'V'  => 5,
		'IV' => 4,
		'I'  => 1,
	];

	if ( $num > 3999 || $num < 1 ) {
		// Out of bounds, return as-is.
		return strval( $num );
	}

	foreach ( $numerals_mapping as $roman => $value ) {
		$matches = intval( $num / $value );
		$result  = $result . str_repeat( $roman, $matches );
		$num     = $num % $value;
	}

	return $result;
}

/**
 * Convert an integer to a typographic footnote symbol. Returns the original
 * input integer if it cannot be properly mapped to a symbol.
 *
 * @param int $num The number to convert to a symbol.
 *
 * @return void The converted symbol string, or the original integer as a string.
 */
function int_to_symbol( int $num ) : string {
	// Ordering from Wikipedia's list of common footnote symbols, with
	// additions for card suits & other unique characters that look really neat.
	$symbols = [
		'*',        // *
		'&dagger;', // †
		'&Dagger;', // ‡
		'&sect;',   // §
		'&Vert;',   // ‖
		'&para;',   // ¶
		'&#8485;',  // ℥
		'&#8251;',  // ※
		'#',        // #
		'&diams;',  // ♦
		'&hearts;', // ♥
		'&spades;', // ♠
		'&clubs;',  // ♣
		'&darr;',   // ↓
		'&#10021;', // ✥
		'&#9758;',  // ☞
	];

	if ( $num > count( $symbols ) || $num < 1 ) {
		// Out of bounds, use the number as-is.
		return strval( $num );
	}

	return $symbols[ $num - 1 ];
}
