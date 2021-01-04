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
        'visitor_id',
        'visitor_name',
        'gender',
        'address',
        'username',
        'password',
        'status'
    ];


    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'visitor_id', 'visitor_id');
    }

    public function topup()
    {
        return $this->hasMany(HistoryTopup::class, 'visitor_id', 'visitor_id');
    }


    public function getVisitorSaldoTotal()
    {
        return DB::select("SELECT SUM(( SELECT IFNULL(SUM(amount), 0) FROM topup WHERE id_visitor = visit.visitor_id ) - ( SELECT IFNULL(SUM(total), 0) FROM transactions WHERE visitor_id = visit.visitor_id )) AS saldo FROM `visitors` visit");
    }
}
