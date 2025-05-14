<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\AccessToken;
use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\OrderItem;
use App\Models\OrderSeat;
use App\Models\OrderTopup;
use App\Models\PaymentMethod;
use App\Models\PosUser;
use App\Models\UserSession;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Traits\APITrait;

use Illuminate\Support\Facades\Validator;


class PosUserController extends Controller
{
  use APITrait;
  private TokenRepositoryInterface $tokenRepository;
  private UserRepositoryInterface $userRepository;
  private PosUserRepositoryInterface $posUserRepository;



  public function __construct(
    TokenRepositoryInterface $tokenRepository,
    UserRepositoryInterface $userRepository,
    PosUserRepositoryInterface $posUserRepository,

  ) {
    $this->tokenRepository = $tokenRepository;
    $this->userRepository = $userRepository;
    $this->posUserRepository = $posUserRepository;
  }

  public function login()
  {

    $form_data = clean_request([]);

    $validator = Validator::make($form_data, [
      'username' => 'required',
      'passcode' => 'required',
      'branch_id' => 'required'
    ]);

    if ($validator->errors()->count() > 0) {
      return  $this->responseValidation($validator);
    }


    try {
      $pos_user = $this->posUserRepository->getUserByUsername($form_data['username'], $form_data['branch_id']);
    } catch (\Exception $th) {

      return $this->response(notification()->error("You have entered invalid username, password or branch", $th->getMessage()));
    }


    // if (!$user) {
    //     return $this->response(notification()->error("You have entered invalid username/password or branch", 'You have entered invalid username/password or branch'));
    // }




    if (md5($form_data['passcode']) != $pos_user->passcode) {
      return $this->response(notification()->error("You have entered invalid pos_username/password or branch", 'You have entered invalid username/password or branch'));
    }

    // dd($form_data['branch_id'] , $pos_user->branch_id);
    // if ($form_data['branch_id'] != $pos_user->branch_id) {
    //     return $this->response(notification()->error("You have entered invalid username/password or branch", 'You have entered invalid username/password or branch'));
    // }


    $access_token = $this->tokenRepository->createAccessToken($pos_user, "POS");


    $user_session = new UserSession();
    $user_session->pos_user_id = $pos_user->id;
    $user_session->type = "LOGIN";
    $user_session->save();

    try {
      $managers = $this->posUserRepository->getManagers($form_data['branch_id']);
    } catch (\Exception $th) {
      return $this->response(notification()->error('Error', $th->getMessage()));
    }

    $manager_details = $managers->map(function ($manager) {
      return [
        'id' => $manager->id,
        'name' => $manager->name,
        'pincode' => $manager->pincode,

      ];
    });
    return $this->responseData([
      'user' => [
        'id' => $pos_user->id,
        'name' => $pos_user->name,
        'pincode' => $pos_user->pincode,
        'branch_id' => $pos_user->branch_id,
        'branch' => $pos_user->branch->label,

        'managers' => $manager_details,
      ],
      'access_token' => $access_token
    ]);
  }


  public function shiftSummaryCMS($id){


      if(!request()->input('date')){
          return view('pages.shift-summary-cms-date');
      }


      $pos_user = PosUser::find($id);

      if(!$pos_user){
          abort(404);
      }

      request()->merge(['user' => $pos_user]);


      $shiftSummary = $this->shiftSummary();


      return view('pages.shift-summary-cms', ['result' => $shiftSummary]);

  }

  public function logout()
  {

    $token = get_header_access_token();

    $access_token = $this->tokenRepository->getActiveAccessToken($token);

    if ($access_token) {
      $access_token->expires_at = now();
      $access_token->save();
    }
    $user_session = new UserSession();
    $user_session->pos_user_id = $access_token->user_id;
    $user_session->type = "LOGOUT";
    $user_session->save();

    return $this->response(notification()->success('Logged Out Successfully', 'Logged Out Successfully'));
  }

  public function getUserFromAccessToken()
  {

    $pos_user = request()->user;
    $access_token = get_header_access_token(); //in other projects to be replaced
    // dd($pos_user);

    try {
      $managers = $this->posUserRepository->getManagers($pos_user->branch_id);
    } catch (\Exception $th) {
      return $this->response(notification()->error('Error', $th->getMessage()));
    }

    $manager_details = $managers->map(function ($manager) {
      return [
        'id' => $manager->id,
        'name' => $manager->name,
        'pincode' => $manager->pincode,

      ];
    });

    return $this->responseData([
      'user' => [
        'id' => $pos_user->id,
        'name' => $pos_user->name,
        'pincode' => $pos_user->pincode,
        'branch_id' => $pos_user->branch_id,
        'branch' => $pos_user->branch->label,

        'managers' => $manager_details,
      ],
      'access_token' => $access_token
    ]);
  }




  public function shiftSummaryTable($array, $description_key, $total_key, $admits_key)
  {
    $result = [];
    $total = 0;
    $count = 0;

    foreach ($array as $item) {
      $total += $item->{$total_key};
      $count += $item->{$admits_key};
      $result[] = [
        $item->{$description_key},
        (string) $item->{$admits_key},
        currency_format($item->{$total_key})['display']
      ];
    }

    return ['count' => $count, 'total' => $total, 'result' => $result];
  }

  public function shiftSummary()
  {


    $r =  json_decode('{
            "cashier": {
              "name": "Hajer",
              "date": "2025-03-19",
              "time": ""
            },
            "tables": [
              {
                "label": "Net Tickets : Cash (+)",
                "header": [
                  "Ticket",
                  "Admits",
                  "Amount"
                ],
                "body": [
                  [
                    "BF Gold Class",
                    "6",
                    "75,000 IQD"
                  ],
                  [
                    "BF REG",
                    "2",
                    "10,000 IQD"
                  ],
                  [
                    "REG",
                    "20",
                    "200,000 IQD"
                  ]
                ],
                "footer": [
                  "Total",
                  "28",
                  "285,000 IQD"
                ],
                "order": 1
              },
              {
                "label": "Tickets Total : ",
                "header": [
                  "Ticket",
                  "Quantity",
                  "Amount"
                ],
                "body": [],
                "footer": [
                  "Total",
                  "28",
                  "285,000 IQD"
                ],
                "order": 2
              },
              {
                "label": "Imtiyaz Tickets : Cash (-) ",
                "header": [
                  "Ticket",
                  "Admits",
                  "Amount"
                ],
                "body": [
                  [
                    "BF REG",
                    "1",
                    "5,000 IQD"
                  ]
                ],
                "footer": [
                  "Total",
                  "1",
                  "5,000 IQD"
                ],
                "order": 13
              }
            ],
            "total": "280,000 IQD",
            "printed_at": "2025-03-20 13:08:16"
          }');


    $date = request()->input('date');

    if (!$date) {
      $date = Carbon::now();
    } else {
      $date = now()->parse($date);
    }

    $user = request()->user;


    $price_totals = [];
    $count_totals = [];

    $price_totals["1"] = 0;
    $price_totals["3"] = 0;
    $price_totals["5"] = 0;
    $price_totals["7"] = 0;
    $price_totals["9"] = 0;

    $count_totals["1"] = 0;
    $count_totals["3"] = 0;
    $count_totals["5"] = 0;
    $count_totals["7"] = 0;
    $count_totals["9"] = 0;

    $payment_methods = PaymentMethod::whereNull('deleted_at')->where('system_id', 2)->get();


    $result = [];

    $total = 0;

    $price_totals = [];
    $count_totals = [];

    $price_totals["1"] = 0;
    $price_totals["3"] = 0;
    $price_totals["5"] = 0;
    $price_totals["7"] = 0;
    $price_totals["9"] = 0;

    $count_totals["1"] = 0;
    $count_totals["3"] = 0;
    $count_totals["5"] = 0;
    $count_totals["7"] = 0;
    $count_totals["9"] = 0;

    $total_discounts = 0;

    foreach ($payment_methods as $payment_method) {

      $order_ids = Order::select('id')
        ->distinct('id')
        ->whereNull('deleted_at')
        ->where('payment_method_id', $payment_method->id)
        // ->where('completed', 1)
        ->where('pos_user_id', $user->id)
        ->whereDate('created_at', $date)
        ->pluck('id');


      $query = OrderSeat::query()
        ->select(
          DB::raw("
                    CONCAT(
                        COALESCE(price_groups.label, ''),
                        ' ',
                        COALESCE(
                            CASE
                                WHEN price_group_zones.default = 1 THEN NULL
                                ELSE price_group_zones.condensed_label
                            END, ''
                        )
                    ) AS full_description
                "),
          DB::raw('COUNT(*) as admits'),
          DB::raw('SUM(order_seats.price) as total')
        )
        ->whereIn('order_seats.order_id', $order_ids)
        ->leftJoin('price_group_zones', 'order_seats.zone_id', '=', 'price_group_zones.id')
        ->leftJoin('price_groups', 'price_group_zones.price_group_id', '=', 'price_groups.id');


      $seats = $query
        ->whereNull('order_seats.deleted_at')
        ->whereNull('order_seats.refunded_at')
        ->groupBy('full_description')
        ->get();



      $seats_obj = $this->shiftSummaryTable($seats, 'full_description', 'total', 'admits');



      $seats_imtiyaz = $query
        ->whereNull('order_seats.deleted_at')
        ->whereNotNull('order_seats.imtiyaz_phone')
        ->whereNull('order_seats.refunded_at')
        ->groupBy('full_description')
        ->get();


      $seats_imtiyaz_obj = $this->shiftSummaryTable($seats_imtiyaz, 'full_description', 'total', 'admits');

      if (count($seats_imtiyaz_obj['result']) > 0) {
        $result[] = [
          'label' => 'Imtiyaz Tickets : ' . $payment_method->label . ($payment_method->key == 'CASH' ? " (-) " : ""),
          'header' => ['Ticket', 'Admits', 'Amount'],
          'body' => $seats_imtiyaz_obj['result'],
          'footer' => ['Total', (string)$seats_imtiyaz_obj['count'], currency_format($seats_imtiyaz_obj['total'])['display']],
          'order' => 13
        ];
      }

      $refunded_seats = OrderSeat::query()
        ->select(
          DB::raw("
                CONCAT(
                    COALESCE(price_groups.label, ''),
                    ' ',
                    COALESCE(
                        CASE
                            WHEN price_group_zones.default = 1 THEN NULL
                            ELSE price_group_zones.condensed_label
                        END, ''
                    )
                ) AS full_description
            "),
          DB::raw('COUNT(*) as admits'),
          DB::raw('SUM(order_seats.price) as total')
        )
        ->whereIn('order_seats.order_id', $order_ids)
        ->leftJoin('price_group_zones', 'order_seats.zone_id', '=', 'price_group_zones.id')
        ->leftJoin('price_groups', 'price_group_zones.price_group_id', '=', 'price_groups.id')
        ->whereNull('order_seats.deleted_at')
        ->whereNotNull('order_seats.refunded_at')
        ->groupBy('full_description')
        ->get();




      $refunded_obj = $this->shiftSummaryTable($refunded_seats, 'full_description', 'total', 'admits');


      $items = OrderItem::select('label', DB::raw('count(*) as admits'), DB::raw('sum(price) as total'))->whereIn('order_id', $order_ids)->whereNull('deleted_at')->groupBy('label')->get();

      $items_obj = $this->shiftSummaryTable($items, 'description', 'total', 'admits');

      $topups = OrderTopup::select('label', DB::raw('count(*) as admits'), DB::raw('sum(price) as total'))->whereIn('order_id', $order_ids)->whereNull('deleted_at')->groupBy('label')->get();


      $topups_obj = $this->shiftSummaryTable($topups, 'label', 'total', 'admits');



      if ($payment_method->key == 'CASH') {

        $total_discounts = OrderCoupon::query()
          ->whereNull('deleted_at')
          ->whereIn('order_id', $order_ids)
          ->sum('amount');
      }


      // $topup_funds = WalletTopupsModel::select('description', DB::raw('count(*) as admits'), DB::raw('sum(amount) as total'))
      //     ->where('provider', $payment_method->provider)
      //     ->whereDate('created_at', $date)
      //     ->where('created_by', $user->id)
      //     ->groupBy('description')->get();

      // $topup_funds_obj = $this->shiftSummaryTable($topup_funds, 'description', 'total', 'admits');


      if (count($seats_obj['result']) > 0) {
        $result[] = [
          'label' => 'Net Tickets : ' . $payment_method->label . ($payment_method->key == 'CASH' ? " (+)" : ""),
          'header' => ['Ticket', 'Admits', 'Amount'],
          'body' => $seats_obj['result'],
          'footer' => ['Total', (string)$seats_obj['count'], currency_format($seats_obj['total'])['display']],
          'order' => 1
        ];

        // dd($result);
        $price_totals["1"] += $seats_obj['total'];
        $count_totals["1"] += $seats_obj['count'];
      }

      if (count($refunded_obj['result']) > 0) {
        $result[] = [
          'label' => 'Refund Tickets : ' . $payment_method->label . ($payment_method->key == 'CASH' ? " " : ""),
          'header' => ['Ticket', 'Quantity', 'Amount'],
          'body' => $refunded_obj['result'],
          'footer' => ['Total', (string)$refunded_obj['count'], currency_format($refunded_obj['total'])['display']],
          'order' => 3
        ];

        $price_totals["3"] += $refunded_obj['total'];
        $count_totals["3"] += $refunded_obj['count'];
      }
      //$items_obj['result']
      if (count($items_obj['result']) > 0) {
        $result[] = [
          'label' => 'Concession : ' . $payment_method->label,
          'header' => ['Ticket', 'Quantity', 'Amount'],
          'body' => [],
          'footer' => ['Total', (string)$items_obj['count'], currency_format($items_obj['total'])['display']],
          'order' => 5
        ];

        $price_totals["5"] += $items_obj['total'];
        $count_totals["5"] += $items_obj['count'];
      }

      if (count($topups_obj['result']) > 0) {




        $result[] = [
          'label' => 'Topups : ' . $payment_method->label . ($payment_method->key == 'CASH' ? " (+)" : ""),
          'header' => ['Ticket', 'Quantity', 'Amount'],
          'body' => [],
          'footer' => ['Total', (string)$topups_obj['count'], currency_format($topups_obj['total'])['display']],
          'order' => 7
        ];



        $price_totals["7"] += $topups_obj['total'];
        $count_totals["7"] += $topups_obj['count'];
      }
      // if (count($topup_funds_obj['result']) > 0) {
      //     $result [] = [
      //         'label' => 'Add Funds : ' . $payment_method->title . ($payment_method->provider == 'cash' ? " (+)" : ""),
      //         'header' => ['Ticket', 'Quantity', 'Amount'],
      //         'body' => [],
      //         'footer' => ['Total', (string)$topup_funds_obj['count'], currency_format($topup_funds_obj['total'])],
      //         'order' => 9
      //     ];

      //     $price_totals["9"] += $topup_funds_obj['total'];
      //     $count_totals["9"] += $topup_funds_obj['count'];
      // }


      if ($payment_method->key == "CASH") {
        //    $total += $topup_funds_obj['total'] + $topups_obj['total'] + $items_obj['total'] + ($seats_obj['total']) - $seats_imtiyaz_obj['total'] + $refunded_obj['total'];
        $total += $topups_obj['total'] + $items_obj['total'] + ($seats_obj['total']) - $seats_imtiyaz_obj['total'];
      }
    }

    $result = collect($result);

    // dd($result);

    if ($price_totals['1'] > 0) {
      $result->push(
        [
          'label' => 'Tickets Total : ',
          'header' => ['Ticket', 'Quantity', 'Amount'],
          'body' => [],
          'footer' => ['Total', (string)$count_totals['1'], currency_format($price_totals['1'])['display']],
          'order' => 2
        ]
      );
    }

    if ($price_totals['3'] > 0) {
      $result->push(
        [
          'label' => 'Refund Tickets Total : ',
          'header' => ['Ticket', 'Quantity', 'Amount'],
          'body' => [],
          'footer' => ['Total', (string)$count_totals['3'], currency_format($price_totals['3'])['display']],
          'order' => 4
        ]
      );
    }

    if ($price_totals['5'] > 0) {
      $result->push(
        [
          'label' => 'Concession Total : ',
          'header' => ['Ticket', 'Quantity', 'Amount'],
          'body' => [],
          'footer' => ['Total', (string)$count_totals['5'], currency_format($price_totals['5'])['display']],
          'order' => 6
        ]
      );
    }

    if ($price_totals['7'] > 0) {


      $result->push(
        [
          'label' => 'Topups Total : ',
          'header' => ['Ticket', 'Quantity', 'Amount'],
          'body' => [],
          'footer' => ['Total', (string)$count_totals['7'], currency_format($price_totals['7'])['display']],
          'order' => 8
        ]
      );
    }

    // if($price_totals['9'] > 0) {
    //     $result->push(
    //         [
    //             'label' => 'Add Funds Total : ',
    //             'header' => ['Ticket', 'Quantity', 'Amount'],
    //             'body' => [],
    //             'footer' => ['Total', (string)$count_totals['9'], currency_format($price_totals['9'])],
    //             'order' => 10
    //         ]
    //     );
    // }

    // if($price_totals['7'] > 0 || $price_totals['9'] > 0) {
    //     $result->push(
    //         [
    //             'label' => 'Topups / Add Funds Total : ',
    //             'header' => ['Ticket', 'Quantity', 'Amount'],
    //             'body' => [],
    //             'footer' => ['Total', (string)($count_totals['7'] + $count_totals['9']), currency_format($price_totals['7'] + $price_totals['9'])],
    //             'order' => 11
    //         ]
    //     );
    // }



    if ($total_discounts > 0) {
      $result->push(
        [
          'label' => 'CASH Coupon Discounts : (-)',
          'header' => ['Total', 'Amount'],
          'body' => [],
          'footer' => ['Total', currency_format($total_discounts)['display']],
          'order' => 12
        ]
      );
    }




    $result = collect($result)
      ->sortBy('order')->values()->toArray();

    // return $result;

    $htmlTables = "";

    foreach ($result as $resultItem) {



      $htmlTable = "<br><h3>" . $resultItem["label"] . "</h3>";
      $htmlTable .= "<table>";

      if (count($resultItem["body"]) > 0) {
        $htmlTable .= "<thead><tr>";

        foreach ($resultItem["header"] as $header) {
          $htmlTable .= "<th>" . $header . "</th>";
        }
        $htmlTable .= "</tr></thead>";
      }

      $htmlTable .= "<tbody>";

      foreach ($resultItem["body"] as $body) {
        $htmlTable .= "<tr>";
        foreach ($body as $bodyItem) {
          $htmlTable .= "<td>" . $bodyItem . "</td>";
        }
        $htmlTable .= "</tr>";
      }

      if ($resultItem["footer"] ?? null) {

        $htmlTable .= "<tr>";

        foreach ($resultItem["footer"] as $footer) {
          $htmlTable .= "<th>" . $footer . "</th>";
        }
        $htmlTable .= "</tr>";
      }

      $htmlTable .= "</tbody>";

      $htmlTable .= "</table><br>";


      $htmlTables .= $htmlTable;
    }

    // echo $htmlTables;
    // return;

    $cashier_shift = $this->getShift($user->id, $date);


    // dd($cashier_shift);

    return [
      'cashier' => [
        'name' => $user->name,
        'date' => $cashier_shift['date'],
        'time' => $cashier_shift['time']
      ],
      'tables' => $result,
      'tablesHtml' => $htmlTables,
      'total' => currency_format($total - $total_discounts)['display'],
      'printed_at' => (string) Carbon::now()
    ];
  }


  public function getShift($user_id, $date)
  {


    $in = UserSession::whereNull('deleted_at')
      ->where('pos_user_id', $user_id)
      ->where('type', 'LOGIN')
      ->whereDate('created_at', now())
      ->orderBy('id', 'desc')
      ->first();

    return [
      'date' => Carbon::parse($date)->format('Y-m-d'),
      'time' => $in ?  Carbon::parse($in->created_at) . ' - ' . Carbon::now()->format('H:i:s') : ""
    ];
  }
}
