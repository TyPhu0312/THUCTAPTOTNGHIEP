<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exam';
    protected $primaryKey = 'exam_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'exam_id',
        'sub_list_id',//Khoá ngoại
        'title',
        'content',
        'type',
        'isSimultaneous',
        'start_time',
        'end_time',
        'status',
    ];
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($exam) {
            $exam->exam_id = (string) Str::uuid();
        });
    }

    // Danh sách trạng thái hợp lệ
    public static function getAllowedStatuses()
    {
        return ['Pending', 'Processing', 'Completed'];
    }

    // Danh sách kiểu bài thi hợp lệ
    public static function getAllowedTypes()
    {
        return ['Trắc nghiệm', 'Tự luận'];
    }

    // Quan hệ với sub_list
    public function sublist()
    {
        return $this->belongsTo(SubList::class, 'sub_list_id');
    }
}
