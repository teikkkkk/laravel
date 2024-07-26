@extends('app')

@section('content')
    <style>
        .table-responsive {
            width: 1200px;
            max-height: 500px; 
            overflow-y: auto;  
        }
        thead th {
            position: sticky;
            top: 0; 
            background-color: #fff;
            z-index: 10; 
        }
        table {
            width: 100%; 
        }
        th, td {
            text-align: center; 
            padding: 10px;
        }
    </style>

    <div class="container">
        <h1>Thống kê sản phẩm đã bán</h1>

        <form action="{{ route('products.filterStatistics') }}" method="POST" id="filter-form">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="start_date">Từ:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', request('start_date')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="end_date">Đến:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', request('end_date')) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="category_id">Loại sản phẩm:</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Tất cả</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', request('category_id')) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="product_name">Tên sản phẩm:</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" value="{{ old('product_name', request('product_name')) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sales_filter">Số lượng bán ra:</label>
                        <select name="sales_filter" id="sales_filter" class="form-control">
                            <option value="">Tất cả</option>
                            <option value="most_sold" {{ old('sales_filter', request('sales_filter')) == 'most_sold' ? 'selected' : '' }}>Nhiều nhất</option>
                            <option value="least_sold" {{ old('sales_filter', request('sales_filter')) == 'least_sold' ? 'selected' : '' }}>Ít nhất</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sort">Doanh thu:</label>
                        <select name="sort" id="sort" class="form-control">
                            <option value="">Không sắp xếp</option>
                            <option value="desc" {{ old('sort', request('sort')) == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                            <option value="asc" {{ old('sort', request('sort')) == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">Lọc</button>
                    <button type="button" class="btn btn-secondary" id="reset-button">Reset</button>
                </div>
            </div>
        </form>

      

        @if($orderItems->isEmpty())
        <br>
           <h5>Không có sản phẩm nào phù hợp !</h5>
        @else
        <h2 class="mt-4">Tổng số sản phẩm đã bán: {{ $totalSold }}</h2>
            <div class="table-responsive">
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng đã bán</th>
                            <th>Doanh thu</th>
                            <th>Ngày bán gần nhất</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->total_quantity }}</td>
                                <td>{{ number_format($item->total_price, 0, ',', '.') }} VNĐ</td>
                                <td>{{ \Carbon\Carbon::parse($item->latest_date)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <script>
        document.getElementById('reset-button').addEventListener('click', function() {
            document.getElementById('filter-form').reset();
            $('#category_id').val('').trigger('change');
            $('#sales_filter').val('').trigger('change');
            $('#sort').val('').trigger('change');
            $('#product_name').val('').trigger('change');
            $('#start_date').val('').trigger('change');
            $('#end_date').val('').trigger('change');
        });
    </script>
@endsection
