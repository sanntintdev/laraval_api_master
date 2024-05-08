<?php

namespace App\Http\Filters\V1;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request as HttpRequest;

class QueryFilter
{
    protected $builder;
    protected $sortableColumns;

    public function __construct(public HttpRequest $request)
    {
    }

    protected function filter($arr)
    {
        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    protected function sort($values)
    {
        $sortAttributes = explode(",", $values);

        foreach ($sortAttributes as $sortAttribute) {
            $defaultSortOrder = "asc";

            if (strpos($sortAttribute, "-") === 0) {
                $defaultSortOrder = "desc";
                $sortAttribute = substr($sortAttribute, 1);
            }

            if (
                !in_array($sortAttribute, $this->sortableColumns) &&
                !array_key_exists($sortAttribute, $this->sortableColumns)
            ) {
                continue;
            }

            $column = $this->sortableColumns[$sortAttribute] ?? null;

            if ($column == null) {
                $column = $sortAttribute;
            }

            $this->builder->orderBy($column, $defaultSortOrder);
        }
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $builder;
    }
}
