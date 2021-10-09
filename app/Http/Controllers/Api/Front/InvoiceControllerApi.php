<?php

namespace App\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Traits\JsonResponseTrait;

class InvoiceControllerApi extends Controller
{
    use JsonResponseTrait;
    public function index($id)
	{
		$order = OrderService::find($id);

        return $this->responseDataMessage($order);
	}
}