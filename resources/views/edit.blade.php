<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-200 text-xl text-gray-800 leading-tight">
                Permissions/Edit
            </h2>
            <a href="{{ route('permission.index') }}" class="btn btn-sm btn-dark">Back To</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="text-md mb-1">Name</label>
                            <div class="mb-3">
                                <input type="text" name="name" value="{{ old('name', $permission->name ?? '') }}"
                                    class="form-control rounded-2" placeholder="Enter Name"
                                    style="width: 25%; height: 35px;">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <button type="submit" class="btn btn-sm btn-dark mt-2 rounded-1">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
