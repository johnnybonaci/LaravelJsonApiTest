<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasSorts {

	public function scopeApplySorts(Builder $query, $sortField) {

		$sort = 'asc';
		if($sortField) {
			if(Str::of($sortField)->startsWith('-')) {
				$sort = 'desc';
				$sortField = Str::of($sortField)->substr(1);
			}
			$query->orderBy($sortField,$sort)->get();
		}
		return;
	}

}