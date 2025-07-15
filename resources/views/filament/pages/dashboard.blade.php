@extends('filament::layouts.app')

@section('content')
    <div class="py-10 px-6 max-w-5xl mx-auto">
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-primary-700 mb-2">Welcome to LaralGrape Admin</h1>
            <p class="text-lg text-primary-600">Manage your site content, blocks, and settings with ease.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($resources as $resource)
                <a href="{{ route($resource['route']) }}" class="block bg-primary-50 shadow-lg rounded-xl p-6 border border-primary-100 hover:bg-primary-100 transition">
                    <div class="flex items-center space-x-4">
                        <x-dynamic-component :component="$resource['icon']" class="w-10 h-10 text-primary-600" />
                        <span class="text-xl font-semibold text-primary-800">{{ $resource['label'] }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection 