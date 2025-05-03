@extends('admin.layout')

@section('title', 'Create Category')

@section('content')
<div class="bg-gray-800 rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Create Category</h2>
        <a href="{{ route('admin.categories.index') }}" class="text-teal-400 hover:text-teal-300">Back to Categories</a>
    </div>

    @if($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white shadow-sm focus:border-teal-500 focus:ring-teal-500">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
            <textarea name="description" id="description" rows="3" 
                class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                Create Category
            </button>
        </div>
    </form>
</div>
@endsection 