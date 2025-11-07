<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-200 text-xl text-gray-800 leading-tight">
                User / Edit
            </h2>
            <a href="{{ route('role.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('user.update', $users->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Important for update --}}

                        {{-- User Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">User Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $users->name) }}"
                                class="form-control w-25 rounded-2" placeholder="Enter User Name">
                            @error('name')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- User Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $users->email) }}" class="form-control w-25 rounded-2"
                                placeholder="Enter Email">
                            @error('email')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Assign Roles --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold d-block">Assign Roles</label>
                            @if ($roles->isNotEmpty())
                                <div class="row">
                                    @foreach ($roles as $role)
                                        <div class="col-md-3 col-sm-6 mb-2 d-flex align-items-center">
                                            <input type="checkbox" class="form-check-input me-2" name="roles[]"
                                                value="{{ $role->name }}" id="role_{{ $role->id }}"
                                                {{ $users->roles?->pluck('name')->contains($role->name) ? 'checked' : '' }}>
                                            <label for="role_{{ $role->id }}" class="form-check-label">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No roles available.</p>
                            @endif
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-3">
                            <button type="submit" class="btn btn-dark btn-sm rounded-1 px-4 py-2">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
