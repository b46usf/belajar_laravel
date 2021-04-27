@extends('layout.backEnd')
@section('container')
<div class="container mt-5">
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h2>Form Roles Management</h2>
      </div>
      <div class="card-body">
      <a href="#" data-action="/roles/index"><< Back</a>
        <form id="fromRoles" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                  <label for="inputName">Name Roles</label>
                  <input type="hidden" class="form-control" id="inputIDroles" name="inputIDroles" required>
                  <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Name" required>
                  <div class="invalid-feedback">Masukan Name Roles.</div>
                </div>
            </div><hr>
            <h4>Permission Roles</h4>
            <div class="table-responsive">
            <table style="width: 100%;" id="tabFormRoles" data-action="/roles/table" class="table table-md table-hover table-striped table-bordered">
                <thead><tr>
                    <th scope="col">Page Name</th>
                    <th scope="col">Create</th>
                    <th scope="col">Read</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </tr></thead>
                <tbody>
                
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
                
                </tbody>
            </table>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection