<?php

namespace App\Http\Filters\V1;

class TicketFilter extends QueryFilter
{
    public function include(string $value)
    {
        return $this->builder->with($value);
    }

    public function status(string $values)
    {
        return $this->builder->whereIn("status", explode(",", $values));
    }

    public function title(string $value)
    {
        $likeStr = str_replace("*", "%", $value);
        return $this->builder->where("title", "like", $likeStr);
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
