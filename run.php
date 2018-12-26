<?php
$sources = glob( 'source/*' );
function save_source_text( $source, $text ) {
	$image = imagecreatefrompng( $source );
	$size  = 11;
	$angle = 0;
	if (is_numeric($text)) {
		if($text < 10){
			$x = 6;
			$y = 18;
		}else{
			$x = 3;
			$y = 18;
		}
	} else {
		$x = 6;
		$y = 18;
	}

	$im = imagecreatetruecolor( 400, 100 ) or die( "Can't create image!" );

	$white = imagecolorallocate( $im, 254, 254, 254 );
	$grey  = imagecolorallocate( $im, 128, 128, 128 );
	$black = imagecolorallocate( $im, 0, 0, 0 );
	imagefilledrectangle( $im, 0, 0, 399, 29, $white );

	$font = __DIR__ . '\\Roboto-Regular.ttf';
//	echo $font;die;
	$background = imagecolorallocate( imagecreatetruecolor( 400, 100 ), 255, 255, 255 );
	imagecolortransparent( $image, $background );
	$imagettftext = imagettftext( $image, $size, $angle, $x, $y, $white, ( $font ), $text );
	// integer representation of the color black (rgb: 0,0,0)
	// removing the black from the placeholder
	$dest = str_replace( [ 'source/', '_' ], '', $source );
	@mkdir( "images/$text" );
	imagepng( $image, "images/$text/$dest" );
	imagedestroy( $image );
}

foreach ( $sources as $source ) {
	$letters = array_merge( range( 'A', 'Z' ), range( 0, 99 ), explode( ',', ' !,@,$,+, -,=,#,&, •' ) );
	foreach ( $letters as $letter ) {
		save_source_text( $source, $letter );
		echo "$source,$letter<br>";
	}
}
