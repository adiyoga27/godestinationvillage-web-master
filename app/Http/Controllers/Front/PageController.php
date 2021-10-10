<?php
namespace App\Http\Controllers\Front;
use App\Models\Blog;

use App\Models\User;

use App\Models\Order;

use App\Models\Review;

use App\Models\Package;

use App\Models\Category;

use App\Models\BankAccount;

use App\Helpers\CustomImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PackageTranslations;
use App\Models\Tag;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class PageController extends Controller

{

    public function index()

    {

        $data['village'] = User::where('role_id', '2')->where('is_active', '1')->limit(8)->get();
        $data['packages'] = Package::orderBy('desc')->limit(8)->get();
        $data['recent_blog'] = Blog::where('isPublished', '1')->latest('created_at')->limit(5)->get();
        $data['category'] = Category::All();
        $data['users'] = Storage::files('reviews');
        $data['reviews'] = Review::with('users')->get();
        $data['tag'] = Tag::all();
        // dd($data['reviews']);

        return view('customer.home', $data);
    }

    public function homebaru()

    {

        $data['village'] = User::where('role_id', '2')->where('is_active', '1')->limit(8)->get();

        $data['packages'] = Package::orderBy('desc')->limit(8)->get();

        $data['recent_blog'] = Blog::where('isPublished', '1')->latest('created_at')->limit(5)->get();

        $data['category'] = Category::All();

        return view('customer/homebaru', $data);
    }



    public function blog()
    {

        $data['blog'] = Blog::where('isPublished', '1')->latest('created_at')->paginate(5);

        $data['recent'] = Blog::where('isPublished', '1')->latest('created_at')->limit(4)->get();

        return view('customer/blog', $data);
    }



    public function detailpost($id)
    {

        $data['blog'] = Blog::where('isPublished', '1')->find($id);



        if (!$data['blog']) {

            return abort(404);
        }

        $data['recent'] = Blog::where('isPublished', '1')->latest('created_at')->limit(5)->get();

        return view('customer/detail-blog', $data);
    }

    public function blog_mobile()
    {

        $data['blog'] = Blog::where('isPublished', '1')->latest('created_at')->paginate(5);

        $data['recent'] = Blog::where('isPublished', '1')->latest('created_at')->limit(4)->get();

        return view('customer/blog-mobile', $data);
    }



    public function detailpost_mobile($id)
    {

        $data['blog'] = Blog::where('isPublished', '1')->find($id);



        if (!$data['blog']) {

            return abort(404);
        }

        $data['recent'] = Blog::where('isPublished', '1')->latest('created_at')->limit(5)->get();

        return view('customer/detail-blog-mobile', $data);
    }

    public function village()

    {

        $data['village'] = User::where('role_id', '2')->where('is_active', '1')->paginate(30);

        return view('customer/village', $data);
    }



    public function detailVillage($id)

    {

        $data['village'] = User::where('users.id', $id)

            ->where('is_active', '1')

            ->where('role_id', '2')

            ->first();



        if (!$data['village']) {

            return abort(404);
        }



        $data['packages'] = Package::with(['category', 'user', 'village'])
                                        ->where('user_id', $id)
                                        ->where('packages.is_active', '1')
                                        ->paginate(8);




        $data['recent'] = Package::select('packages.id','packages.name', 'categories.name as cat_name', 'village_details.village_name as vil_name', 'default_img')
                ->join('users', 'users.id', 'user_id')
                ->join('village_details', 'users.id', 'village_details.user_id')
                ->join('categories', 'categories.id', 'category_id')
                ->where('users.is_active', '1')
                ->where('packages.is_active', '1')
                ->orderBy('packages.id', 'desc')
                ->limit(5)->get();

        return view('customer/detailvillage', $data);
    }



    public function tourpackages()

    {
        $data['packages'] = Package::select('packages.name', 'categories.name as cat_name', 'village_details.village_name as vil_name', 'price', 'packages.desc', 'packages.id', 'default_img')->join('users', 'users.id', 'user_id')->join('village_details', 'users.id', 'village_details.user_id')->join('categories', 'categories.id', 'category_id')->where('users.is_active', '1')->where('packages.is_active', '1')->paginate(10);
        // dd($data);
        return view('customer/tourpackages', $data);
    }

    public function homeStay()

    {
        $data['packages'] = [];
        // dd($data);
        return view('customer/homestay', $data);
    }

    public function eventsGodevi()

    {
        $data['packages'] = Package::select('packages.name', 'categories.name as cat_name', 'village_details.village_name as vil_name', 'price', 'packages.desc', 'packages.id', 'default_img', 'paywish')->join('users', 'users.id', 'user_id')->join('village_details', 'users.id', 'village_details.user_id')->join('categories', 'categories.id', 'category_id')->where('users.is_active', '1')->where('packages.is_active', '1')->where('packages.category_id', '5')->paginate(10);
 
        // dd($data);
        return view('customer/events', $data);
    }


    public function categorypackage($id)

    {



        $data['packages'] = Package::select('packages.name', 'categories.name as cat_name', 'village_details.village_name as vil_name', 'price', 'packages.desc', 'packages.id', 'default_img')
            ->join('users', 'users.id', 'user_id')
            ->join('village_details', 'users.id', 'village_details.user_id')
            ->join('categories', 'categories.id', 'category_id')
            ->where('users.is_active', '1')
            ->where('packages.is_active', '1')
            ->where('packages.tag_id', $id)

            ->paginate(10);
        // dd($data);
        return view('customer/tourpackages', $data);
    }








    public function detailtour($id)

    {

        $data['images'] = Storage::files('packages/' . $id);
      
   
            $data['packages'] = Package::with(['village', 'category','translate'])->where('id', $id)
            ->first();
        
        if (!$data['packages']) {
            return abort(404);
        }


        $data['recent'] = Package::select('packages.id', 'packages.name', 'categories.name as cat_name', 'village_details.village_name as vil_name', 'default_img')
                                    ->join('users', 'users.id', 'user_id')
                                    ->join('village_details', 'users.id', 'village_details.user_id')
                                    ->join('categories', 'categories.id', 'category_id')->where('users.is_active', '1')->where('packages.is_active', '1')->orderBy('packages.id', 'desc')->limit(5)->get();

        // $data['recent'] = Package::orderBy('desc')->limit(5)->get();

        // var_dump($data['packages']);

        return view('customer/detailtour', $data);
    }



    public function faq()

    {

        return view('customer/faq');
    }

    public function services()

    {

        return view('customer/services');
    }


    public function term()

    {

        return view('customer/terms');
    }

    public function ourteam()

    {

        return view('customer/ourteam');
    }

    public function ourpartner()

    {

        return view('customer/ourpartner');
    }



    public function reservation(Request $request)

    {

        $data['order'] = Order::where('payment_status', NULL)

            ->where('customer_email', $request->email)

            ->orderBy('id', 'desc')

            ->paginate(10);

        $data['isiemail'] = $request->email;

        return view('customer/reservation/reservation', $data);
    }



    public function contact()

    {

        return view('customer/contact');
    }



    public function payment($id)

    {
        $data['order'] = Order::where('payment_type', NULL)
            ->where('id', $id)
            ->first();
        $data['bank'] =  BankAccount::all();
        return view('customer/payment/payment', $data);
    }


    public function detailPayment($id)

    {
        $data['order'] = Order::whereNotNull('payment_type')->with('bank_account')
            ->where('id', $id)
            ->first();
        $data['bank'] =  BankAccount::all();
        return view('customer/payment/detail', $data);
    }
    public function confirmPayment($id)

    {
        $data['order'] = Order::whereNotNull('payment_type')->with('bank_account')
            ->where('id', $id)
            ->first();
        $data['bank'] =  BankAccount::all();
        return view('customer/payment/confirmation', $data);
    }




    public function cancel($id)

    {

        $proses = Order::find($id);



        $proses->payment_status = 'cancel';





        $proses->save();

        if ($proses) {

            return redirect('reservation/cancel/' . $proses->customer_email);
        }
    }



    public function booking($id)

    {

        $data['packages'] = Package::where('id', $id)

            ->first();

        if (Auth::check()) {

            $userId = Auth::id();

            $data['user'] = User::where('id', $userId)

                ->first();
        }

        return view('customer/bookform', $data);
    }
    
    public function bookingEvents($id)

    {

        $data['packages'] = Package::where('id', $id)

            ->first();

        if (Auth::check()) {

            $userId = Auth::id();

            $data['user'] = User::where('id', $userId)

                ->first();
        }

        return view('customer/bookformEvents', $data);
    }



    public function account()

    {



        if (Auth::check()) {

            $userId = Auth::id();

            $data['user'] = User::where('id', $userId)

                ->first();
        }

        return view('customer/account', $data);
    }

    public function accountUpdate(Request $request)

    {

        try {
            if (!empty($request['uploadfile'])) {
                $upload = CustomImage::storeImage($request->file('uploadfile'), 'users');
                $payload['avatar'] = $upload['name'];
            }

            $payload['name'] = $request['customername'];
            $payload['email'] = $request['email'];
            $payload['phone'] = $request['phone'];
            $payload['country'] = $request['country'];
            $payload['address'] = $request['address'];
            // dd($payload);

            User::where('id', $request['customerid'])->update($payload);
        } catch (\Throwable $th) {
            return $th;
        }
        return redirect('account');
    }





    public function login()

    {

        return view('customer/login');
    }



    public function register()

    {

        return view('customer/register');
    }
    public function companyprofile()

    {

        return view('customer/companyprofile');
    }
}
