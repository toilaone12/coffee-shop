@extends('dashboard')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Số người online</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($isOnline)}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-globe fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Doanh thu hôm nay</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$statistic ? number_format($statistic->price_statistic,0,',','.') : 0}} đ</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Doanh thu tháng này
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{number_format($allTotal,0,',','.')}} đ</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-6">
            <form class="search-date-product">
                <div class="d-flex align-items-center">
                    <div class="form-group mr-3">
                        <label for="">Từ ngày</label>
                        <input type="date" name="date-from" class="form-control" max="<?= date('Y-m-d') ?>" id="date-from">
                    </div>
                    <div class="form-group mr-3">
                        <label for="">Đến ngày</label>
                        <input type="date" name="date-to" class="form-control" max="<?= date('Y-m-d') ?>" id="date-to">
                    </div>
                    <button type="submit" class="btn btn-primary rounded fs-15 mt-3">Tìm kiếm</button>
                </div>
            </form>
            <select class="form-control w-75 filter-quantity-sold" aria-label="Default select example">
                <option value="">Lọc thống kê trong vòng</option>
                @foreach($arrFilter as $key => $filter)
                <option value="{{$key}}">{{$filter}}</option>
                @endforeach
            </select>
        </div>

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12 mt-3">
            <div class="text-center fs-18 text-quantity-chart">Biểu đồ số lượng sản phẩm đã bán hôm nay (@php echo date('d/m/Y') @endphp)</div>
            <div class="order-chart">
                <canvas id="myAreaChart" height="200"></canvas>
            </div>
        </div>


    </div>

</div>
@endsection