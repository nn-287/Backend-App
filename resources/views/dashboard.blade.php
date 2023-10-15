<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="card-body">
        @if(auth()->user()->type == 'admin')
            <a href="{{ route('admin.dashboard') }}">Admin welcome!</a>
        @else
            <div class="panel-heading">Normal User welcome!</div>
        @endif
    </div>
</x-app-layout>
