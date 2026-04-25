<form method="POST" action="{{ route('attendances.update', $attendance) }}">
    @csrf
    @method('PUT')

    <div class="mt-4">
        <x-input-label for="employee_id" :value="__('Employee')" />
        <select name="employee_id" id="employee_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" @selected(old('employee_id', $attendance->employee_id) == $employee->id)>
                    {{ $employee->full_name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <div>
            <x-input-label for="date" :value="__('Date')" />
            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', $attendance->date?->format('Y-m-d'))" required />
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>
        
        </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button>
            {{ __('Update Attendance') }}
        </x-primary-button>
    </div>
</form>