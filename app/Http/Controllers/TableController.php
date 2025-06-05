<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointsModel;
use App\Models\PolylinesModel;
use App\Models\PolygonsModel;


class TableController extends Controller
{
    protected $points;
    protected $polygons;
    protected $polylines;

    public function __construct()
    {

        $this->points = new PointsModel();
        $this->polygons = new PolygonsModel();
        $this->polylines = new PolylinesModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Table',
            'points' => $this->points->all(),
            'polygons' => $this->polygons->all(),
            'polylines' => $this->polylines->all(),
        ];

        return view('table', $data);
    }
}
