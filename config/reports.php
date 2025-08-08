<?php

return [

    'directories' => [
        'app/Reports'
    ],
    'mappings' => [
        "concession-sales-report" => App\Reports\ConcessionSalesReport::class,
        "coupon-discounts-report" => App\Reports\CouponDiscountsReport::class,
        "daily-admits-by-item-report" => App\Reports\DailyAdmitsByItemReport::class,
        "daily-admits-by-type-report" => App\Reports\DailyAdmitsByTypeReport::class,
        "daily-admits-report" => App\Reports\DailyAdmitsReport::class,
        "daily-admits-report-by-distributor" => App\Reports\DailyAdmitsReportByDistributor::class,
        "deferred-income-report" => App\Reports\DeferredIncomeReport::class,
        "erp-cafeteria-report" => App\Reports\ErpCafeteriaReport::class,
        "erp-integration-report" => App\Reports\ErpIntegrationReport::class,
        "imtiyaz-report" => App\Reports\ImtiyazReport::class,
        "loyalty-transactions-report" => App\Reports\LoyaltyTransactionsReport::class,
        "order-cafeteria-report" => App\Reports\OrderCafeteriaReport::class,
        "order-glasses-report" => App\Reports\OrderGlassesReport::class,
        "order-tickets-report" => App\Reports\OrderTicketsReport::class,
        "order-topups-report" => App\Reports\OrderTopupsReport::class,
        "price-card-summary-report" => App\Reports\PriceCardSummaryReport::class,
        "soa-report" => App\Reports\SoaReport::class,
        "tickets-report" => App\Reports\TicketsReport::class,
        "wallet-cards-report" => App\Reports\WalletCardsReport::class,
        "wallet-topups-report" => App\Reports\WalletTopupsReport::class,
        "wallet-transactions-report" => App\Reports\WalletTransactionsReport::class,
        "daily-admits-compact" => App\Reports\DailyAdmitsCompactReport::class,
        "survey-ratings-report" => App\Reports\SurveyRatingsReport::class,
        "user-survey-ratings-report" => App\Reports\UserSurveyRatingsReport::class,
        

    ]

];
