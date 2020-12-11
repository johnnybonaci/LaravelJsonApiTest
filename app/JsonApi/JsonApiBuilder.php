<?php

namespace App\JsonApi;

use Illuminate\Support\Str;


class JsonApiBuilder {

	public function jsonPaginate() {

		return function(){

			return $this->paginate(
				$perPage = request('page.size'),
				$columns = ['*'],
				$pageName = 'page[number]',
				$page = request('page.number'))->appends(request()->except('page.number'));
		};

	}

	public function applySorts() {

		return function(){
		if($sortField = request('sort'))
		{
			$sortFields = Str::of($sortField)->explode(',');
			foreach ($sortFields as $key => $sortField) {
				$sort = 'asc';
				if(Str::of($sortField)->startsWith('-')) {
					$sort = 'desc';
					$sortField = Str::of($sortField)->substr(1);
				}

				if ( ! collect($this->model->allowedSorts)->contains($sortField))
				{
					abort(400, "Invalido Parametro, { $sortField } no es permitido");
				}

				$this->query->orderBy($sortField,$sort)->get();
			}
		}
		return $this;
		};
	}

}

