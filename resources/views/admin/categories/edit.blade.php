@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">Edit Category</h2>
            <p class="mt-1 text-sm text-gray-500">Update category details</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Categories</a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        There were some errors with your submission.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Enter category name">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Update Category
            </button>
        </div>
    </form>
</div>
@endsection 