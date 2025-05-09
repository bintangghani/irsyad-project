@extends('layouts.dashboard')

@section('title', 'Profile Instansi')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-6">
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4 pb-4 border-bottom">
                        <div> Background
                        <img src="{{ asset('storage/' . $instansi->background) }}" alt="Instansi Background" class="d-block w-px-100 h-px-100 rounded" alt="">
                        </div>
                        <div> Profile
                        <img src="{{ $instansi->profile ? asset('storage/' . $instansi->profile) : asset('default-avatar.png') }}"
                            alt="Instansi Avatar" class="d-block w-px-100 h-px-100 rounded" id="profilePreview" />
                        </div>
                    </div>
                </div>

                <div class="card-body pt-4">
                    <form action="{{ route('dashboard.user.instansi.updateProfile', ['id' => $instansi->id_instansi]) }}" method="POST"
                        enctype="multipart/form-data" id="instansi-profile-form">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Instansi</label>
                                <input type="text" id="nama" name="nama" class="form-control"
                                    value="{{ old('nama', $instansi->nama) }}"  />
                            </div>
                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" id="alamat" name="alamat" class="form-control"
                                    value="{{ old('alamat', $instansi->alamat) }}"  />
                            </div>
                            <div class="col-md-6">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <input type="text" id="deskripsi" name="deskripsi" class="form-control"
                                    value="{{ old('deskripsi', $instansi->deskripsi) }}"  />
                            </div>
                            <div class="col-md-6">
                                <label for="profile" class="form-label">Profile Picture</label>
                                <input type="file" id="profile" name="profile" class="form-control"
                                    accept="image/png, image/jpeg, image/jpg"
                                    onchange="previewImage(event, 'profilePreview')" />
                            </div>
                            <div class="col-md-6">
                                <label for="background" class="form-label mt-3">Background Image</label>
                                <input type="file" id="background" name="background" class="form-control"
                                    accept="image/png, image/jpeg, image/jpg" />
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="button" class="btn btn-secondary" id="toggle-button">Edit</button>
                            <button type="submit" class="btn btn-primary" id="save-button" style="display: none;">Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const toggleButton = document.getElementById('toggle-button');
        const saveButton = document.getElementById('save-button');
        const form = document.getElementById('instansi-profile-form');
        const formInputs = form.querySelectorAll('input[type="text"], input[type="file"]');
        const originalValues = {};

        formInputs.forEach(input => {
            if (input.type === 'text') {
                originalValues[input.id] = input.value;
            }
        });

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

                formInputs.forEach(input => {
                    if (input.type === 'text') {
                        input.value = originalValues[input.id];
                    } else if (input.type === 'file') {
                        input.value = null; 
                    }
                });

                @if ($instansi->profile)
                    document.getElementById('profilePreview').src = "{{ asset('storage/' . $instansi->profile) }}";
                @else
                    document.getElementById('profilePreview').src = "{{ asset('default-avatar.png') }}";
                @endif
            }
        });

        function previewImage(event, idPreview) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const output = document.getElementById(idPreview);
                output.src = e.target.result;
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endsection
