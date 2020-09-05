<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Visitor extends Model

{
    public $timestamps = false;

    protected $table = "visitors";

    protected $primaryKey = 'visitor_id';

    // protected $keyType = 'string';

    protected $fillable = [
        'visitor_id', 'visitor_name', 'gender', 'address', 'visitor_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'visitor_id', 'id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'visitor_id', 'visitor_id');
    }

    public function topup()
    {
        return $this->hasMany(Topup::class, 'visitor_id', 'visitor_id');
    }

    public function getVisitorWithSaldo()
    {
        return DB::select("SELECT visit.*, users.* 
                FROM `visitors` visit 
                JOIN users ON visit.visitor_id = users.id");
    }

    public function getVisitorSaldoTotal()
    {
        return DB::select("SELECT SUM(( SELECT IFNULL(SUM(amount), 0) FROM topup WHERE id_visitor = visit.visitor_id ) - ( SELECT IFNULL(SUM(total), 0) FROM payments WHERE visitor_id = visit.visitor_id )) AS saldo FROM `visitors` visit");
    }
}
