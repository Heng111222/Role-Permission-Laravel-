<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-200 text-xl text-gray-800 leading-tight">
                User / Create
            </h2>
            <a href="{{ route('user.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf

                        {{-- User Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">User Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control w-25 rounded-2" placeholder="User Name">
                            @error('name')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- User Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control w-25 rounded-2" placeholder="Email">
                            @error('email')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" id="password" class="form-control w-25 rounded-2"
                                placeholder="Password">
                            @error('password')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control w-25 rounded-2" placeholder="Confirm Password">
                            @error('password_confirmation')
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
                                                value="{{ $role->name }}" id="role_{{ $role->id }}">
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
                                Create
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
