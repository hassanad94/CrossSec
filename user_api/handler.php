<?php

/*Alapvetően Csak az a dolgó, hogy össze kösse a modulokat és a kommunikációt intézze a back és front end között. */


/* Ha ezt serveren történik akkor kézzel beírnám hogy /var/www/ vagy valami mást kitalálnék de localhost-n így oldottam meg. */
$path = getcwd();

include_once "init.php";

if( !isset( $_REQUEST[ "do" ] ) ){
    die( "MISSING DO" );
}

$do = explode( "/" , $_REQUEST[ "do" ] );

$module = $do[ 0 ];
$function = $do[ 1 ];

$data = [];

if( isset( $_REQUEST[ "data" ] ) ){

    $data = $_REQUEST[ "data" ];

}


include_once getcwd()."/modules/". $module. ".php";

$return = call_user_func( $function, empty( $data ) ?  [] : $data );

echo json_encode( $return , JSON_UNESCAPED_UNICODE );

die();

?>