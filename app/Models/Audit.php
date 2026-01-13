<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit;

    protected $table = 'audits';

    protected $fillable = [
        'user_id', 'user_type', 'auditable_type', 'auditable_id', 'event', 'old_values', 'new_values', 'url', 'ip_address', 'user_agent', 'tags'
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
