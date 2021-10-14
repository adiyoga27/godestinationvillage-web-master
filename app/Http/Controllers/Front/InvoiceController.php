<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OrderEventService;
use App\Services\OrderHomestayService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Crypt;
use PDF;

class InvoiceController extends Controller
{

	public function index($id)
	{
		$id = Crypt::decrypt($id);
		$order = OrderService::find($id);

        return view('backend.order.invoice')->with(compact('order'));
	}

	public function event($id)
	{
		$id = Crypt::decrypt($id);

		$order = OrderEventService::find($id);

        return view('backend.events.order.invoice')->with(compact('order'));
	}

	public function homestay($id)
	{
		$id = Crypt::decrypt($id);

		$order = OrderHomestayService::find($id);

        return view('backend.homestay.order.invoice')->with(compact('order'));
	}

}