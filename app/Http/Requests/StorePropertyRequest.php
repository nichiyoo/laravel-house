<?php

namespace App\Http\Requests;

use App\Enums\AmenityType;
use App\Enums\IntervalType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePropertyRequest extends FormRequest
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
      'name' => ['required', 'string'],
      'city' => ['required', 'string'],
      'region' => ['required', 'string'],
      'zipcode' => ['required', 'string'],
      'address' => ['required', 'string'],
      'price' => ['required', 'integer', 'min:0'],
      'capacity' => ['required', 'integer', 'min:0'],
      'description' => ['required', 'string'],
      'latitude' => ['required', 'numeric'],
      'longitude' => ['required', 'numeric'],
      'backdrop' => ['nullable', 'image'],
      'images' => ['nullable', 'array'],
      'images.*' => ['image'],
      'amenities' => ['nullable', 'array'],
      'amenities.*' => ['required', 'string', Rule::enum(AmenityType::class)],
      'interval' => ['required', 'string', Rule::enum(IntervalType::class)],
    ];
  }
}
