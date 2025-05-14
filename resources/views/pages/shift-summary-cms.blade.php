<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shift Summary</title>

    <style>
        .info-table,
        .info-table td
        {
            border-right: none !important;
            border-left: none !important;
            border-top: 1px solid #000 !important;
            border-bottom:1px solid #000 !important;
        }
    </style>
</head>
<body>



@section ('content')
    <h3 style="text-align: center">Shift Summary</h3>

    <table class="info-table">
        <tr>
            <td> Cashier: {{$result["cashier"]["name"]}} </td>
        </tr>
        <tr>
            <td> From: {{$result["cashier"]["date"]}} </td>
        </tr>
{{--        <tr>--}}
{{--            <td> To: {{$result["cashier"]["time"]}} </td>--}}
{{--        </tr>--}}
    </table>

    <div style="margin-top: 20px; margin-bottom: 100px; width: 100%">


        @foreach($result["tables"] as $table)
            <br>
            <h3> {{$table['label']}}</h3>

            <table>
                <thead>
                <tr>
                    @foreach($table['header'] as $header)
                        <th> {{$header}}</th>
                    @endforeach
                </tr>
                </thead>

                <tbody>
                @foreach($table['body'] as $header)
                    <tr>
                        @foreach($header as $head)
                            <td> {{$head}}</td>
                        @endforeach
                    </tr>
                @endforeach


                <tr>
                    @foreach($table['footer'] as $footer)
                        <th style="background-color: #f1ecec"> {{$footer}}</th>
                    @endforeach
                </tr>

                </tbody>
            </table>
            <br>

        @endforeach

        <br> <br>

        <h3>Total: {{$result["total"]}}</h3>

        {{--        {!! $result["tablesHtml"] !!}--}}
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
    </style>


</body>
</html>


