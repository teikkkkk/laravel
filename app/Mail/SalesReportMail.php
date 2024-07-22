<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalesReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $salesData;

    public function __construct($salesData)
    {
        $this->salesData = $salesData;
    }

    public function build()
    {
        return $this->view('emails.sales_report')
                    ->with('salesData', $this->salesData);
    }
}
