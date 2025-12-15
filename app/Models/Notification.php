<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_global',
        'read_at',
    ];

    protected $casts = [
        'is_global' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhere('is_global', true);
        });
    }

    public static function createGlobal($title, $message, $type = 'info')
    {
        return static::create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_global' => true,
        ]);
    }

    public static function createForUser($userId, $title, $message, $type = 'info')
    {
        return static::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_global' => false,
        ]);
    }
}
