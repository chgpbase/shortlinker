<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    protected $fillable = ['id', 'source_link', 'short_link', 'life_to'];

    public function getStatisticUrl(): string
    {
        return route(
            'statistic',
            [$this->short_link, $this->getStatisticKey()]
        );
    }

    public function getStatisticKey(): string
    {
        return md5($this->attributes['short_link'] . ':' . $this->attributes['source_link']);
    }
}
