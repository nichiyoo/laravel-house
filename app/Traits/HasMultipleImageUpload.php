<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Uri;

trait HasMultipleImageUpload
{
  /**
   * Store multiple uploaded images from the request.
   *
   * @param \Illuminate\Http\Request $request
   * @param string $field Field name
   * @return void
   */
  public function storeImages(Request $request, string $field = 'images')
  {
    $valid = $request->hasFile($field);
    if (!$valid) return;

    $this->deleteImages($field);

    $files = $request->file($field);
    $paths = [];

    foreach ($files as $file) {
      $path = $file->store('uploads', 'public');
      $paths[] = asset($path);
    }

    $this->{$field} = $paths;
  }

  /**
   * Delete all images in the array.
   *
   * @param string $field Field name
   * @return void
   */
  public function deleteImages(string $field = 'images')
  {
    $images = $this->{$field};
    if (!$images) return;

    foreach ($images as $image) {
      $this->deleteImageUrl($image);
    }

    $this->{$field} = [];
  }

  /**
   * Delete an image file by its URL.
   *
   * @param string $image Image URL
   * @return void
   */
  protected function deleteImageUrl(string $image)
  {
    if (!$image) return;

    $uri = Uri::of($image);
    $path = $uri->path();

    $exist = Storage::disk('public')->exists($path);
    if (!$exist) return;

    Storage::disk('public')->delete($path);
  }
}
