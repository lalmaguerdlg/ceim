<?php

namespace App\Traits;

use Illuminate\Http\Resources\MissingValue;


trait ResourceConditionals
{
	public function whenLoadedClousure($relation, $clousure, $default = null) {

		$value = new MissingValue();

		if($this->relationLoaded($relation)) {
			$value = $clousure($this->resource);
		}
		else if( $default !== null) {
			$value = $default;
		}

		return $value;
	}
}