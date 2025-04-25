<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class DangNhapController extends Controller
{
    public function dangNhap(Request $rq)
    {
        $rq->validate([
            'email_or_sdt' =>'required',
            'password' => 'required',
        ]);
        $nguoi_dung= NguoiDung::where('email',$rq->email_or_sdt)
        ->orwhere('sdt',$rq->email_or_sdt)
        ->first();

        if(!$nguoi_dung || !Hash::check($rq->password,$nguoi_dung-> mat_khau)) {
            return response()->json(['message' =>'Sai thông tin đăng nhập'],401);
        }
        $token =$nguoi_dung->createToken('Token người dùng')->plainTextToken;

        return response()->json([
            'message' =>'Đăng nhập thành công',
            'access_token' =>$token,
            'nguoi_dung'=>[
                'ma_nguoi_dung'=> $nguoi_dung->ma_nguoi_dung,
                'ho_ten' => $nguoi_dung->ho_ten,
                'vai_tro'=>$nguoi_dung->vai_tro,
                'email' =>$nguoi_dung->email,
            ]
            ]);
    }

}
