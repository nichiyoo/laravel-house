<?php

namespace App\Http\Requests;

use App\Enums\MethodType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRentRequest extends FormRequest
{
  /**
   * determine if the user is authorized to make this request
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * get the validation rules that apply to the request
   */
  public function rules(): array
  {
    return [
      'start' => ['required', 'date', 'after:today'],
      'duration' => ['required', 'integer', 'min:1'],
      'method' => ['required', Rule::enum(MethodType::class)],
    ];
  }
}
