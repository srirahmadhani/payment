<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffWahana extends Model
{
    Protected $table = "staff_wahana";

    protected $primaryKey = 'id_staff_wahana';

    protected $keyType= 'string';

	protected $fillable = [
        'id_staff_wahana',
        'employee_nik',
        'wahana_id',
        'date'
    ];

    public $timestamps = false;

    public function wahana()
    {
        return $this->hasOne(Wahana::class , 'wahana_id', 'wahana_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class , 'employee_nik', 'employee_nik');
    }
}
