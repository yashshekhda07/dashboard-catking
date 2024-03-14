<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NpfWebhook extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'name',
        'email',
        'mobile',
        'urd',
        'origin',
        'source',
        'medium',
        'campaign',
        'stage',
        'owner',
        'traffic',
    ];

    protected $primaryKey = 'lead_id';
    public $incrementing = false;

    public function setUrdAttribute($value)
    {
        $this->attributes['urd'] = date("Y-m-d H:i:s", strtotime(str_replace(["/", ","], ["-", ""], $value)));
    }

}
