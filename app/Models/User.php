<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'slug', 'phone', 'title',
        'location', 'country', 'timezone', 'bio', 'profile_photo', 'cover_photo',
        'linkedin', 'twitter', 'website', 'is_active', 'is_featured',
        'hourly_rate', 'currency', 'years_experience', 'avg_rating',
        'total_reviews', 'total_students',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'avg_rating' => 'float',
            'hourly_rate' => 'float',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if (empty($user->slug)) {
                $user->slug = Str::slug($user->name) . '-' . Str::random(5);
            }
        });
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMentor(): bool
    {
        return $this->role === 'mentor';
    }

    public function isMentee(): bool
    {
        return $this->role === 'mentee';
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function enrollments()
    {
        return $this->hasMany(PackageRegister::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'mentor_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class)->orderBy('sort_order');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class)->orderBy('sort_order');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class)->orderBy('sort_order');
    }

    public function professionals()
    {
        return $this->hasMany(Professional::class)->orderBy('sort_order');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_user');
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4F46E5&color=fff';
    }

    public function getCoverPhotoUrlAttribute()
    {
        if ($this->cover_photo) {
            return asset('storage/' . $this->cover_photo);
        }
        return null;
    }
}
