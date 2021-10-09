<?php

namespace App\Exports;

use App\Services\OrderService;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportOrderExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;
    var $village;
    var $package;
    var $start_date;
    var $end_date;

    public function __construct($village, $package, $start_date, $end_date)
    {
        $this->village = $village;
        $this->package = $package;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function query()
    {
        return OrderService::search_order($this->village, $this->package, $this->start_date, $this->end_date);
    }

    public function map($order): array
    {
        return [
            $order->rownum,
            $order->code,
            date('Y-m-d', strtotime($order->created_at)),
            $order->checkin_date,
            $order->village_name,
            $order->customer_name,
            $order->customer_email,
            $order->customer_phone,

            $order->package_name,
            $order->package_price,
            $order->pax,
            $order->total_payment,
            $order->payment_type,
            $order->payment_status
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Order',
            'Tanggal Pemesanan',
            'Tanggal Kedatangan',
            'Nama Desa',
            'Nama Customer',
            'Email',
            'Handphone',

            'Nama Paket',
            'Harga Paket',
            'Pax',
            'Total',
            'Metode Pembayaran',
            'Status Pembayaran'
        ];
    }
}