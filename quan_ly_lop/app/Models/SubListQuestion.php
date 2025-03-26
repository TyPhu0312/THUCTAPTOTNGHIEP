<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubListQuestion extends Model
{
    use HasFactory;
    protected $table = 'sub_list_question';
    protected $primaryKey = 'sub_list_question_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sub_list_question_id',
        'sub_list_id', // Khóa ngoại
        'question_id',  // Khóa ngoại
    ];
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sub_list_question) {
            $sub_list_question->sub_list_question_id = (string) Str::uuid();
        });
    }

    // Quan hệ với bảng `sub_list`
    public function sub_list()
    {
        return $this->belongsTo(SubList::class, 'sub_list_id');
    }

    // Quan hệ với bảng `question`
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
