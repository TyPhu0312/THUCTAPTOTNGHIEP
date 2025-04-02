<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Options extends Model
{
    use HasFactory;
    protected $table = 'options';
    protected $primaryKey = 'option_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'option_id',
        'question_id',//khoá phụ
        'option_text',
        'is_correct',
        'option_order',
    ];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($options) {
            $options->option_id = (string) Str::uuid();
        });
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
