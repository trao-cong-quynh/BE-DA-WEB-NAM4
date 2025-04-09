<?php

namespace App\Http\Controllers;

use App\Models\Phim as PhimModel;
use Illuminate\Http\Request;


class PhimController extends Controller
{

    public function index()
    {
        $phim = PhimModel::all();
        return response()->json($phim);
    }

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
    public function show(string $ma_phim)
    {
        $phim = PhimModel::with('phim_loais.loai_phim')->where('ma_phim', $ma_phim)->first();
        if (!$phim) {
            return response()->json(['message' => 'Phim không tồn tại'], 404);
        }

        $phimArr = $phim->toArray();
        $phimArr['the_loai'] = $phim->phim_loais->map(function ($s1) {
            return $s1->loai_phim->ten_loai;
        });
        unset($phimArr['phim_loais']);
        return response()->json($phimArr);
    }


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
