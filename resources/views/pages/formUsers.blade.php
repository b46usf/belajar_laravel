@extends('layout.backEnd')
@section('container')
<div class="container content mt-5">
<!--Tanpa Jquery-->
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Form User Management</h3>
      </div>
      <div class="card-body">
      <div class="alert alert-dismissible fade show" role="alert"></div>
        <form id="fromUser" action="/user" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6 mt-2">
                        <select class="form-select" name="inputroles" id="inputroles">
                        <option value="">Pilih Roles</option>
                        @foreach($roles as $v)
                            <option value="{{$v}}">{{$v}}</option>
                        @endforeach
                        </select>
                    <div class="invalid-feedback">Masukan Pilihan Roles.</div>
                </div>
                <div class="col-md-6 mt-2">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="inputactivated" id="btnradio1" value="active" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio1">Activated</label>
                        <input type="radio" class="btn-check" name="inputactivated" id="btnradio2" value="deactive" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">DeAftivated</label>
                        </div>
                    <div class="invalid-feedback">Masukan Pilihan Activated.</div>
                </div>
                <div class="col-md-12 mt-2">
                  <a href="#" data-action="/user/index" class="btn btn-primary btn-back">Back</a>
                  <button type="button" class="btn btn-primary btn-save">Save</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection