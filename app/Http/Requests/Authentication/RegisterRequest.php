<?php

namespace App\Http\Requests\Authentication;

use App\Enums\RoleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'confirmed', Password::defaults()],
      'role' => ['required', new Enum(RoleType::class)],
    ];
  }
}
