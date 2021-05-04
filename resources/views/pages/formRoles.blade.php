@extends('layout.backEnd')
@section('container')
@php
if (Route::current()->getName() == 'roles.edit') {
  $valname = $role['name'];
} else {
  $valname = '';
}
@endphp
<div class="container content mt-5">
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h2>Form Roles Management</h2>
      </div>
      <div class="card-body">
        <div class="alert alert-dismissible fade show" role="alert"></div>
        <form id="fromRoles" action="/roles" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                  <label for="inputName">Name Roles</label>
                  <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Name" value="{{$valname}}" required>
                  <div class="invalid-feedback">Masukan Name Roles.</div>
                </div>
            </div><hr>
            <div class="d-flex justify-content-between">
                <h4>Permission Roles</h4>
                <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary btn-add ms-auto">Add Pages</button>
            </div>
            <div class="table-responsive">
            <table style="width: 100%;" id="tabFormRoles" data-action="/roles/table" class="mt-2 table table-md table-hover table-striped table-bordered">
                <thead><tr>
                    <th scope="col">Page Name</th>
                    <th scope="col">All Roles</th>
                    <th scope="col">Create</th>
                    <th scope="col">Read</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </tr></thead>
                <tbody>
                @if (count($data) > 0 )
                @foreach ($data as $key => $pageRoles)
                @php 
                if (Route::current()->getName() == 'roles.edit') {
                  foreach ($permission as $value) {
                    $explode  = explode("-",$value->name);
                    $pages    = $explode[0];
                    $roles    = $explode[1];
                    if ($pageRoles->name==$pages) {
                      if ($roles=='create') {
                        $roleCreate   = $value->id;
                        $checkCreate  = in_array($roleCreate, $rolePermissions) ? 'checked' : false;
                      }
                      if ($roles=='read') {
                        $roleRead   = $value->id;
                        $checkRead  = in_array($roleRead, $rolePermissions) ? 'checked' : false;
                      }
                      if ($roles=='update') {
                        $roleUpdate   = $value->id;
                        $checkUpdate  = in_array($roleUpdate, $rolePermissions) ? 'checked' : false;
                      }
                      if ($roles=='delete') {
                        $roleDelete   = $value->id;
                        $checkDelete  = in_array($roleDelete, $rolePermissions) ? 'checked' : false;
                      }
                    }
                  }
                } else {
                  $roleCreate = $pageRoles->name.'-create';
                  $roleRead   = $pageRoles->name.'-read';
                  $roleUpdate = $pageRoles->name.'-update';
                  $roleDelete = $pageRoles->name.'-delete';
                  $checkCreate = ''; $checkRead = ''; $checkUpdate = ''; $checkDelete = '';
                }
                @endphp
                <tr>
                <td>{{ $pageRoles->name }}</td>
                <td><input type="checkbox" class="checkall" name="{{ $pageRoles->name }}-role-all" id="{{ $pageRoles->name }}-role-all" value="{{ $pageRoles->name }}-all"></td>
                <td><input type="checkbox" name="permission[]" id="permission[]" value="{{ $roleCreate }}" {{$checkCreate}}></td>
                <td><input type="checkbox" name="permission[]" id="permission[]" value="{{ $roleRead }}" {{$checkRead}}></td>
                <td><input type="checkbox" name="permission[]" id="permission[]" value="{{ $roleUpdate }}" {{$checkUpdate}}></td>
                <td><input type="checkbox" name="permission[]" id="permission[]" value="{{ $roleDelete }}" {{$checkDelete}}></td>
                </tr>
                
                @endforeach
                @else
                <tr><td colspan="6" align="center">Data Tidak Ditemukan</td></tr>
                @endif
                </tbody>
            </table>
            </div><hr>
            <div class="row">
                <div class="col-md-12">
                    <a href="#" data-action="/roles/index" class="btn btn-primary btn-back">Back</a>
                    <button type="button" class="btn btn-primary btn-save">Save</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Form Pages</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="fromPages" action="/roles/pages" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <label for="inputNamePages">Name Pages</label>
                    <input type="text" class="form-control" id="inputNamePages" name="inputNamePages" placeholder="Pages" required>
                    <div class="invalid-feedback">Masukan Name Pages.</div>
                </div>
                <div class="col-md-12">
                    <label for="inputUrlPages">Url Pages</label>
                    <input type="text" class="form-control" id="inputUrlPages" name="inputUrlPages" placeholder="/Pages/" required>
                    <div class="invalid-feedback">Masukan Url Pages.</div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-spages">Save</button>
      </div>
    </div>
  </div>
</div>