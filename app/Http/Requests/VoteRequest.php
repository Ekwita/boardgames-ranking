<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
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
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'votes' => 'required|array|size:3',
            'votes.*.id' => 'required|integer|distinct',
            'votes.*.name' => 'required|string|max:255',
            'votes.*.points' => 'required|integer|min:1|max:3',
            'votes.*.image' => 'nullable|string|max:1024',
        ];
    }

    public function getDto()
    {
        //
    }
}
