<?php

namespace App\Http\Controllers;

use App\Models\SuatChieu;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;


class SuatChieuController extends Controller
{

      /**
     * Lấy danh sách suất chiếu theo mã phim và (tuỳ chọn) ngày chiếu
     * 
     * @OA\Get(
     *     path="/api/suatchieu/phim/{ma_phim}",
     *     summary="Lấy danh sách suất chiếu theo mã phim",
     *     description="API này dùng để lấy tất cả suất chiếu của một phim, có thể lọc theo ngày chiếu.",
     *     tags={"Suất Chiếu"},
     * 
     *     @OA\Parameter(
     *         name="ma_phim",
     *         in="path",
     *         required=true,
     *         description="Mã phim cần tìm suất chiếu",
     *         @OA\Schema(type="string", example="PH001")
     *     ),
     * 
     *     @OA\Parameter(
     *         name="ngay_chieu",
     *         in="query",
     *         required=false,
     *         description="Lọc theo ngày chiếu (định dạng: YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date", example="2025-04-12")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách suất chiếu theo rạp (trống nếu không có dữ liệu)",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="ma_rap", type="string", example="RP001"),
     *                 @OA\Property(property="ten_rap", type="string", example="Rạp Galaxy Nguyễn Du"),
     *                 @OA\Property(property="dia_chi", type="string", example="123 Nguyễn Du, Q.1, TP.HCM"),
     *                 @OA\Property(
     *                     property="suat_chieu",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="ma_suat_chieu", type="string", example="SC001"),
     *                         @OA\Property(property="ma_phong", type="string", example="P001"),
     *                         @OA\Property(property="phong", type="string", example="Phòng 1"),
     *                         @OA\Property(property="thoi_gian_bd", type="string", example="14:00"),
     *                         @OA\Property(property="ngay_chieu", type="string", example="12-04-2025")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=500,
     *         description="Lỗi hệ thống"
     *     )
     * )
     */


    public function getByPhim($ma_phim, Request $request)
    {
        $ngay_chieu = $request->query('ngay_chieu');
        \Log::info('Ngày chiếu truyền vào:', ['ngay_chieu' => $ngay_chieu]);
        $suatchieu = SuatChieu::with(['phong_chieu.rap_phim'])->where('ma_phim', $ma_phim)->when($ngay_chieu, function ($query) use ($ngay_chieu) {
            return $query->whereDate('ngay_chieu', $ngay_chieu);
        })->get();
        if ($suatchieu->isEmpty()) {
            return response()->json([]); // hoặc: return response()->json(['data' => []]);
        }

        $data = [];
        foreach ($suatchieu as $suat) {
            $phongchieu = $suat->phong_chieu;
            $rapphim = $phongchieu?->rap_phim;

            if (!$phongchieu || !$rapphim) {
                continue;
            }

            $tenrap = $rapphim->ten_rap;
            if (!isset($data[$tenrap])) {
                $data[$tenrap] = [
                    'ma_rap' => $rapphim->ma_rap,
                    'ten_rap' => $tenrap,
                    'dia_chi' => $rapphim->dia_chi,
                    'suat_chieu' => [],
                ];
            }

            $data[$tenrap]['suat_chieu'][] = [
                'ma_suat_chieu' => $suat->ma_suat_chieu,
                'ma_phong' => $phongchieu->ma_phong,
                'phong' => $phongchieu->ten_phong,
                'thoi_gian_bd' => $suat->thoi_gian_bd?->format('H:i'),
                'ngay_chieu' => $suat->ngay_chieu?->format('d-m-Y'),
            ];

        }

        return response()->json(array_values($data));
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
        //
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
