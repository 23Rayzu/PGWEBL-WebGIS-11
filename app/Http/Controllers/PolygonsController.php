<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolygonsModel;

class PolygonsController extends Controller
{
    protected $polygons;

    public function __construct()
    {
        $this->polygons = new PolygonsModel();
    }

    public function index()
    {
        // Kosongkan atau isi sesuai kebutuhan (misal list semua polygon)
    }

    public function create()
    {
        // Form create jika diperlukan
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:polygons,name',
            'description' => 'required',
            'geom_polygon' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        $name_image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        }

        $data = [
            'geom' => $request->geom_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        if (!$this->polygons->create($data)) {
            return redirect()->route('map')->with('error', 'Polygon failed to add!');
        }

        return redirect()->route('map')->with('success', 'Polygon has been added!');
    }

    public function show(string $id)
    {
        // Bisa diisi untuk menampilkan detail polygon
    }
    public function edit(string $id)
    {
        $polygon = $this->polygons->findOrFail($id);

        $data = [
            'title' => 'Edit Polygon',
            'polygon' => $polygon, // Kirim seluruh data polygon
            'id' => $id
        ];

        return view('editpolygon', $data);
    }

    public function update(Request $request, string $id)
    {
        // Validate Reuqest
        $request->validate(
            [
                'name' => 'required|unique:polygons,name,' . $id,
                'description' => 'required',
                'geom_polygon' => 'required',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2408',
            ],
            [
                'name.required' => 'Name is required',
                'name.unique' => 'Name already exist',
                'description.required' => 'Description is required',
                'geom_polygon.required' => 'Polygon is required',
            ]
        );

        // Create directory if not exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get old image
        $old_image = $this->polygons->find($id)->image;


        // Get image File
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
            // Delete old image
            if ($old_image != null) {
                if (file_exists('storage/images/' . $old_image)) {
                    unlink('storage/images/' . $old_image);
                }
            }
        } else {
            $name_image = $old_image;
        }

        $data = [
            'name' => $request->name,
            'geom' => $request->geom_polygon,
            'description' => $request->description,
            'image' => $name_image,
            'user_id' => auth()->user()->id,
        ];

        // Update data
        if (!$this->polygons->find($id)->update($data)) {
            return redirect()->route('map')->with('error', 'Polygon failed to update');
        }

        //redirect to map
        return redirect()->route('map')->with('success', 'Polygon has been updated');
    }

    public function destroy(string $id)
    {
        $this->polygons->where('id', $id)->delete();

        return redirect()->route('map')->with('success', 'Polygon has been deleted!');
    }
}
