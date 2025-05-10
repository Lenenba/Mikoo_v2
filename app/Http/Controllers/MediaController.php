<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{

    /**
     * Display a listing of the media items for the authenticated user.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get all media items for this user, most recent first
        $media = $user->media()
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($item) => [
                'id'              => $item->id,
                'url'             => $item->file_path,
                'collection_name' => $item->collection_name,
                'mime_type'       => $item->mime_type,
                'is_profile'      => $item->is_profile_picture,
            ]);

        return Inertia::render('settings/media', [
            'media' => $media,
        ]);
    }

    /**
     * Store a newly created media item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $media = Auth::user()->media;
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'mimes:jpg,png,jpeg,webp|max:5000'
            ], [
                'images.*.mimes' => 'The file should be in one of the formats: jpg, png, jpeg, webp'
            ]);
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');

                $media->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'is_profile_picture' => false,
                    'collection_name' => $request['collection_name'] ?? 'default',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Images uploaded!');
    }
}
