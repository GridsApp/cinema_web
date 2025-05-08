<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title ?? ""}}</title>


</head>
<body>





@section ('content')


    <h3 style="text-align: center">Distributor Film Hire</h3>


    <table class="info-table">
        <tr>
            <td> Distributor: {{$distributor}}</td>
            <td> Branch: {{$branch}}</td>
   <td> From:   {{ $start_date ?? '-' }} </td>
            <td> Until:  {{ $end_date  ?? '-' }} </td> 
        </tr>
    </table>

    <div style="margin-top: 40px; margin-bottom: 100px; width: 100%">

        @if($result)

            <table class="last-bg" style="border: 1px solid #000">
                        <thead>
                        <tr>
                            <th>Film Title </th>
                            <th>Admits</th>
                            <th>Gross Box Office</th>
                            <th>TAX </th>
                            <th>Net Box Office </th>
                            <th>Contract Week</th>
                            <th>Percentage </th>
                            <th> Payable Film Hire </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result as $row)

                            <tr>
                                <td> {{$row["movie"]}} </td>
                                <td> {{$row["admits"]}} </td>
                                <td> {{$row["gross_box_office"]}} </td>
                                <td> {{$row["tax"]}} </td>
                                <td> {{$row["net_box_office"]}} </td>
                                <td> {{$row["week"]}} </td>
                                <td> {{$row["percentage"]}} </td>
                                <td> {{$row["payable_film"]}} </td>
                            </tr>

                        @endforeach



                        </tbody>
                    </table>

        @endif
    </div>







    <style>

        table{
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .last td, .last th{
            font-weight: bold;
            color: red;
            background-color: #eeeeee;
        }

        td{
            padding: 5px 10px;
        }
        th{
            padding: 0px 10px;
        }

        th{
            text-align: left !important;
            background-color: #eeeeee;
            font-weight: bold;
        }

        .last-bg tr:last-child td{
            background: #eeeeee;
            font-weight: bold;
        }
    </style>


</body>
</html>


