<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
  /**
   * determine if user authorized to make this request
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * get validation rules
   */
  public function rules(): array
  {
    return [
      'email' => ['required', 'string', 'email'],
      'password' => ['required', 'string'],
    ];
  }
}
