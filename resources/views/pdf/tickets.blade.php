<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - #123</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
            font-family: DejaVu Sans;
        }


        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .invoice table {
            margin: 15px;
        }

        .invoice h3 {
            margin-left: 15px;
        }

        .information {
            background-color: #29bae4;
            color: #FFF;
            width: 100%;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }

        .invoice {
        }

        .invoice table {
            margin: 0 auto;
            font-size: 1.2em;
            margin-bottom: 15px;
        }

        .invoice table thead {
            cursor: pointer;
            background: #c9dff0;
        }

        .invoice table thead tr th {
            font-weight: bold;
            padding: 12px 30px;
            padding-left: 42px;
        }

        .invoice table thead tr th span {
            padding-right: 20px;
            background-repeat: no-repeat;
            background-position: 100% 100%;
        }

        .invoice table tbody tr {
            color: #555;
        }

        .invoice table tbody tr td {
            text-align: center;
            padding: 15px 10px;
        }

        .invoice table tbody tr td.lalign {
            text-align: left;
        }

        .padding-15 {
            padding: 15px;

        }

        .padding-15 h3 {
            padding: 0px;
            margin: 0px;
        }

        .partner-btn {
            text-align: center;
            width: 100px;
            display: block;
            padding: 10px 5px;
            border-radius: 10px;
            background-color: #29bae4;
            color: #fff;
            margin: 20px 0px;
        }


    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
                <h3>{{isset($user->name)?$user->name:''}}</h3>
                Тел: {{isset($user->phone)?"+".$user->phone:''}}<br>
                Почта: {{isset($user->email)?$user->email:''}}
            </td>
            <td align="center">
                <img src="http://ione.lc/img/logo-quadrat.jpg" alt="Logo" width="64" class="logo"/>
            </td>
            <td align="right" style="width: 40%;">

                <h3>{{isset($partner->name)?$partner->name:''}}</h3>
                <a target="_blank"
                   href="{{isset($partner->link)?$partner->link:''}}">{{isset($partner->link)?$partner->link:''}}</a><br>
                Адрес: {{isset($partner->address)?$partner->address:''}},<br>
                Тел: {{isset($partner->phone)?"+".$partner->phone:''}}<br>
                Почта: {{isset($partner->email)?$partner->email:''}}<br>
            </td>
        </tr>

    </table>
</div>


<br/>
<div class="invoice">
    <div>
        <div class="padding-15">
            <h3>{{isset($user->name)?$user->name:''}}</h3>
            <p>
                Вы только что приобрили билеты, от нашего партнера
                <b>{{isset($partner->name)?$partner->name:''}}</b>.<br>
                Дата тура: <b>{{$tour_ticket->tour_date}}</b><br>
                Название тура: <b>{{$tour->name}}</b><br>
                <a href="https://ione.kz/partners/{{isset($partner->id)?$partner->id:''}}"
                   class="partner-btn">Партнер</a>
            </p>
        </div>


        <br>
        <table width="100%">
            <thead>
            <tr>
                <th>Название</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>QR</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sum =0;
            ?>
            @foreach($order_tickets as $ticket)
                <tr>
                    <td>{{$ticket->ticket->name}}</td>
                    <td>{{$ticket->quantity}}</td>
                    <td align="left">{{$ticket->ticket->price}}</td>
                    <td align="left"><img
                            src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('https://ione.kz/'.$ticket->uuid)) !!} ">
                    </td>
                </tr>
                @php
                    $sum = $sum+ $ticket->ticket->price;
                    @endphp
            @endforeach

            <tr>
                <td></td>
                <td align="left">Сумма</td>
                <td align="left" class="gray">{{$sum}} ₸</td>
                <td align="left" class="gray"></td>
            </tr>
        </table>
    </div>
</div>

<div class="information" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} {{ config('app.url') }} - Все права защищены.
            </td>
            <td align="right" style="width: 50%;">
                <a href="{{ config('app.url') }}">IONE.KZ</a> - Айуан турлар бар
            </td>
        </tr>

    </table>
</div>
</body>
</html>

<html>
