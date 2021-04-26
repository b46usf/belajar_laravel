@extends('layout.backEnd')
@section('container')
<div class="container mt-5">
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h2>Data Users Management</h2>
      </div>
      <div class="card-body">
      <a href="#" data-action="/home"><< Back</a> <!--|| <a href="#" data-action="create">Add</a>--> || <a href="#" data-action="/user/trash">Trashed</a>
        <div class="table-responsive">
          <table style="width: 100%;" id="tabuser" data-action="/user/table" class="table table-md table-hover table-striped table-bordered">
            <thead><tr>
                <th scope="col">No</th>
                <th scope="col">Email</th>
                <th scope="col">Name</th>
                <th scope="col">Hak Akses</th>
                <th scope="col">Status User</th>
                <th scope="col">Action</th>
            </tr></thead>
            <tbody>
            @php
            $i=1;
            @endphp
            @if (count($data) > 0 )
            @foreach($data as $key => $usr)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $usr->email }}</td>
              <td>{{ $usr->name }}</td>
              <td>
                @if(!empty($usr->getRoleNames()))
                    @foreach($usr->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                @endif              
              </td>
              <td>{{ ($usr->device_token=='') ? 'Belum Aktif':'Sudah Aktif' }}</td>
              <td>
                <a href="#" data-type="editCustomer" data-action="edit" data-id="{{ $usr->uniqID_user }}">Edit</a> ||
                <a href="#" data-type="deleteCustomer" data-action="delete" data-id="{{ $usr->uniqID_user }}">Delete</a>
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