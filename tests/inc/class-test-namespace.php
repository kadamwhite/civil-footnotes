<?php
declare(strict_types=1);

use Civil_Footnotes;
use WP_Mock;

final class Test_Namespace extends WP_Mock\Tools\TestCase {
	public function testRenderFootnoteTag() : void {
		$footnote = [
			'content'  => '"keikaku" means "plan"',
			'fn_id'    => 'fn1-1',
			'ref_id'   => 'rf1-1',
			'fn_href'  => '/#fn1-1',
			'ref_href' => '/#rf1-1',
			'number'   => 1,
			'symbol'   => '1',
		];
		WP_Mock::userFunction( 'wp_kses_post' )
			->once()
			->with( $footnote['content'] )
			->andReturn( $footnote['content'] );
		$output = Civil_Footnotes\render_footnote_li_tag( $footnote );
		$this->assertEquals(
			'<li id="fn1-1"><p >"keikaku" means "plan"&nbsp;<a href="/#rf1-1" class="backlink" title="Return to footnote 1.">&#8617;</a></p></li>',
			$output
		);
	}

	public function testRenderFootnoteTagWithHTML() : void {
		$footnote = [
			'content'  => 'This is <em>HTML Content</em> for a <em>Digital World!</em>',
			'fn_id'    => 'fn1-1',
			'ref_id'   => 'rf1-1',
			'fn_href'  => '/#fn1-1',
			'ref_href' => '/#rf1-1',
			'number'   => 1,
			'symbol'   => '1',
		];
		WP_Mock::userFunction( 'wp_kses_post' )
			->once()
			->with( $footnote['content'] )
			->andReturn( 'Rendered HTML' );
		$output = Civil_Footnotes\render_footnote_li_tag( $footnote );
		$this->assertEquals(
			'<li id="fn1-1"><p >Rendered HTML&nbsp;<a href="/#rf1-1" class="backlink" title="Return to footnote 1.">&#8617;</a></p></li>',
			$output
		);
	}
}
