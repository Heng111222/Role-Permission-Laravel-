<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-200 text-xl text-gray-800 leading-tight">
                Role/Create
            </h2>
            <a href="{{ route('role.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('role.store') }}" method="POST">
                        @csrf
                        {{-- Role Name Input --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Role Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control w-25 rounded-2" placeholder="Enter Role Name">
                            @error('name')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Permission Checkboxes --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assign Permissions</label>
                            <div class="row">
                                @if ($permission->isNotEmpty())
                                    @foreach ($permission as $permissions)
                                        <div class="col-md-3 col-sm-6 mb-2 d-flex align-items-center">
                                            <input type="checkbox" class="form-check-input me-2" name="permission[]"
                                                value="{{ $permissions->name }}" id="perm_{{ $permissions->id }}">
                                            <label for="perm_{{ $permissions->id }}" class="form-check-label">
                                                {{ $permissions->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">No permissions available.</p>
                                @endif
                            </div>
                        </div>
                        {{-- Submit Button --}}
                        <div class="mt-3">
                            <button type="submit" class="btn btn-dark btn-sm rounded-1 px-4 py-2">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
