@extends('layouts/dashboard')

@section('title', 'Profile')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-6">
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                        <img src="{{ asset('storage/' . Auth::user()->profile) }}" alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded" id="profile" />
                    </div>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('dashboard.user.updateProfile', ['id' => Auth::user()]) }}" method="POST"
                        enctype="multipart/form-data" id="profile-form">
                        @csrf
                        @method('PUT')
                        <div class="row g-6">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Name</label>
                                <input type="text" id="nama" name="nama" class="form-control"
                                    value="{{ Auth::user()->nama }}" disabled required />
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ Auth::user()->email }}" disabled required />
                            </div>
                            <div class="col-md-6">
                                <label for="moto" class="form-label">Moto</label>
                                <input type="text" id="moto" name="moto" class="form-control"
                                    value="{{ Auth::user()->moto }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label for="profile" class="form-label">Profile Picture</label>
                                <input type="file" id="profile" name="profile" class="form-control"
                                    accept="image/png, image/jpeg, image/jpg" disabled />
                            </div>
                            <div class="col-12 mt-4">
                                <button type="button" class="btn btn-secondary" id="toggle-button">Edit</button>
                                <button type="submit" class="btn btn-primary" id="save-button" style="display: none;">Save
                                    Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const toggleButton = document.getElementById('toggle-button');
        const saveButton = document.getElementById('save-button');
        const form = document.getElementById('profile-form');
        const formInputs = form.querySelectorAll('input');
        let isEditing = false;

        toggleButton.addEventListener('click', () => {
            isEditing = !isEditing;

            formInputs.forEach(input => {
                input.disabled = !isEditing;
            });

            if (isEditing) {
                toggleButton.textContent = 'Cancel';
                saveButton.style.display = 'inline-block';
            } else {
                toggleButton.textContent = 'Edit';
                saveButton.style.display = 'none';
                form.reset();
            }
        });
    </script>

@endsection
