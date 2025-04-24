<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrawlPostValidate extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'source_url' => 'nullable|url',
            'source_name' => 'nullable|string|max:255',
            'source_author' => 'nullable|string|max:255',
            'crawled_at' => 'nullable|date',
            'original_id' => 'nullable|string',
            'is_crawled' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
            'thumbnail' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published'
        ];
    }
}
