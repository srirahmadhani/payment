<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    public $timestamps = false;

    protected $table = "topup";

    protected $primaryKey = 'topup_id';

    protected $keyType= 'string';

	protected $fillable = [
        'topup_id', 'topup_date', 'amount', 'id_visitor','employee_id',
    ];
   
   public function visitor()
    {
    	return $this->belongsTo(Visitor::class, 'id_visitor', 'visitor_id');
    }

    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
