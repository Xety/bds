<?php
namespace BDS\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    /**
     * Get the user that owns the account.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
