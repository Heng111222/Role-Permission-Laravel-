<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-200 text-xl text-gray-800 leading-tight">
                Article/Edit
            </h2>
            <a href="{{ route('role.index') }}" class="btn btn-sm btn-dark">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-sm">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('article.update', $article->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Title Input --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $article->title) }}" class="form-control w-50 rounded-2"
                                placeholder="Enter Title">
                            @error('title')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Content Input --}}
                        <div class="mb-3">
                            <label for="text" class="form-label fw-semibold">Content</label>
                            <textarea name="text" id="text" class="form-control w-50 rounded-2" placeholder="Enter Content" rows="5">{{ old('text', $article->text) }}</textarea>
                            @error('text')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Author Input --}}
                        <div class="mb-3">
                            <label for="author" class="form-label fw-semibold">Author</label>
                            <input type="text" name="author" id="author"
                                value="{{ old('author', $article->author) }}" class="form-control w-50 rounded-2"
                                placeholder="Enter Author">
                            @error('author')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
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
