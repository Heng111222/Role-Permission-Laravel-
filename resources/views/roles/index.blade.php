<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-200 text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            <a href="{{ route('role.create') }}" class="btn btn-sm btn-dark">create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Session::has('success'))
                <div class="alert alert-success border-none rounded-sm">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger border-none rounded-sm">{{ Session::get('error') }}</div>
            @endif
            <table class="table shadow-sm text-center border">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 125px;">No</th>
                        <th scope="col" class="text-start" style="padding-left: 50px;">Name</th>
                        <th scope="col" class="text-start" style="width: 500px;">Permission</th>
                        <th scope="col">Created</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($showData as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start" style="padding-left: 50px;">{{ $item->name }}</td>
                            <td class="text-start">{{ $item->permissions->pluck('name')->implode(', ') }}</td>
                            <td style="width: 150px;">{{ $item->created_at->format('Y-m-d') }}</td>
                            <td style="width: 250px;">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('role.edit', $item->id) }}" class="btn btn-dark btn-sm">
                                        Editer
                                    </a>
                                    <form action="{{ route('role.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                No data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-2">
                {{ $showData->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
