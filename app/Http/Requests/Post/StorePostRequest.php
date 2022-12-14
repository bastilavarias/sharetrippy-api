<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $type = $this->type ?? null;
        $step = intval($this->step) ?? null;
        $rules = [];
        if ($type === 'timeline' && $step === 1) {
            $rules = [
                'title' => 'required|string',
                'introduction' => 'required|string',
                'tags' => 'array',
                'tags.*' => 'required|string|distinct',
                'is_draft' => 'boolean',
            ];
        } elseif ($type === 'timeline' && $step === 2) {
            $rules = [
                'post_id' => 'required|integer',
                'timelines.*.title' => 'required|string|distinct',
                'timelines.*.introduction' => 'required|string',
                'timelines.*.expenses' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'timelines.*.activities' => 'array',
                'timelines.*.activities.*.title' => 'required|string|distinct',
                'timelines.*.activities.*.notes' => 'required|string',
                'timelines.*.transportations' => 'array',
                'timelines.*.transportations.*' => 'required|string|distinct',
                'timelines.*.destinations' => 'array',
                'timelines.*.destinations.*' => 'required|string|distinct',
                'timelines.*.lodgings' => 'array',
                'timelines.*.lodgings.*' => 'required|string|distinct',
                'is_draft' => 'boolean',
            ];
        }

        return $rules;
    }
}
