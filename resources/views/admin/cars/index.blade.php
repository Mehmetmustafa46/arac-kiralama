@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Araçlar</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Marka</th>
                                    <th>Model</th>
                                    <th>Yıl</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cars as $car)
                                <tr>
                                    <td>{{ $car->id }}</td>
                                    <td>{{ $car->brand }}</td>
                                    <td>{{ $car->model }}</td>
                                    <td>{{ $car->year }}</td>
                                    <td>
                                        <span class="badge bg-{{ $car->status === 'available' ? 'success' : 'warning' }}">
                                            {{ $car->status === 'available' ? 'Müsait' : 'Bakımda' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.cars.update-status', $car) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $car->status === 'available' ? 'maintenance' : 'available' }}">
                                            <button type="submit" class="btn btn-sm {{ $car->status === 'available' ? 'btn-warning' : 'btn-success' }}">
                                                {{ $car->status === 'available' ? 'Bakıma Al' : 'Müsait Yap' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 