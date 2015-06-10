--TEST--
is_uploaded_file() function
--CREDITS--
Dave Kelsey <d_kelsey@uk.ibm.com>
--POST_RAW--
Content-type: multipart/form-data, boundary=AaB03x

--AaB03x
content-disposition: form-data; name="field1"

Joe Blow
--AaB03x
content-disposition: form-data; name="pics"; filename="file1.txt"
Content-Type: text/plain

abcdef123456789
--AaB03x--
--SKIPIF--
<?php if(empty( $_FILES )){die('skip');} ?>
--FILE--
<?php
// uploaded file
var_dump($_FILES);
var_dump(is_uploaded_file($_FILES['pics']['tmp_name']));

$__ROOT_DIR = dirname(dirname(dirname( __DIR__ )));

require( $__ROOT_DIR . '/src/Http/File.php');

$name = "pics";

$res = true;
if( Frametek\Http\File::upload( $name, $__ROOT_DIR . '/tests/Http/upload/' ) )
{
	$res = Frametek\Http\File::exists( $__ROOT_DIR . '/tests/Http/upload/bob.txt');
}
var_dump( $res );
?>
--XFAIL--
This bug occure due to the undefined $_FILES variable, for no reason !!!
--EXPECT--
bool(true)
