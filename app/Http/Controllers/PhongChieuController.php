<?php

namespace App\Http\Controllers;

use App\Models\GheNgoi;
use App\Models\PhongChieu;
use Illuminate\Http\Request;

class PhongChieuController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/phong/dsghe/{ma_phong}",
     *     summary="Lấy danh sách ghế theo phòng chiếu",
     *     description="API này dùng để lấy danh sách các ghế trong một phòng chiếu cụ thể.",
     *     tags={"Phòng Chiếu"},
     *     @OA\Parameter(
     *         name="ma_phong",
     *         in="path",
     *         description="Mã phòng chiếu cần lấy ghế",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách ghế trong phòng chiếu",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="ma_ghe", type="string", example="G01"),
     *                 @OA\Property(property="so_ghe", type="string", example="A1")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Không tìm thấy ghế nào trong phòng chiếu",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Không tìm thấy ghế nào")
     *         )
     *     )
     * )
     */


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



    /**
     * @OA\Get(
     *     path="/api/phong/{ma_phong}",
     *     summary="Lấy thông tin phòng chiếu theo mã",
     *     description="API này dùng để lấy thông tin chi tiết một phòng chiếu theo mã phòng.",
     *     tags={"Phòng Chiếu"},
     *     @OA\Parameter(
     *         name="ma_phong",
     *         in="path",
     *         description="Mã phòng chiếu cần tìm",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Thông tin phòng chiếu",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ma_phong", type="string", example="PC001"),
     *             @OA\Property(property="ten_phong", type="string", example="Phòng Chiếu 1"),
     *             @OA\Property(property="so_ghe", type="integer", example=50),
     *             @OA\Property(property="mo_ta", type="string", example="Phòng chiếu hiện đại với ghế ngồi thoải mái")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Phòng chiếu không tồn tại",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Phòng chiếu không tồn tại")
     *         )
     *     )
     * )
     */
    public function show(string $ma_phong)
    {
        $phongchieu = PhongChieu::find($ma_phong);
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
