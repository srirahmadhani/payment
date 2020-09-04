<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    Protected $table = "tickets";

    protected $primaryKey = 'ticket_id';

    protected $keyType= 'string';

	protected $fillable = [
        'ticket_id', 'ticket_name', 'price', 'image', 'info',
    ];

    public $timestamps = false;

    public function payment()
    {
        return $this->hasMany(Payment::class, 'ticket_id', 'ticket_id');
    }
}
