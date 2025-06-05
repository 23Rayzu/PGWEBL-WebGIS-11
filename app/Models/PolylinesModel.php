<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PolylinesModel extends Model
{
    protected $table = 'polylines';

    protected $guarded = ['id'];

    public function geojson_polylines()
    {
        $polylines = $this->select(DB::raw("polylines.id, ST_AsGeoJSON(geom) AS geom, ST_Length(geom, true) AS length_m, ST_Length(geom, true)/1000 AS length_km, polylines.name, polylines.description, polylines.image, created_at, updated_at"))->get();
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($polylines as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'length_m' => $p->length_m,
                    'length_km' => $p->length_km,
                    'user_id' => $p->user_id,
                    'user_name' => $p->name,
                ],
            ];
            array_push($geojson['features'], $feature);
        }
        return $geojson;
    }

    public function geojson_polyline($id)
    {
        $polylines = $this->select(DB::raw("polylines.id, ST_AsGeoJSON(geom) AS geom, ST_Length(geom, true) AS length_m, ST_Length(geom, true)/1000 AS length_km, polylines.name, polylines.description, polylines.image, created_at, updated_at"))
        ->where('id', $id)
        ->join('users', 'polylines.user_id', '=', 'users.id')
        ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($polylines as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'length_m' => $p->length_m,
                    'length_km' => $p->length_km,
                    'user_id' => $p->user_id,
                    'user_name' => $p->name,
                ],
            ];
            array_push($geojson['features'], $feature);
        }
        return $geojson;
    }
}

