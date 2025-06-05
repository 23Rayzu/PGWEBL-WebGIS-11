<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PolylinesModel;

class PolylinesController extends Controller
{
    protected $polylines;

    public function __construct()
    {
        $this->polylines = new PolylinesModel();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate Reuqest
        $request->validate(
            [
                'name' => 'required|unique:polylines,name',
                'description' => 'required',
                'geom_polyline' => 'required',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2408',
            ],
            [
                'name.required' => 'Name is required',
                'name.unique' => 'Name already exist',
                'description.required' => 'Description is required',
                'geom_polyline.required' => 'Polyline is required',
            ]
        );

        // Get image File
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'name' => $request->name,
            'geom' => $request->geom_polyline,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // create data
        if (!$this->polylines->create($data)) {
            return redirect()->route('map')->with('success', 'Polyline Failed to add');
        }

        //redirect to map
        return redirect()->route('map')->with('success', 'Polyline Has Been Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Polyline',
            'id' => $id,
        ];

        return view('editpolyline', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate Reuqest
        $request->validate(
            [
                'name' => 'required|unique:polylines,name,' . $id,
                'description' => 'required',
                'geom_polyline' => 'required',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2408',
            ],
            [
                'name.required' => 'Name is required',
                'name.unique' => 'Name already exist',
                'description.required' => 'Description is required',
                'geom_polyline.required' => 'Polyline is required',
            ]
        );

        // Create directory if not exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get old image
        $old_image = $this->polylines->find($id)->image;


        // Get image File
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
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
            'geom' => $request->geom_polyline,
            'description' => $request->description,
            'image' => $name_image,
            'user_id' => auth()->user()->id,
        ];

        // Update data
        if (!$this->polylines->find($id)->update($data)) {
            return redirect()->route('map')->with('error', 'Polyline failed to update');
        }

        //redirect to map
        return redirect()->route('map')->with('success', 'Polyline has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = $this->polylines->find($id);

        // Cek apakah data ditemukan
        if (!$image) {
            return redirect()->route('map')->with('error', 'Polyline not found');
        }

        // Hapus file gambar jika ada
        if ($image->image != null && file_exists('storage/images/' . $image->image)) {
            unlink('storage/images/' . $image->image);
        }

        // Hapus data dari database
        if (!$this->polylines->destroy($id)) {
            return redirect()->route('map')->with('error', 'Polyline failed to delete');
        }

        return redirect()->route('map')->with('success', 'Polyline has been deleted');
    }
}
