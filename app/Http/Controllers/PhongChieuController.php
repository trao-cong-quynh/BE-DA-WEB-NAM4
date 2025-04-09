<?php

namespace App\Http\Controllers;

use App\Models\GheNgoi;
use App\Models\PhongChieu;
use Illuminate\Http\Request;

class PhongChieuController extends Controller
{


    public function getGhebyPhong($ma_phong)
    {
        $ghes = GheNgoi::where('ma_phong', $ma_phong)->select('ma_ghe', 'so_ghe')->get();
        if ($ghes->isEmpty()) {
            return response()->json(["message" => "Không tìm thấy ghế nào"]);
        }


        return response()->json($ghes, 200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $phongchieu = PhongChieu::find($id);
        return response()->json($phongchieu);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
