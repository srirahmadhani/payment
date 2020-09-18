<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'employee_id';

    protected $table = 'employees';

    protected $fillable = ['employee_id','NIK', 'employee_name', 'gender', 'phone', 'address', 'id_position'];

    public function user()
    {
        return $this->belongsTo(User::class , 'employee_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class , 'id_position', 'position_id');
    }

    public function topup()
    {
        return $this->hasMany(Topup::class);
    }

     public function payment()
    {
        return $this->hasMany(Payment::class);
    }


}

