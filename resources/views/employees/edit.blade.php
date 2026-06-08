@extends('components.layouts.app')

@section('title', 'Edit Employee')

@section('content')

@php $prefix = auth()->user()->role . '.'; @endphp

<div class="container">

    <h1>Edit Employee: {{ $employee->first_name }} {{ $employee->last_name }}</h1>

    <form action="{{ route($prefix . 'employees.update', $employee) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- First Name --}}
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name"
                value="{{ old('first_name', $employee->first_name) }}" required>
            @error('first_name') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        {{-- Last Name --}}
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name"
                value="{{ old('last_name', $employee->last_name) }}" required>
            @error('last_name') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        {{-- Position --}}
        <div class="form-group">
            <label for="position">Position</label>
            <input type="text" id="position" name="position"
                value="{{ old('position', $employee->position) }}" required>
            @error('position') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        {{-- Hourly Rate --}}
        <div class="form-group">
            <label for="hourly_rate">Hourly Rate ($)</label>
            <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" min="0"
                value="{{ old('hourly_rate', $employee->hourly_rate) }}" required>
            @error('hourly_rate') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <x-button type="submit">Update Employee</x-button>
            <x-button href="{{ route($prefix . 'employees.index') }}" type="secondary">Cancel</x-button>
        </div>
    </form>
</div>
@endsection