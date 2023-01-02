<!DOCTYPE html>
<html>
    <head>
        <title>Print Transaksi &mdash; Keeper</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <style>
            table tr td,
            table tr th{
                font-size: 9pt;
            }
        </style>

        <div class="mb-4">
            <h4>Laporan Transaksi</h4>
                <h6>{{ $transactions->first()->created_at ?? '' }} - {{ $transactions->last()->created_at ?? '' }}</h6>
            </h5>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tipe</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Jam</th>
                <th scope="col">Admin</th>
                <th scope="col">Total Barang</th>
                <th scope="col">Total Harga</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total = 0;
            @endphp
            @forelse($transactions ?? [] as $transaction)
                @php
                    $total += $transaction->total;
                @endphp
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        @if($transaction->transaction_type_id == 1)
                            DB
                        @elseif($transaction->transaction_type_id == 2)
                            CR
                        @endif
                    </td>
                    <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                    <td>{{ $transaction->created_at->format('H:m:s') }}</td>
                    <td>{{ $transaction->employee->user->data->fullname() }}</td>
                    <td>{{ $transaction->details->count() }} barang</td>
                    <td>@currency($transaction->total) </td>
                </tr>
                <tr>
                    @foreach($transaction->details as $item)
                        <td></td>
                        <td colspan="5">{{ $item->location->item->name }}</td>
                        <td>@currency($item->price) x {{ $item->qty }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <th colspan="7">Tidak ada data</th>
                </tr>
            @endforelse

            @if ($transactions != null)
                <tr>
                    <td colspan="6"></td>
                    <th>@currency($total)</th>
                </tr>
            @endif
            </tbody>
        </table>

        <small>Dicetak oleh: {{ Auth::user()->email }} pada {{ date('d-m-Y H:m:s') }}</small>
    </body>
</html>
