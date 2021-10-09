<?php

namespace App\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Blog;
use App\Http\Resources\Collections\UnpaidCollection;
use App\Http\Resources\Slider\SliderCollection;
use App\Models\Package;
use App\Services\UserService;
use App\Traits\JsonResponseTrait;

class PageControllerApi extends Controller
{
    use JsonResponseTrait;
    public function slider()
    {
        $data = new SliderCollection(UserService::getSliders());
        
         return  $this->responseDataMessage($data);
        
        // return $this->errorResponseMessage("Gagal");
        
    }

    public function reservation(Request $request)
    {

        $data= Order::where('payment_status', NULL)
        ->with('package')

            ->where('customer_email', $request->email)

            ->orderBy('id', 'desc')

            ->paginate(10);

        $result = new UnpaidCollection($data);
        return $this->responseDataMessage($result);
    }

    public function paypal(Request $request)
    {

        $data= Order::where('payment_status', NULL)
        ->with('package')

            ->where('customer_email', $request->email)

            ->orderBy('id', 'desc')

            ->paginate(10);

        $result = new UnpaidCollection($data);
        return $this->responseDataMessage($result);
    }
    
    public function bank(Request $request)
    {

        $data= Order::where('payment_status', NULL)
        ->with('package')

            ->where('customer_email', $request->email)

            ->orderBy('id', 'desc')

            ->paginate(10);

        $result = new UnpaidCollection($data);
        return $this->responseDataMessage($result);
    }
    
    public function cancel(Request $request)
    {

        $data= Order::where('payment_status', NULL)
        ->with('package')

            ->where('customer_email', $request->email)

            ->orderBy('id', 'desc')

            ->paginate(10);

        $result = new UnpaidCollection($data);
        return $this->responseDataMessage($result);
    }



}
