<?php
// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = storage_path('app/public/profile_pictures/' . $filename);

            // Resize the image to a width of 300 and constrain aspect ratio (auto height)
            $image = Image::make($file)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Save the image
            $image->save($path);


            return back()->with('success', 'Profile picture uploaded successfully.');
        }

            return back()->with('error', 'Please select a valid image.');
    }
}
