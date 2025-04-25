<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'nguoi_dung';
    protected $primaryKey = 'ma_nguoi_dung';

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
        'sdt',
        'vai_tro',
        'ngay_sinh',
        'gioi_tinh',
    ];
    public $timestamps = true;
    public function getCreatedAtColumn()
    {
       return 'ngay_tao_nd';
    }
    public function getUpdatedAtColumn()
{
    return null; // hoặc return tên cột nếu bạn có
}

protected $hidden = [
    'mat_khau', // ẩn mật khẩu khi trả về JSON
];
}
