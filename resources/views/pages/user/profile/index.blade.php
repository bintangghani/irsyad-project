@extends('layouts/master')

@section('title', 'Profile')

@section('content')
    <div class="flex justify-center py-12">
        <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="relative bg-gradient-to-r from-blue-500 to-indigo-500 p-6 flex items-center">
                <div class="relative">
                    <img src="{{ asset('storage/' . Auth::user()->profile) }}" alt="user-avatar"
                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md" id="profile" />
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-white">{{ Auth::user()->nama }}</h2>
                    <p class="text-sm text-indigo-200">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Form -->
            <div class="p-6">
                <form action="{{ route('dashboard.user.updateProfile', ['id' => Auth::user()]) }}" method="POST"
                    enctype="multipart/form-data" id="profile-form" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="nama" name="nama"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 disabled:opacity-50"
                                value="{{ Auth::user()->nama }}" disabled required />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="email" id="email" name="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 disabled:opacity-50"
                                value="{{ Auth::user()->email }}" disabled required />
                        </div>

                        <!-- Moto -->
                        <div>
                            <label for="moto" class="block text-sm font-medium text-gray-700">Moto</label>
                            <input type="text" id="moto" name="moto"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 disabled:opacity-50"
                                value="{{ Auth::user()->moto }}" disabled />
                        </div>

                        <!-- Profile Picture -->
                        <div>
                            <label for="profile" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                            <input type="file" id="profile" name="profile"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 disabled:opacity-50"
                                accept="image/png, image/jpeg, image/jpg" disabled />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" id="edit-button"
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-200">Edit</button>
                        <button type="submit" id="save-button"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-500 hidden">Save
                            Changes</button>
                        <button type="button" id="cancel-button"
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-200 hidden">Cancel</button>
                        <a href="{{ url('/dashboard/buku') }}"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-500">
                            Tambah Buku
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        const editButton = document.getElementById('edit-button');
        const saveButton = document.getElementById('save-button');
        const cancelButton = document.getElementById('cancel-button');
        const formInputs = document.querySelectorAll('#profile-form input');

        function enableEdit() {
            formInputs.forEach(input => input.disabled = false);
            editButton.classList.add('hidden');
            saveButton.classList.remove('hidden');
            cancelButton.classList.remove('hidden');
        }

        function disableEdit() {
            formInputs.forEach(input => input.disabled = true);
            editButton.classList.remove('hidden');
            saveButton.classList.add('hidden');
            cancelButton.classList.add('hidden');
        }

        editButton.addEventListener('click', enableEdit);
        cancelButton.addEventListener('click', () => {
            disableEdit();
            document.getElementById('profile-form').reset();
        });
    </script>
@endsection
