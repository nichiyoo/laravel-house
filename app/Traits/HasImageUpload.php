<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Uri;

trait HasImageUpload
{
  /**
   * Store the uploaded image from the request.
   *
   * @param \Illuminate\Http\Request $request
   * @return void
   */
  public function storeImage(Request $request, string $field = 'image')
  {
    $valid = $request->hasFile($field);
    if (!$valid) return;

    $current = $this->getOriginal($field);
    if ($current) $this->deleteImage($field);

    $file = $request->file($field)->store('uploads', 'public');
    $this->{$field} = asset($file);
  }

  /**
   * Delete the image from storage.
   *
   * @param string $field
   * @return void
   */
  public function deleteImage(string $field = 'image')
  {
    $image = $this->{$field};
    if (!$image) return;

    $uri = Uri::of($image);
    $path = $uri->path();

    $exist = Storage::disk('public')->exists($path);
    if (!$exist) return;

    Storage::disk('public')->delete($path);
  }
}
