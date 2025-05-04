<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;



class Phim extends Model
{
    protected $table = 'phim';
    protected $primaryKey = 'ma_phim';
    public $timestamps = false;

    protected $casts = [
        'thoi_luong' => 'int',
        'ngay_phat_hanh' => 'datetime',
        'ngay_tao_phim' => 'datetime'
    ];

    protected $fillable = [
        'ten_phim',
        'mo_ta',
        'thoi_luong',
        'ngay_phat_hanh',
        'anh',
        'hinh_thuc_chieu',
        'dao_dien',
        'dien_vien',
        'trang_thai',
        'do_tuoi',
        'quoc_gia',
        'ngay_tao_phim'
    ];

    public function phim_loais()
    {
        return $this->hasMany(PhimLoai::class, 'ma_phim');
    }

    public function suat_chieus()
    {
        return $this->hasMany(SuatChieu::class, 'ma_phim');
    }

    public function rapChieu()
    {
        return $this->hasManyThrough(
            RapPhim::class,
            SuatChieu::class,
            'ma_phim',
            'ma_rap',
            'ma_phim',
            'ma_rap'
        );
    }



}
