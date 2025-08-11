<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserHabitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'habit_id'     => ['nullable', 'exists:habits,id'],
            'custom_title' => ['nullable', 'string', 'max:255'],
            'custom_desc'  => ['nullable', 'string'],
            'color'        => ['nullable', 'string', 'max:20'],
            'question'     => ['nullable', 'string', 'max:255'],
            'unit'         => ['nullable', 'string', 'max:50'],
            'target'       => ['nullable', 'integer', 'min:0'],
            'target_type'  => ['required', 'in:at_least,at_most,exact'],
            'frequency'    => ['required', 'in:daily,weekly,monthly'],
            'reminder_time'=> ['nullable', 'string', 'max:20'],
            'notes'        => ['nullable', 'string'],
            'start_date'   => ['nullable', 'date'],
            'is_active'    => ['boolean'],
        ];
    }
}


