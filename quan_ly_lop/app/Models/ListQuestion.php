<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ListQuestion extends Model
{
    use HasFactory;
    protected $table = 'list_question';
    protected $primaryKey = 'list_question_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'list_question_id',
        'course_id',//Khoá phụ
    ];
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($list_question) {
            $list_question->list_question_id = (string) Str::uuid();
        });
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
