@extends('layout.backEnd')
@section('container')
<div class="container content mt-5">
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h2>Data Roles Management</h2>
      </div>
      <div class="card-body">
      <a href="#" data-action="/home"><< Back</a> || <a href="#" data-action="create">Add</a> || <a href="#" data-action="/roles/trash">Trashed</a>
        <div class="table-responsive">
          <table style="width: 100%;" id="tabroles" data-action="/roles/table" class="table table-md table-hover table-striped table-bordered">
            <thead><tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr></thead>
            <tbody>
            @php
            $i=1;
            @endphp
            @if (count($roles) > 0 )
            @foreach ($roles as $key => $role)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $role->name }}</td>
              <td>
                <a href="#" data-type="editCustomer" data-action="edit" data-id="{{ $role->id }}">Edit</a> ||
                <a href="#" data-type="deleteCustomer" data-action="delete" data-id="{{ $role->id }}">Delete</a>
              </td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="3" align="center">Data Tidak Ditemukan</td></tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection