@extends('layouts/dashboard')

@section('title', 'Profile')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card mb-6">
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
          <img src="{{ asset(Auth::user()->profile) }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="profile" />
          <div class="button-wrapper">
            <form action="" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                <span class="d-none d-sm-block">Upload new photo</span>
                <i class="bx bx-upload d-block d-sm-none"></i>
                <input type="file" id="upload" name="profile" class="account-file-input" hidden accept="image/png, image/jpeg" />
              </label>
              <button type="submit" class="btn btn-secondary mb-4">Save</button>
            </form>
          </div>
        </div>
      </div>
      <div class="card-body pt-4">
        <div class="row g-6">
          <div class="col-md-6">
            <label class="form-label">Name</label>
            <p>{{ Auth::user()->nama }}</p>
          </div>
          <div class="col-md-6">
            <label class="form-label">E-mail</label>
            <p>{{ Auth::user()->email }}</p>
          </div>
          <div class="col-md-6">
            <label class="form-label">Moto</label>
            <p>{{ Auth::user()->moto }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
