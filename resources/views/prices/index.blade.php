@extends('layouts.app')

@section('content')
    {{-- make datatable --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Daftar Harga') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Service Name</th>
                                    <th>Price</th>
                                    <th>Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->service_name }}</td>
                                        <td>{{ rupiah($value->price) }}</td>
                                        <td>
                                            @if ($value->is_active == 1)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- add scripts for datatable --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table-1').DataTable();
        });
    </script>
@endpush
