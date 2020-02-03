<?php
declare(strict_types=1);

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Now call the bootstrap method of WP Mock
WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();

// Load in our custom files.
require_once dirname( __DIR__ ) . '/inc/formats.php';
