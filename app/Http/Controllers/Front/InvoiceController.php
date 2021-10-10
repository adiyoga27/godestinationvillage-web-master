<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OrderEventService;
use App\Services\OrderService;
use PDF;

class InvoiceController extends Controller
{

	public function index($id)
	{
		$order = OrderService::find($id);

        return view('backend.order.invoice')->with(compact('order'));
	}

	public function event($id)
	{
		$order = OrderEventService::find($id);

        return view('backend.events.order.invoice')->with(compact('order'));
	}

}