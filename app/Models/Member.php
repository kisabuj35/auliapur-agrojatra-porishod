<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\BanglaHelper;

class Member extends Model
{
    protected $guarded = [];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'member_id', 'member_id')
                    ->where('status', 'অনুমোদিত');
    }

    public function getCalculatedLedgerAttribute()
    {
        $months = BanglaHelper::getMonthsPassed($this->join_date, $this->end_date);
        $totalSubscription = ($months * $this->monthly_fee) + 50.00; // ৫০ টাকা ফরম ফি সহ
        $totalPaid = $this->payments()->sum('amount');
        $due = max(0, $totalSubscription - $totalPaid);

        return [
            'months' => $months,
            'total_accrued' => $totalSubscription,
            'total_paid' => $totalPaid,
            'due' => $due
        ];
    }
}
