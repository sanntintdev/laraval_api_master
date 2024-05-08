<?php

namespace App\Http\Filters\V1;

class UserFilter extends QueryFilter
{
    protected $sortableColumns = [
        "name",
        "email",
        "createdAt" => "created_at",
        "updatedAt" => "updated_at",
    ];

    public function include(string $value)
    {
        return $this->builder->with($value);
    }

    public function id(string $values)
    {
        return $this->builder->whereIn("id", explode(",", $values));
    }

    public function email(string $value)
    {
        $likeStr = str_replace("*", "%", $value);
        return $this->builder->where("email", "like", $likeStr);
    }

    public function name(string $value)
    {
        $likeStr = str_replace("*", "%", $value);
        return $this->builder->where("name", "like", $likeStr);
    }

    public function createdAt(string $values)
    {
        $dates = explode(",", $values);

        if (count($dates) > 1) {
            return $this->builder->whereBetween("created_at", $dates);
        }

        return $this->builder->whereDate("created_at", $dates);
    }

    public function updatedAt(string $values)
    {
        $dates = explode(",", $values);

        if (count($dates) > 1) {
            return $this->builder->whereBetween("updated_at", $dates);
        }

        return $this->builder->whereDate("updated_at", $dates);
    }
}
