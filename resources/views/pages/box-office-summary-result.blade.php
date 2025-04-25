<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? '' }}</title>

    <style>
        .info-table,
        .info-table td {
            border-right: none !important;
            border-left: none !important;
            border-top: 1px solid #000 !important;
            border-bottom: 1px solid #000 !important;
        }
    </style>
</head>

<body>



    @section('content')
        <h3 style="text-align: center">Box Office Summary</h3>

        <table class="info-table">
            <tr>
                <td> From: {{ $start_date }} </td>
                <td> Until: {{ $end_date }} </td>


                <td> Branch: {{ $branch }} </td>

                <td></td>

            </tr>
        </table>



        <div style="margin-top: 50px; margin-bottom: 250px; width: 100%">

            @if ($results)


                @foreach ($results as $distibuter => $result)
                    <h3 style="text-align: left; margin-bottom: 10px">{{ $distibuter }}</h3>

                    <table style="border: 1px solid #000 ; margin-bottom: 50px">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width:250px"></th>
                                <th colspan="2">Paid (excl Comps) </th>
                                <th>Comps </th>
                                <th colspan="2">Paid (incl Comps) </th>
                                <th colspan="2">Box Office </th>
                            </tr>
                            <tr>
                                <th style="border-bottom: 0 !important;">Admits </th>
                                <th style="border-bottom: 0 !important;">Gross Box Office</th>
                                <th style="border-bottom: 0 !important;"></th>
                                <th style="border-bottom: 0 !important;">Admits</th>
                                <th style="min-width: 20px;border-bottom: 0 !important;">Gross Box Office</th>
                                <th style="border-bottom: 0 !important;">Tax </th>
                                <th style="border-bottom: 0 !important;">Net</th>

                            </tr>

                        </thead>
                        <tbody>

                            @foreach ($result[0] as $movie)
                                {{--                    @dd($movie) --}}
                                <tr>
                                    <td> {{ $movie['movie'] }} </td>
                                    <td> {{ $movie['admits_excluding_comps'] }} </td>
                                    <td> {{ $movie['gbo_excluding_comps'] }} </td>
                                    <td> {{ $movie['comps'] }} </td>
                                    <td> {{ $movie['admits_including_comps'] }} </td>
                                    <td> {{ $movie['gbo_including_comps'] }} </td>
                                    <td> {{ $movie['gbo_tax_amount'] }} </td>
                                    <td> {{ $movie['gbo_net_amount'] }} </td>
                                </tr>
                            @endforeach

                            <tr>

                                <th> {{ $result[1]['movie'] }} </th>
                                <th> {{ $result[1]['admits_excluding_comps'] }} </th>
                                <th> {{ $result[1]['gbo_excluding_comps'] }} </th>
                                <th> {{ $result[1]['comps'] }} </th>
                                <th> {{ $result[1]['admits_including_comps'] }} </th>
                                <th> {{ $result[1]['gbo_including_comps'] }} </th>
                                <th> {{ $result[1]['gbo_tax_amount'] }} </th>
                                <th> {{ $result[1]['gbo_net_amount'] }} </th>



                            </tr>


                        </tbody>
                    </table>
                @endforeach
            @endif

        </div>







        <style>
            table {
                width: 100%;
            }

            table,
            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
            }

            .last td,
            .last th {
                font-weight: bold;
                color: red;
                background-color: #eeeeee;
            }

            td {
                padding: 5px 10px;
            }

            th {
                padding: 0px 10px;
            }

            th {
                text-align: left !important;
                background-color: #eeeeee;
                font-weight: bold;
            }
        </style>


    </body>

    </html>
