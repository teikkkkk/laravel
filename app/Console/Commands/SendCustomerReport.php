<?php

namespace App\Console\Commands;

use App\Mail\CustomerReportMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Claims\Custom;

class SendCustomerReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:customerreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi báo cáo thông tin khách mua hàng trong ngày';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        //
      $today=Carbon::today();
      $customers=DB::table('orders')
      ->whereDate('orders.created_at',$today)
      ->select('orders.customer_name','orders.customer_phone','orders.customer_address')
      ->get();
      $report = "Báo cáo thông tin khách hàng mua hàng hôm nay:<br><br>";
      foreach ($customers as $customer) {
        $report .= "Khách hàng: {$customer->customer_name}, Địa chỉ: {$customer->customer_address}, Số điện thoại: {$customer->customer_phone}<br>";
    }

      Mail::to('nguyenkiet2903@gmail.com')->send(new CustomerReportMail($report) );
    }
}
