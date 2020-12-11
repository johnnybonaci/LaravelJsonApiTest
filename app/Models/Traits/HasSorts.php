<?php
namespace App\Models\Traits;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasSorts {

	public function scopeApplySorts(Builder $query, $sortField) {

		if($sortField)
		{
			$sortFields = Str::of($sortField)->explode(',');
			foreach ($sortFields as $key => $sortField) {
				$sort = 'asc';
				if(Str::of($sortField)->startsWith('-')) {
					$sort = 'desc';
					$sortField = Str::of($sortField)->substr(1);
				}

				if ( ! collect($this->allowedSorts)->contains($sortField))
				{
					abort(400, "Invalido Parametro, { $sortField } no es permitido");
				}

				$query->orderBy($sortField,$sort)->get();
			}
		}
		return;
	}

}