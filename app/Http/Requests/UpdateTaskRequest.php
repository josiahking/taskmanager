<?php

namespace App\Http\Requests;

use App\Enums\PriorityEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "id" => ["required", "integer"],
            "name" => ["sometimes", "required", "string", "max:255"],
            "priority" => ["sometimes", "required", new Enum(PriorityEnum::class)],
            "project_id" => "sometimes|nullable|integer",
            "order" => "sometimes|integer",
        ];
    }
}
