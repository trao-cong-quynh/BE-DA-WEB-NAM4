<?php

namespace App\Http\Controllers;

use App\Models\DatVe;
use App\Models\Phim as PhimModel;
use Illuminate\Http\Request;
use Carbon\Carbon;


class PhimController extends Controller
{

    // public function top2BanChay()
    // {
    //     $phimTop = \App\Models\Phim::withSum(['dat_ves as so_ve_ban' => function ($query) {
    //         $query->where('trang_thai', '!=', 'huy');
    //     }], 'tong_so_ve')
    //     ->orderByDesc('so_ve_ban')
    //     ->take(2)
    //     ->get(['ma_phim', 'ten_phim', 'anh']);

    //     return response()->json($phimTop);
    // }

    // public function top2BanChay()
    // {
    //     // Lấy tất cả vé đã thanh toán và tính tổng số vé đã bán cho từng vé
    //     $datVeTop = DatVe::whereHas('suat_chieu', function ($query) {
    //         $query->whereHas('phim', function ($query) {
    //             $query->where('trang_thai', '=', 'Đã thanh toán');
    //         });
    //     })
    //         ->with('suat_chieu.phim')  // Lấy thông tin phim của từng suất chiếu
    //         ->get()
    //         ->map(function ($datVe) {
    //             return [
    //                 'ma_phim' => $datVe->suat_chieu->phim->ma_phim,
    //                 'ten_phim' => $datVe->suat_chieu->phim->ten_phim,
    //                 'so_ve_ban' => $datVe->tong_so_ve,
    //             ];
    //         })
    //         ->sortByDesc('so_ve_ban') // Sắp xếp theo số vé đã bán giảm dần
    //         ->take(2); // Lấy 2 vé bán chạy nhất

    //     return response()->json($datVeTop);
    // }






    public function index()
    {
        // $now = Carbon::now();
        // $phim = PhimModel::whereHas('suat_chieus', function ($query) use ($now) {
        //     $query->whereRaw("STR_TO_DATE(CONCAT(ngay_chieu,' ',thoi_gian_bd), '%Y-%m-%d %H:%i:%s') >= ?", [$now]);
        // })->get();

        $phim = PhimModel::all();

        return response()->json($phim);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    /**
     * @OA\Get(
     *     path="/api/phim/{ma_phim}",
     *     summary="Lấy thông tin phim theo mã",
     *     description="API này dùng để lấy thông tin chi tiết của một phim dựa trên mã phim.",
     *     tags={"Phim"},
     *     @OA\Parameter(
     *         name="ma_phim",
     *         in="path",
     *         description="Mã phim cần tìm",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Thông tin phim chi tiết",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ma_phim", type="string", example="PH001"),
     *             @OA\Property(property="ten_phim", type="string", example="Phim 1"),
     *             @OA\Property(property="mo_ta", type="string", example="Mô tả phim 1"),
     *             @OA\Property(property="ngay_cong_chieu", type="string", format="date", example="2025-04-12"),
     *             @OA\Property(property="the_loai", type="array", @OA\Items(type="string", example="Hành động"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Phim không tồn tại",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Phim không tồn tại")
     *         )
     *     )
     * )
     */
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
