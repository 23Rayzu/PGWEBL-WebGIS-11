<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PointsModel extends Model
{
    protected $table = 'points';

    protected $guarded = ['id'];

    public function geojson_points()
    {
        $points = $this->select(DB::raw('
            points.id,
            ST_AsGeoJSON(points.geom) as geom,
            points.name,
            points.description,
            points.image,
            points.created_at,
            points.updated_at,
            points.user_id,
            users.name as user_name
        '))
        ->join('users', 'points.user_id', '=', 'users.id')
        ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($points as $point) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($point->geom, true),
                'properties' => [
                    'id' => $point->id,
                    'name' => $point->name,
                    'description' => $point->description,
                    'created_at' => $point->created_at,
                    'updated_at' => $point->updated_at,
                    'image' => $point->image,
                    'user_id' => $point->user_id,
                    'user_name' => $point->user_name,
                ],
            ];

            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }

    public function geojson_point($id)
    {
        $points = $this->select(DB::raw('
            points.id,
            ST_AsGeoJSON(points.geom) as geom,
            points.name,
            points.description,
            points.image,
            points.created_at,
            points.updated_at,
            points.user_id
        '))
        ->where('points.id', $id)
        ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($points as $point) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($point->geom, true),
                'properties' => [
                    'id' => $point->id,
                    'name' => $point->name,
                    'description' => $point->description,
                    'created_at' => $point->created_at,
                    'updated_at' => $point->updated_at,
                    'image' => $point->image,
                    'user_id' => $point->user_id,
                    'user_name' => $point->user_name,
                ],
            ];

            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }
}
