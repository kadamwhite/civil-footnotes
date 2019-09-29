<?php
declare(strict_types=1);

require_once dirname( __DIR__ ) . '/inc/formats.php';

use PHPUnit\Framework\TestCase;
use Civil_Footnotes\Formats;

if ( ! function_exists( 'apply_filters' ) ) {
	function apply_filters( $filter_name, $default, $arg1 ) {
		return $default;
	}
}

final class Test_Formats extends TestCase {
	public function testIntToAlpha() : void {
		$this->assertEquals( Formats\int_to_alpha( 1 ), 'A' );
		$this->assertEquals( Formats\int_to_alpha( 5 ), 'E' );
		$this->assertEquals( Formats\int_to_alpha( 13 ), 'M' );
		$this->assertEquals( Formats\int_to_alpha( 26 ), 'Z' );
		$this->assertEquals( Formats\int_to_alpha( 27 ), 'AA' );
		$this->assertEquals( Formats\int_to_alpha( 702 ), 'ZZ' );
		$this->assertEquals( Formats\int_to_alpha( 0 ), '0' );
		$this->assertEquals( Formats\int_to_alpha( -1 ), '-1' );
	}

	public function testIntToLowerGreek() : void {
		$this->assertEquals( Formats\int_to_lower_greek( 1 ), '&alpha;' );
		$this->assertEquals( Formats\int_to_lower_greek( 24 ), '&omega;' );
		$this->assertEquals( Formats\int_to_lower_greek( 25 ), '&alpha;&alpha;' );
		$this->assertEquals( Formats\int_to_lower_greek( 600 ), '&omega;&omega;' );
	}

	public function testIntToUpperGreek() : void {
		$this->assertEquals( Formats\int_to_upper_greek( 1 ), '&Alpha;' );
		$this->assertEquals( Formats\int_to_upper_greek( 24 ), '&Omega;' );
		$this->assertEquals( Formats\int_to_upper_greek( 25 ), '&Alpha;&Alpha;' );
		$this->assertEquals( Formats\int_to_upper_greek( 600 ), '&Omega;&Omega;' );
	}

	public function testIntToRoman() : void {
		$this->assertEquals( Formats\int_to_roman( 1 ), 'I' );
		$this->assertEquals( Formats\int_to_roman( 2 ), 'II' );
		$this->assertEquals( Formats\int_to_roman( 3 ), 'III' );
		$this->assertEquals( Formats\int_to_roman( 4 ), 'IV' );
		$this->assertEquals( Formats\int_to_roman( 5 ), 'V' );
		$this->assertEquals( Formats\int_to_roman( 6 ), 'VI' );
		$this->assertEquals( Formats\int_to_roman( 7 ), 'VII' );
		$this->assertEquals( Formats\int_to_roman( 8 ), 'VIII' );
		$this->assertEquals( Formats\int_to_roman( 9 ), 'IX' );
		$this->assertEquals( Formats\int_to_roman( 10 ), 'X' );
		$this->assertEquals( Formats\int_to_roman( 11 ), 'XI' );
		$this->assertEquals( Formats\int_to_roman( 12 ), 'XII' );
		$this->assertEquals( Formats\int_to_roman( 13 ), 'XIII' );
		$this->assertEquals( Formats\int_to_roman( 14 ), 'XIV' );
		$this->assertEquals( Formats\int_to_roman( 15 ), 'XV' );
		$this->assertEquals( Formats\int_to_roman( 25 ), 'XXV' );
		$this->assertEquals( Formats\int_to_roman( 41 ), 'XLI' );
		$this->assertEquals( Formats\int_to_roman( 54 ), 'LIV' );
		$this->assertEquals( Formats\int_to_roman( 89 ), 'LXXXIX' );
		$this->assertEquals( Formats\int_to_roman( 98 ), 'XCVIII' );
		$this->assertEquals( Formats\int_to_roman( 300 ), 'CCC' );
		$this->assertEquals( Formats\int_to_roman( 400 ), 'CD' );
		$this->assertEquals( Formats\int_to_roman( 406 ), 'CDVI' );
		$this->assertEquals( Formats\int_to_roman( 0 ), '0' );
		$this->assertEquals( Formats\int_to_roman( -1 ), '-1' );
		$this->assertEquals( Formats\int_to_roman( 40000 ), '40000' );
	}

	public function testIntToSymbol() : void {
		$this->assertEquals( Formats\int_to_symbol( 1 ), '*' );
		$this->assertEquals( Formats\int_to_symbol( 2 ), '&dagger;' );
		$this->assertEquals( Formats\int_to_symbol( 3 ), '&Dagger;' );
		$this->assertEquals( Formats\int_to_symbol( 4 ), '&sect;' );
		$this->assertEquals( Formats\int_to_symbol( 9 ), '#' );
		$this->assertEquals( Formats\int_to_symbol( 0 ), '0' );
		$this->assertEquals( Formats\int_to_symbol( -1 ), '-1' );
		$this->assertEquals( Formats\int_to_symbol( 90 ), '90' );
	}
}
