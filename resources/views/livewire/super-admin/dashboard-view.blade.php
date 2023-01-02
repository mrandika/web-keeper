@section('page')
    Beranda
@endsection

@extends('layouts.sidebar.admin-nav')

@section('dashboard-active')
    active
@endsection

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Statistik Transaksi - {{ date('M') }} {{ date('Y') }}</div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{ $transactions->where('transaction_type_id', 2)->count() }}</div>
                                <div class="card-stats-item-label">Penjualan</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{ $transactions->where('transaction_type_id', 1)->count() }}</div>
                                <div class="card-stats-item-label">Pembelian</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Transaksi</h4>
                        </div>
                        <div class="card-body">
                            {{ $transactions->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Warehouse</h4>
                        </div>
                        <div class="card-body">
                            {{ $warehouses->count() }}
                        </div>
                    </div>
                </div>

                <div class="card card-statistic-2">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Aset</h4>
                        </div>
                        <div class="card-body">
                            @currency($total_asset)
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Kredit - {{ date('M') }} {{ date('Y') }}</h4>
                        </div>
                        <div class="card-body">
                            @currency($transactions->where('transaction_type_id', 2)->pluck('total')->sum())
                        </div>
                    </div>
                </div>
                <div class="card card-statistic-2">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Debit - {{ date('M') }} {{ date('Y') }}</h4>
                        </div>
                        <div class="card-body">
                            @currency($transactions->where('transaction_type_id', 1)->pluck('total')->sum())
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Transaksi Pembelian dan Penjualan</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="200"></canvas>
                        <div class="card card-statistic-2">
                            <div class="card-icon shadow-primary bg-primary">
                                <i class="fas fa-money-bill"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4 class="@if ($transactions->pluck('total')->sum() != 0) beep @endif">Neraca Saldo - {{ date('M') }} {{ date('Y') }}</h4>
                                </div>
                                <div class="card-body">
                                    @if ($transactions->pluck('total')->sum() == 0)
                                        Seimbang
                                    @else
                                        @currency($transactions->pluck('total')->sum())
                                    @endif
                                </div>

                                @if ($transactions->pluck('total')->sum() != 0)
                                    <div class="card-footer text-right">
                                        <div class="badge badge-danger"><i class="fa fa-exclamation mr-2"></i> Transaksi tidak seimbang</div>
                                        <br>
                                        <small>
                                            @if ($transactions->pluck('total')->sum() < 0)
                                                Debit lebih besar daripada kredit.
                                            @else
                                                Kredit lebih besar daripada debit.
                                            @endif
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Penjualan Terbanyak</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach ($top_items as $item)
                                @php
                                    $sold = $item->total_sold;
                                    $item = \App\Models\Item::find($item->item_id);
                                @endphp

                                <li class="media">
                                    <img class="mr-3 rounded" width="55" src="{{ asset('image/package.png') }}" alt="{{ $item->name }}">
                                    <div class="media-body">
                                        <div class="float-right"><div class="font-weight-600 text-muted text-small">{{ $sold }} Penjualan</div></div>
                                        <div class="media-title">{{ $item->name }}</div>
                                        <div class="mt-1">
                                            @currency($item->price)
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('js')
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script>
        $(document).on('turbolinks:load', function () {
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Penjualan',
                        data: @json($credit_data),
                        borderWidth: 2,
                        backgroundColor: 'rgba(63,82,227,.8)',
                        borderWidth: 0,
                        borderColor: 'transparent',
                        pointBorderWidth: 0,
                        pointRadius: 3.5,
                        pointBackgroundColor: 'transparent',
                        pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                    },
                        {
                            label: 'Pembelian',
                            data: @json($debit_data),
                            borderWidth: 2,
                            backgroundColor: 'rgba(254,86,83,.7)',
                            borderWidth: 0,
                            borderColor: 'transparent',
                            pointBorderWidth: 0 ,
                            pointRadius: 3.5,
                            pointBackgroundColor: 'transparent',
                            pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
                        }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                // display: false,
                                drawBorder: false,
                                color: '#f2f2f2',
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    return 'Rp. ' + value;
                                }
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false,
                                tickMarkLength: 15,
                            }
                        }]
                    },
                }
            });
        });
    </script>
@endsection
