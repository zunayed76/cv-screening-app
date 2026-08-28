<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Job Openings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Software Engineer</h3>
                <p class="text-gray-600 mb-4">Looking for a full-stack Laravel & Python developer...</p>

                {{-- Restrict Apply Button for Unauthenticated Users --}}
                @auth
                    @if(Auth::user()->role === 'candidate')
                        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded">Apply Now</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                        Log in to Apply
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>