<?php

namespace App\Actions;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class CreateMessageAction
{
    public function handle(Request $request): ?Message
    {
        $files = $request->file('files');

        $message=null;

        if ($request->hasFile('files') && is_iterable($files)) {
            foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $finalName = Str::slug($originalName, '-') . '.' . $extension;

                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                        $file->move(storage_path('app/public/message-files/images/'), $finalName);

                        $message=Message::create([
                            'conversation_id' => $request->input('conversation_id'),
                            'user_id' => $request->input('user_id'),
                            'type' => 'image',
                            'is_seen'=>false,
                            'image_path' => $finalName,
                        ]);

                    } elseif (in_array($extension, ['mp4', 'mov'])) {
                        $file->move(storage_path('app/public/message-files/videos/'), $finalName);

                        $message=Message::create([
                            'conversation_id' => $request->input('conversation_id'),
                            'user_id' => $request->input('user_id'),
                            'type' => 'video',
                            'is_seen'=>false,
                            'video_path' => $finalName,
                        ]);

                    }
                }
            }
            return $message;

        } else {
            $message=Message::create([
                'conversation_id' => $request->input('conversation_id'),
                'user_id' => $request->input('user_id'),
                'type' => 'text',
                'is_seen'=>false,
                'message' => $request->input('message'),
            ]);

            return $message;
        }
    }

}
