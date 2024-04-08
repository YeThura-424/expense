<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <br><h2 style="text-align: center;">My Uselist Detail</h5><br><br>
        <table style="width:100%;">
            <thead>
                <tr>
                    <td><b>No.</b></td>
                    <td><b>Date</b></td>
                    <td><b>Category</b></td>
                    <td><b>Amount</b></td>
                    <td><b>Description</b></td>     
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($data as $row)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->category }}</td>
                    <td>{{ $row->amount }} MMK</td>
                    <td>{{ $row->description }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: center;" colspan="3">Total</td>
                    <td style="text-align: center; color: red;" colspan="2">{{$data->sum('amount')}} MMK</td>
                </tr>
            </tfoot>
        </table>
</body>
</html>