<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'goal',
        'amount_raised',
        'start_date',
        'end_date',
        'image',
		'featured',
        'is_active',
        'category_id'
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'goal' => 'decimal:2', // Pastikan goal disimpan sebagai decimal dengan 2 tempat desimal
    ];

    // Accessor untuk goal
    public function getGoalAttribute($value)
    {
        return number_format($value, 0, '.', ''); // Mengembalikan nilai tanpa desimal
    }

    // Mutator untuk goal
    public function setGoalAttribute($value)
    {
        // Menghilangkan desimal dan menyimpan sebagai float
        $this->attributes['goal'] = floatval(str_replace(',', '', $value));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
