<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Mail\SalesReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class SendSalesReport extends Command
{
    protected $signature = 'send:salesreport';
    protected $description = 'Gửi báo cáo doanh số hàng ngày';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
       
          
        $today = Carbon::today();
        $salesData = DB::table('order_items')
                        ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(quantity * unit_price) as total_revenue'))
                        ->whereDate('created_at', $today)
                        ->groupBy('product_id')
                        ->get();
                        $totalRevenue = $salesData->sum('total_revenue');
            $salesReport = "<h1>Báo Cáo Doanh Số Hôm Nay</h1>";
            foreach ($salesData as $item) {
                $product = DB::table('products')->where('id', $item->product_id)->first();
                $productName = $product ? $product->name : 'Không xác định';
                $salesReport .= "Sản phẩm: $productName,    đã bán: $item->total_quantity<br>";
            }
            $salesReport .= "<br><strong>Tổng doanh thu hôm nay: " . number_format($totalRevenue) . " VNĐ</strong>";

            Mail::to('nguyenkiet2903@gmail.com')->send(new SalesReportMail($salesReport));
            
          
       
    }
}
