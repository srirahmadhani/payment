<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'employee_id';

    protected $keyType = 'string';

    protected $table = 'employees';

    protected $fillable = ['NIK', 'employee_name', 'gender', 'phone', 'address', 'id_position', 'employee_id'];

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

}

