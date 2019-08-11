<?php
declare(strict_types=1);

require_once dirname( __DIR__ ) . '/inc/formats.php';

use PHPUnit\Framework\TestCase;
use Civil_Footnotes\Formats;
use function Civil_Footnotes\Formats\int_to_roman;

if ( ! function_exists( 'apply_filters' ) ) {
	function apply_filters( $filter_name, $default, $arg1 ) {
		return $default;
	}
}

final class Test_Formats extends TestCase {
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
		$this->assertEquals( Formats\int_to_roman( -1 ), '-1' );
		$this->assertEquals( Formats\int_to_roman( 40000 ), '40000' );
	}

	public function testIntToSymbol() : void {
		$this->assertEquals( Formats\int_to_symbol( 1 ), '*' );
		$this->assertEquals( Formats\int_to_symbol( 2 ), '&dagger;' );
		$this->assertEquals( Formats\int_to_symbol( 3 ), '&Dagger;' );
		$this->assertEquals( Formats\int_to_symbol( 4 ), '&sect;' );
		$this->assertEquals( Formats\int_to_symbol( 9 ), '#' );
		$this->assertEquals( Formats\int_to_roman( -1 ), '-1' );
		$this->assertEquals( Formats\int_to_symbol( 90 ), '90' );
	}
}
