<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NguoiDungController extends Controller
{

        /**
     * Đăng ký tài khoản người dùng
     * 
     * @OA\Post(
     *     path="/api/dangki",
     *     summary="Đăng ký người dùng mới",
     *     description="Tạo tài khoản mới với thông tin đầy đủ",
     *     tags={"Đăng Ký"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"ho_ten", "email", "mat_khau", "sdt", "vai_tro", "ngay_sinh", "gioi_tinh"},
     *             @OA\Property(property="ho_ten", type="string", example="Nguyễn Văn A"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="mat_khau", type="string", format="password", example="12345678"),
     *             @OA\Property(property="sdt", type="string", example="0912345678"),
     *             @OA\Property(property="vai_tro", type="string", example="khach_hang"),
     *             @OA\Property(property="ngay_sinh", type="string", format="date", example="2000-01-01"),
     *             @OA\Property(property="gioi_tinh", type="string", example="Nam")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Đăng ký thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Đăng kí thành công"),
     *             @OA\Property(
     *                 property="nguoi_dung",
     *                 type="object",
     *                 @OA\Property(property="ho_ten", type="string", example="Nguyễn Văn A"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="sdt", type="string", example="0912345678"),
     *                 @OA\Property(property="vai_tro", type="string", example="khach_hang"),
     *                 @OA\Property(property="ngay_sinh", type="string", format="date", example="2000-01-01"),
     *                 @OA\Property(property="gioi_tinh", type="string", example="Nam")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dữ liệu không hợp lệ",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Dữ liệu ko hợp lệ"),
     *             @OA\Property(property="error", type="object")
     *         )
     *     )
     * )
     */

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
