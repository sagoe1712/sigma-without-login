<?php

namespace App\Http\Controllers;


use App\Http\Proxy\Flight;
use App\Http\Requests\PostCartRequest;
use App\Order;
use App\State;
use App\Traits\EventsTrigger;
use App\Traits\EmailTemplates;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;
use Ixudra\Curl\Facades\Curl;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Repository\TransactionRepository;
use App\Http\Controllers\RecentViewController;

class FlightController extends Controller
{

    use EventsTrigger, EmailTemplates;

    //Zero based Status indicators


    private $cartstatus = [
        'cancelled' => 0,
        'pending' => 1,
        'shipped' => 2,
        'delivered' => 3,
        'processing' => 4,
        'expired' => 5,
        'deleted' => 6
    ];

    //Zero based Status indicators
    private $transtype = [
        'debit' => 0,
        'credit' => 1
    ];
    private $is_internal_action = [
        'external' => 0,
        'internal' => 1
    ];

    private $flightProxy;
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository, Flight $flightProxy)
    {
        $this->middleware(['web', 'auth']);
        $this->transactionRepository = $transactionRepository;
        $this->flightProxy = $flightProxy;
    }


    public function get_string_between($string1)
    {
        $string = $string1;
        $ini = strpos($string, '(');
        if ($ini == 0) return '';
        $ini += strlen('(');
        $len = strpos($string, ')', $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function index()
    {
        try {
            $title = "Flight";
            $getcountries = $this->flightProxy->getCountries();
            $popularlocation = $this->flightProxy->getPopular();

//            dd($getcountries);
            $countries = $getcountries->data;

            return view('pages.flight.index', compact('title', 'countries', 'popularlocation'));

        } catch (\Exception $e) {
            return response()->redirectToRoute('no_content');
        }
    }

    public function getairports($search)
    {

        $getcountries = $this->flightProxy->getAirports($search);

//            dd($getcountries);
        $data = [];
        if ($getcountries->status === 1) {
            $data = $getcountries->data;
        } else {
            $a = [];
            $a["detail_name"] = "No Airport Found";
            $data = [$a];
        }

        return response()->json($data, 200);

    }

    public function search(Request $request)
    {


        try {
            $title = "Flight Search";
            $data = [];
            $search = [];
            $search_parameter = ['origin' => $request->originairport, 'destination' => $request->destinationairport, 'adults' => $request->adult, 'children' => $request->children, 'infants' => $request->infant];

            if ($request->cabinclass == 'M') {
                $search_parameter['cabin'] = 'Economy';
            } elseif ($request->cabinclass == 'F') {
                $search_parameter['cabin'] = 'First Class';
            } elseif ($request->cabinclass == 'C') {
                $search_parameter['cabin'] = 'Business Class';
            } elseif ($request->cabinclass == 'W') {
                $search_parameter['cabin'] = 'Premium Economy';
            } elseif ($request->cabinclass == 'Y') {
                $search_parameter['cabin'] = 'Economy';
            }
            $flights = [];
//dd($request->all());
            if ($request->travel == "Oneway") {
                $origin = $this->get_string_between($request->originairport);
                $destination = $this->get_string_between($request->destinationairport);
                $timestamp = strtotime($request->departdate);
                $newdate = date('m-d-Y', $timestamp);
                $departdate = date('d-m-Y', $timestamp);

                $search_parameter['travel'] = "Oneway";
                $search_parameter['depart_date'] = $departdate;

                $data['member_no'] = Auth::user()->member_id;;
//    $data['search'] = $origin;
                $data['adults'] = $request->adult;
                $data['children'] = $request->children;
                $data['infants'] = $request->infant;
                $data['ticket_class'] = $request->cabinclass;
                $data['flight_search_type'] = 'Oneway';
                $one_array['Departure'] = $origin;
                $one_array['Destination'] = $destination;
                $one_array['DepartureDate'] = $newdate;
                $main_array [] = $one_array;

                $data['itineraries'] = json_encode($main_array);


//    dd($data);

                $search = $this->flightProxy->flightSearch($data);

//    dd($search);


            } elseif ($request->travel == "Return") {
                $origin = $this->get_string_between($request->originairport);
                $destination = $this->get_string_between($request->destinationairport);
                $timestamp = strtotime($request->departdate);
                $newdate = date('m-d-Y', $timestamp);

                $rtimestamp = strtotime($request->returndate);
                $rnewdate = date('m-d-Y', $rtimestamp);
                $returndate = date('d-m-Y', $rtimestamp);

                $departdate = date('d-m-Y', $timestamp);

                $search_parameter['travel'] = "Return";
                $search_parameter['depart_date'] = $departdate;
                $search_parameter['return_date'] = $returndate;

                $data['member_no'] = Auth::user()->member_id;;
//    $data['search'] = $origin;
                $data['adults'] = $request->adult;
                $data['children'] = $request->children;
                $data['infants'] = $request->infant;
                $data['ticket_class'] = $request->cabinclass;
                $data['flight_search_type'] = 'Return';
                $one_array['Departure'] = $origin;
                $one_array['Destination'] = $destination;
                $one_array['DepartureDate'] = $newdate;
                $main_array [] = $one_array;
                $one_array['Departure'] = $destination;
                $one_array['Destination'] = $origin;
                $one_array['DepartureDate'] = $rnewdate;
                $main_array [] = $one_array;

                $data['itineraries'] = json_encode($main_array);


                $search = $this->flightProxy->flightSearch($data);


            }
//        dd($search);
            if (isset($search)) {
                if ($search->status == 1) {
                    $flights = $search->data;
                    $status = 1001;
//    dd($search_parameter);
                    return view('pages.flight.search', compact('flights', 'status', 'search_parameter'));

                } else {
                    $message = "No Flights Available";
                    $status = 0;
                    return view('pages.flight.search', compact('status', 'message', 'search_parameter'));
                }
            } else {
                $message = "Flight Search Timeout";
                $status = 0;
                return view('pages.flight.search', compact('status', 'message', 'search_parameter'));

            }

        } catch (\Exception $e) {
            return response()->redirectToRoute('no_content');
        }
    }

    public function details(Request $request)
    {
//        try {
            $title = "Flight Detail";
            $data =[];
            $data['member_no']= Auth::user()->member_id;
            $data['product_code'] = $request->productcode;

            $search_parameter = json_decode($request->searchparameter);
//            dd($search_parameter);

            $response = $this->flightProxy->flightDetails($data);

//            dd($response);

            if (isset($response)) {
                if ($response->status == 1) {
                    $flight = $response->data;
                    $status = 1001;
//    dd($search_parameter);
                    return view('pages.flight.detail', compact('flight', 'status', 'title', 'search_parameter'));

                } else {
                    $message = $response->message;
                    $status = 0;
                    return view('pages.flight.detail', compact('status', 'message', 'title', 'search_parameter'));
                }
            } else {
                $message = "Flight Search Timeout";
                $status = 0;
                return view('pages.flight.detail', compact('status', 'message', 'title', 'search_parameter'));

            }

//        } catch (\Exception $e) {
//            return response()->redirectToRoute('no_content');
//        }
    }
}
