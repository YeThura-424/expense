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
    <br><h2 style="text-align: center;">Borrow Detail</h5><br><br>
        <table style="width:100%;">
            <thead>
                <tr>
                    <td><b>No.</b></td>
                    <td><b>Date</b></td>
                    <td><b>Name</b></td>
                    <td><b>Amount</b></td>
                    <td><b>Status</b></td>
                    <td><b>Description</b></td>   
                    <td><b>Done Date</b></td>  
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($data as $row)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->amount }} MMK</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ $row->description }}</td>
                    <td>{{ $row->donedate }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
</body>
</html>