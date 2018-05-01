<?php

namespace Devjs\EloquentResources\Repositories\Criterias\Common;

use Devjs\EloquentResources\Repositories\Criterias\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

abstract class AbstractNear implements CriteriaInterface
{
    const EARTH_RADIUS_KM = 6371;

    /* 
     * Model with latitude and longitude
     *
     * ex: contacts
     */
    const NEARABLE = '';

    /*
     * Model relation to repository Model 
     *
     * ex: studios.contact
     */
    const RELATION = '';

    protected $latitude;
    protected $longitude;
    protected $distance;

    public function __construct(array $params)
    {
        $this->latitude = $params[0];
        $this->longitude = $params[1];
        $this->distance = $params[2];
    }

    public function apply(Builder $qb): Builder
    {
        $results = DB::select(DB::raw('SELECT * FROM (SELECT id, ( ' . self::EARTH_RADIUS_KM . ' * acos( cos( radians(' . $this->latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $this->longitude . ') ) + sin( radians(' . $this->latitude .') ) * sin( radians(latitude) ) ) ) AS distance FROM ' . $this::NEARABLE . ') q WHERE distance < ' . $this->distance . ' ORDER BY distance'));

        $results = array_map(function ($item) {
            return $item->id;
        }, (array)$results);

        return $qb->whereHas($this::RELATION, function (Builder $qb) use ($results) {
            $qb->whereIn('id', $results);
        });
    }
}
