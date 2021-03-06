@extends('layout.backEnd')
@section('container')
<div class="container content mt-5">
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Data Customer</h3>
      </div>
      <div class="card-body">
      <a href="#" data-action="/home"><< Back</a> @can('Customers-create') || <a href="#" data-action="create">Add</a> || <a href="#" data-action="/customer/trash">Trashed</a>@endcan
        <div class="table-responsive">
          <table style="width: 100%;" id="tabCustomer" data-action="/customer/table" class="table table-md table-hover table-striped table-bordered">
            <thead><tr>
                <th scope="col">No</th>
                <th scope="col">Email</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr></thead>
            <tbody>
            @php
            $i=1;
            @endphp
            @if (count($konsumen) > 0 )
            @foreach($konsumen as $k)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $k->email_customer }}</td>
              <td>{{ $k->nama_customer }}</td>
              <td>
              @can('Customers-update')
                <a href="#" data-type="editCustomer" data-action="edit" data-id="{{ $k->uniqID_Customer }}">Edit</a>
              @endcan
              @can('Customers-delete')
                <a href="#" data-type="deleteCustomer" data-action="delete" data-id="{{ $k->uniqID_Customer }}">Delete</a>
              @endcan
              </td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="7" align="center">Data Tidak Ditemukan</td></tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection