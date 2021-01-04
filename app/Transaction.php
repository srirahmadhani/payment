<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Transaction extends Model
{
    public $timestamps = false;

    protected $table = "transactions";

    protected $primaryKey = 'transaction_id';

    protected $keyType = 'string';

    protected $fillable = [
        'transaction_id',
        'transaction_date',
        'qty',
        'total',
        'visitor_id',
        'wahana_id'
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id', 'visitor_id');
    }

    public function wahana()
    {
        return $this->belongsTo(Ticket::class, 'wahana_id', 'wahana_id');
    }

      public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_nik', 'employee_nik');
    }

    public function reportTransactionsPerYear($year)
    {
        return DB::select("SELECT monthname(times.date) AS bulan, IFNULL(transactions_year.total, 0) AS total from times LEFT JOIN (SELECT MONTHNAME(transaction_date) AS bulan, sum(total) AS total FROM transactions WHERE year(transaction_date) = ? group by MONTH(transaction_date) ORDER BY transaction_date ASC) transactions_year ON monthname(date) = transactions_year.bulan WHERE year(times.date) = ? GROUP BY month(times.date) ORDER BY times.date ASC", [$year, $year]);
    }

    public function reportTransactionsPerYearDonat($yeard)
    {
        return DB::select("select wahanas.wahana_id, wahanas.wahana_name , IFNULL(total,0) as total from wahanas LEFT JOIN (SELECT wahana_id, (qty*count(wahana_id)) AS total FROM transactions WHERE year(transaction_date) = ? group by wahana_id ORDER BY transaction_date asc) wahanas_year ON wahanas.wahana_id = wahanas_year.wahana_id order by wahanas.wahana_name asc", [$yeard, $yeard]);
    }
}
