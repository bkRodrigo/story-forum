<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
    ];

    /**
     * Get the user that created the thread.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the messages associated with this thread.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Generates a list of users that have contributed to this thread
     *
     */
    public function contributors(): Collection
    {
        $userIds = [];
        foreach($this->messages as $message) {
            $userId = $message->user->id;
            if(!in_array($userId, $userIds)){
                array_push($userIds, $userId);
            }
        }
        return $users = User::whereIn('id', $userIds)->get();
    }
}
