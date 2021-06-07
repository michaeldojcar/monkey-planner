<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">
    <title>Tisk - místo {{$item_place->name}}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
          crossorigin="anonymous">

    <style>
        @page {
            size: A4;
        }


        @media print {
            @page {
                size: landscape;
            }
        }


        html, body {
            height:     200mm;
            width:      297mm;
            background: white;

            font-size:  13px;

            /*margin: 25mm;*/
        }


        h1 {
            margin-bottom: 0;
        }


        .table td, .table th {
            padding: 0.05rem 0.45rem;
        }


        .col-three {
            -moz-column-count:    3;
            -webkit-column-count: 3;
            column-count:         3;
            height:               200mm;
            column-fill:          auto;
        }


        /* ... the rest of the rules ... */

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-three">

                <table class="table table-bordered table-primary">
                    @if($item_place->parent_item_place)
                        <tr>
                            <td style="font-size: 14px;">Umístění</td>
                            <td class="text-end">
                                <span style="font-size: 19px;">{{$item_place->parent_item_place->name}}</span>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="2"
                            class="text-center">
                            <span style="font-size: 15px">Skladové místo</span> <span class="small">(ID {{$item_place->id}})</span>
                            <h1 style="font-size: 50px">{{$item_place->name}}</h1>
                        </td>
                    </tr>
                </table>


                <table class="table table-bordered"
                       style="font-size: 13px">
                    <th>Položka</th>
                    <th>Počet</th>
                    @foreach($item_place->item_states as $state)
                        <tr>
                            <td>{{$state->item->name}}</td>
                            <td>{{$state->count}} {{$state->item->count_unit}}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td><i>Celkem položek</i></td>
                        <td>{{$item_place->item_states->count()}}</td>
                    </tr>
                </table>
                Datum tisku: {{\Carbon\Carbon::now()->format('d. m. Y H:i')}}
            </div>

        </div>
    </div>
</body>
</html>
