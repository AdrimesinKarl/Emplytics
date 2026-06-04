@extends('components.layouts.app')

@section('title', 'Create Employee')

@section('content')
<div class="container">
    <h1>Create New Employee</h1>
    
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        {{-- First Name --}}
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name"
                value="{{ old('first_name') }}" required>
            @error('first_name') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        {{-- Last Name --}}
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name"
                value="{{ old('last_name') }}" required>
            @error('last_name') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        
        {{-- Job Position --}}
        <div class="form-group">
            <label for="position">Position</label>
            <input type="text" id="position" name="position"
                value="{{ old('position') }}" required>
            @error('position') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        {{-- Pay Rate --}}
        <div class="form-group">
            <label for="hourly_rate">Hourly Rate ($)</label>
            <input type="number" id="hourly_rate" name="hourly_rate"
                step="0.01" min="0" value="{{ old('hourly_rate') }}" required>
            @error('hourly_rate') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <x-button type="submit">Create Employee</x-button>
            <x-button href="{{ route('employees.index') }}" type="secondary">Cancel</x-button>
        </div>
    </form>

    {{-- Fallback for global errors --}}
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> There were some problems with your input.
        </div>
    @endif
</div>
@endsection