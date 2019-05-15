<?php

function change_key( $array, $old_key, $new_key ) {

    if( ! array_key_exists( $old_key, $array ) )
        return $array;

    $keys = array_keys( $array );
    $keys[ array_search( $old_key, $keys ) ] = $new_key;

    return array_combine( $keys, $array );
}

function remap_keys($array, $new_keys) {
	$result = $array;
	foreach($new_keys as $old => $new) {
		if(array_key_exists($old, $result)){
			$result = change_key($result, $old, $new);
		}
	}
	return $result;
}
