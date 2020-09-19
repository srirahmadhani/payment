<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Payment extends Model
{
    public $timestamps = false;

    protected $table = "payments";

    protected $primaryKey = 'payment_id';

    protected $keyType = 'string';

    protected $fillable = [
        'payment_id', 'payment_date', 'qty', 'total', 'visitor_id', 'ticket_id', 'employee_id',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id', 'visitor_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }

      public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function reportPaymentsPerYear($year)
    {
        return DB::select("SELECT monthname(times.date) AS bulan, IFNULL(payments_year.total, 0) AS total from times LEFT JOIN (SELECT MONTHNAME(payment_date) AS bulan, sum(total) AS total FROM payments WHERE year(payment_date) = ? group by MONTH(payment_date) ORDER BY payment_date ASC) payments_year ON monthname(date) = payments_year.bulan WHERE year(times.date) = ? GROUP BY month(times.date) ORDER BY times.date ASC", [$year, $year]);
    }

    public function reportPaymentsPerYearDonat($yeard)
    {
        return DB::select("select tickets.ticket_id, tickets.ticket_name , IFNULL(total,0) as total from tickets LEFT JOIN (SELECT ticket_id, (qty*count(ticket_id)) AS total FROM payments WHERE year(payment_date) = ? group by ticket_id ORDER BY payment_date asc) tickets_year ON tickets.ticket_id = tickets_year.ticket_id order by tickets.ticket_name asc", [$yeard, $yeard]);
    }
}
