<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NguoiDungController extends Controller
{
    public function DangKi(Request $rq)
    {
        $vali = Validator::make($rq->all(),[
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|unique:nguoi_dung,email',
            'mat_khau' => 'required|min:8',
            'sdt' => 'required|string|max:10',
            'vai_tro'=> 'required|string|max:10',
            'ngay_sinh' => 'required|date',
            'gioi_tinh' => 'required'
        ]);
        if($vali->fails())
        {
            return response()->json([
                'message' => 'Dữ liệu ko hợp lệ',
                'error' => $vali ->errors()
            ],422);
        }

        $nguoi_dung =NguoiDung::create([
            'ho_ten' => $rq -> ho_ten,
            'email' =>$rq -> email,
            'mat_khau'=> bcrypt($rq ->mat_khau),
            'sdt' => $rq->sdt,
            'vai_tro' => $rq->vai_tro,
            'ngay_sinh' => $rq->ngay_sinh,
            'gioi_tinh' => $rq->gioi_tinh,
        ]);
        return response()->json([
            'message' => 'Đăng kí thành công',
            'nguoi_dung' =>$nguoi_dung
        ],201);
    }
}
