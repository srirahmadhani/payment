<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'employee_nik';

    protected $table = 'employees';

    protected $fillable = [
        'employee_nik',
        'employee_name',
        'gender',
        'phone',
        'address',
        'id_position',
        'username',
        'password',
        'status'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class , 'id_position', 'position_id');
    }

    public function topup()
    {
        return $this->hasMany(HistoryTopup::class);
    }

     public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }


}

