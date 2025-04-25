<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class DangNhapController extends Controller
{
        /**
     * Đăng nhập tài khoản người dùng
     * 
     * @OA\Post(
     *     path="/api/dangnhap",
     *     summary="Đăng nhập người dùng",
     *     description="Đăng nhập bằng email hoặc số điện thoại và mật khẩu. Trả về access_token nếu thành công.",
     *     tags={"Đăng Nhập"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email_or_sdt", "password"},
     *             @OA\Property(property="email_or_sdt", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đăng nhập thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Đăng nhập thành công"),
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV..."),
     *             @OA\Property(
     *                 property="nguoi_dung",
     *                 type="object",
     *                 @OA\Property(property="ma_nguoi_dung", type="string", example="ND001"),
     *                 @OA\Property(property="ho_ten", type="string", example="Nguyễn Văn A"),
     *                 @OA\Property(property="vai_tro", type="string", example="khach_hang"),
     *                 @OA\Property(property="email", type="string", example="user@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Sai thông tin đăng nhập",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sai thông tin đăng nhập")
     *         )
     *     )
     * )
     */

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
