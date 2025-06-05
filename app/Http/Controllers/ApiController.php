<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use App\Models\PolygonsModel;
use App\Models\PolylinesModel;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $points;
    protected $polylines;
    protected $polygons;

    public function __construct()
    {
        $this->points = new PointsModel();
        $this->polylines = new PolylinesModel();
        $this->polygons = new PolygonsModel();
    }

    public function points()
    {
        $points = $this->points->geojson_points();
        return response()->json($points);
    }

    public function point($id)
    {
        $points = $this->points->geojson_point($id);
        return response()->json($points);
    }

    public function polylines()
    {
        $polylines = $this->polylines->geojson_polylines();
        return response()->json($polylines, 200, [],JSON_NUMERIC_CHECK) ;
    }

    public function polyline($id)
    {
        $polylines = $this->polylines->geojson_polyline($id);
        return response()->json($polylines);
    }

    public function polygons()
    {
        $id = 1; // Replace with the appropriate ID value
        $polygons = $this->polygons->geojson_polygons($id);
        return response()->json($polygons);
    }

    public function polygon($id)
    {
        $polygons = $this->polygons->geojson_polygon($id);
        return response()->json($polygons);
    }
}
