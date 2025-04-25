<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>{{$title ?? ""}}</title> --}}
</head>

<body>





    @section('content')


        <h3 style="text-align: center">Box Office Report</h3>

        <table class="info-table">
            <tr>
                <td> Branch:
                    {{ $branchLabel }}
                </td>
                <td> From:
                    {{ $startDate ?? '-' }}
                </td>
                <td> Until:
                    {{ $endDate ?? '-' }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 40px; margin-bottom: 100px; width: 100%">

            {{-- @if ($result) --}}

                <table class="last-bg" style="border: 1px solid #000">
                    <thead>
                        <tr>
                            <th colspan="6" style="text-align: center !important;">Total Box Office</th>
                        </tr>
                        <tr>
                            <th style="border-bottom: 0 !important;">Movie </th>
                            <th style="border-bottom: 0 !important;">Sessions</th>
                            <th style="border-bottom: 0 !important;">Admits</th>
                            <th style="border-bottom: 0 !important;">Gross </th>
                            <th style="border-bottom: 0 !important;">TAX </th>
                            <th style="border-bottom: 0 !important;"> Net </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mainResult as $movie)
                            <tr>
                                <td>{{ $movie['movie_name'] }}</td>
                                <td>{{ $movie['sessions'] }}</td>
                                <td>{{ $movie['admits'] }} </td>
                                <td>{{ $movie['gross'] }} IQD</td>
                                <td>{{ $movie['tax'] }} IQD</td>
                                <td>{{ $movie['net'] }} IQD</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                            
                            <td>{{ number_format($totals['sessions']) }}</td>
                            <td>{{ number_format($totals['admits']) }}  </td>
                            <td>{{ number_format($totals['gross']) }} IQD</td>
                            <td>{{ number_format($totals['tax']) }} IQD</td>
                            <td>{{ number_format($totals['net']) }} IQD</td>
                        </tr>
                    </tfoot>
                </table>


                <br> <br>

                @foreach ($detailedResult as $movie)
                <table class="last-bg" style="border: 1px solid #000">
                    <thead>
                        <tr>
                            <th colspan="9">Distributor: {{ $movie['dist'] }} Movie: {{ $movie['movie'] }} No. of Shows: {{ $movie['nb_shows'] }}</th>
                        </tr>
                        <tr>
                            <th>Show Date</th>
                            <th>Screen</th>
                            <th>Show Time</th>
                            <th>Admits</th>
                            <th>Class</th>
                            <th>Price/Tkt</th>
                            <th>Gross Amt</th>
                            <th>Tax</th>
                            <th>Net</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movie['shows'] as $row)
                        {{-- @dd($row); --}}
                        <tr>
                            <td>{{ $row['show_date'] }}</td>
                            <td>{{ $row['screen'] }}</td>
                            <td>{{ $row['show_time'] }}</td>
                            <td>{{ $row['admits'] }}</td>
                            <td>{{ $row['ticket'] }} </td>
                            <td>{{ $row['unit_price'] }}</td>
                            <td>{{ $row['gross'] }} </td>
                            <td>{{ $row['tax'] }}</td>
                            <td>{{ $row['net'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                          
                            {{-- @dd(number_format($movie['movie_totals']['gross'])); --}}
                            <td colspan="3">Total</td>
                            <td>{{ number_format($movie['movie_totals']['admits']) }}</td>
                            <td>-</td>
                            <td>{{ number_format($movie['movie_totals']['unit_price']) }}</td>
                            <td>{{ number_format($movie['movie_totals']['gross']) }} IQD</td>
                            <td>{{ number_format($movie['movie_totals']['tax']) }} IQD</td>
                            <td>{{ number_format($movie['movie_totals']['net']) }} IQD</td>
                            
                        </tr>
                    </tfoot>
                </table>
                <br><br>
            @endforeach
            



            {{-- @endif --}}

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

            /* .last-bg tr:last-child td {
                background: #eeeeee;
                font-weight: bold;
            } */

            tfoot td{
                background: #eeeeee;
                font-weight: bold;
            }
        </style>


    </body>

    </html>
