<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDv;
use App\Models\ChiTietVe;
use App\Models\DatVe;
use App\Models\DvAnUong;
use App\Models\LoaiVe;
use App\Models\VeDat;
use DB;
use Illuminate\Http\Request;

class BookTicketController extends Controller
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


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $datve = new DatVe();
            $datve->ma_ve = 'VE' . time() . rand(100, 999);
            $datve->ma_nguoi_dung = $request->input('ma_nguoi_dung');
            $datve->ma_suat_chieu = $request->input('ma_sc');

            $number = str_replace(['.', ' VNĐ'], '', (string) $request->tong_tien);
            $number1 = str_replace(',', '', $number);
            $datve->tong_gia_tien = $number1;

            $tong_so_ve = 0;
            $loaive = explode(',', $request->input('loai_ve'));
            foreach ($loaive as $loai) {
                $ve = explode(':', $loai);
                if (isset($ve[1])) {
                    $tong_so_ve += (int) $ve[1];
                }

            }

            $datve->tong_so_ve = $tong_so_ve;
            $datve->trang_thai = 'Đang chờ thanh toán';
            $datve->ngay_dat = $request->ngay_dat;
            $datve->save();

            $gheId = explode(',', $request->ghe);
            $index = 0;


            foreach ($loaive as $loaiveItem) {
                [$maloaive, $soluong] = explode(':', $loaiveItem);
                $loai = LoaiVe::find($maloaive);

                for ($i = 0; $i < $soluong; $i++) {
                    if (isset($gheId[$index])) {
                        VeDat::create([
                            'ma_ve' => $datve->ma_ve,
                            'ma_loai_ve' => $maloaive,
                            'so_luong' => 1,
                            'gia_tien' => $soluong * $loai->gia_ve,
                            'ma_ghe' => $gheId[$index]
                        ]);
                        $index++;
                    }

                }

            }

            if (!empty($request->bap_nuoc)) {
                $dichVuData = explode(',', $request->bap_nuoc);
                foreach ($dichVuData as $dvItem) {
                    [$madv, $soLuongDv] = explode(':', $dvItem);
                    $loaDv = DvAnUong::find($madv);

                    ChiTietDv::create([
                        'ma_ve' => $datve->ma_ve,
                        'ma_dv_an_uong' => $madv,
                        'so_luong' => $soLuongDv,
                        'tong_gia_tien' => $soLuongDv * $loaDv->gia_tien
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                "success" => true,
                "ma_ve" => $datve->ma_ve
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác nếu có lỗi
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi đặt vé!',
                'error' => $e->getMessage()
            ], 500);
        }
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
