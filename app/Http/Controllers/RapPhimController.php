<?php

namespace App\Http\Controllers;

use App\Models\RapPhim;
use Illuminate\Http\Request;

class RapPhimController extends Controller
{
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


    /**
     * @OA\Get(
     *     path="/api/rap/{ma_rap}",
     *     summary="Lấy thông tin rạp chiếu phim",
     *     description="API này dùng để lấy thông tin chi tiết của một rạp chiếu phim theo ID.",
     *     tags={"Rạp chiếu phim"},
     *     @OA\Parameter(
     *         name="ma_rap",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="RP001"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lấy thông tin rạp chiếu phim thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="string", example="RP001"),
     *             @OA\Property(property="ten", type="string", example="Rạp Phim ABC"),
     *             @OA\Property(property="dia_chi", type="string", example="123 Đường ABC, Quận 1, TP.HCM"),
     *             @OA\Property(property="so_phong_chieu", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rạp chiếu phim không tồn tại",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Không tìm thấy rạp chiếu phim!")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ma_rap)
    {
        $rap = RapPhim::find($ma_rap);
        return response()->json($rap);
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
