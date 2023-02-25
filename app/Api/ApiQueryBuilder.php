<?php

namespace App\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApiQueryBuilder
{
    private readonly Builder $query;

    public function __construct(Builder $query, private readonly Request $request)
    {
        $this->query = clone $query;
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }

    public function addFilter(string $name, ?\Closure $applyFilter=null): self
    {
        if(!$this->request->has($name)) {
            return $this;
        }

        $filterValue = $this->request->get($name);
        if ($applyFilter) {
            $applyFilter($filterValue, $this->query);
            return $this;
        }

        $this->query->where($name, $filterValue);
        return $this;
    }

    public function addSort(string $defaultField, string $defaultDirection): self
    {
        if(!$this->request->has('sort')) {
            $this->query->orderBy($defaultField, $defaultDirection);
            return $this;
        }

        $sort = \Arr::wrap($this->request->get('sort'));
        foreach ($sort as $sortField => $direction) {
            if (is_numeric($sortField)) {
                $sortField = $direction;
                $direction = 'asc';
            }

            $this->query->orderBy($sortField, $direction);
        }

        return $this;
    }
}
