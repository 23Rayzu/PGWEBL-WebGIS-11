<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use Illuminate\Http\Request;

class PointsController extends Controller
{

    protected $points;

    public function __construct()
    {
        $this->points = new PointsModel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $points = $this->points->all(); // Ambil semua data point dari model

        $data = [
            'title' => 'Peta',
            'points' => $points // Kirim ke view
        ];

        return view('map', $data);
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
                'name' => 'required|unique:points,name',
                'description' => 'required',
                'geom_point' => 'required',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2408',
            ],
            [
                'name.required' => 'Name is required',
                'name.unique' => 'Name already exist',
                'description.required' => 'Description is required',
                'geom_point.required' => 'Point is required',
            ]
        );

        // Create directory if not exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get image File
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'name' => $request->name,
            'geom' => $request->geom_point,
            'description' => $request->description,
            'image' => $name_image,
            'user_id' => auth()->user()->id,
        ];

        // create data
        if (!$this->points->create($data)) {
            return redirect()->route('map')->with('error', 'Point Failed to add');
        }

        //redirect to map
        return redirect()->route('map')->with('success', 'Point Has Been Added');
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
            'title' => 'Edit Point',
            'id' => $id,
        ];

        return view('editpoint', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($id, $request->all());
        // Validate Reuqest
        $request->validate(
            [
                'name' => 'required|unique:points,name,' . $id,
                'description' => 'required',
                'geom_point' => 'required',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2408',
            ],
            [
                'name.required' => 'Name is required',
                'name.unique' => 'Name already exist',
                'description.required' => 'Description is required',
                'geom_point.required' => 'Point is required',
            ]
        );

        // Create directory if not exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get old image
        $old_image = $this->points->find($id)->image;


        // Get image File
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
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
            'geom' => $request->geom_point,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // Update data
        if (!$this->points->find($id)->update($data)) {
            return redirect()->route('map')->with('error', 'Point failed to update');
        }

        //redirect to map
        return redirect()->route('map')->with('success', 'Point has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete Image
        $image = $this->points->find($id);
        if ($image->image != null) {
            if (file_exists('storage/images/' . $image->image)) {
                unlink('storage/images/' . $image->image);
            }
        }
        if (!$this->points->destroy($id)) {
            return redirect()->route('map')->with('error', 'Point Failed to delete');
        }
        return redirect()->route('map')->with('success', 'Point has been deleteted');
    }
}
