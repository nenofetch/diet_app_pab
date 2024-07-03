<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Storage;

class ConsultationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $latestChats = Consultation::where('sender_id', $user->id)
            ->orWhere('recipient_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($chat) use ($user) {
                if ($chat->sender_id == $user->id) {
                    return $chat->recipient_id;
                } else {
                    return $chat->sender_id;
                }
            });

        return ResponseFormatter::success($latestChats, 'Data berhasil ditampilkan!');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $chat = Consultation::create([
            'message' => $request->message,
            'sender_id' => $user->id,
            'recipient_id' => $request->recipient_id,
        ]);

        return ResponseFormatter::success($chat, 'Berhasil dikirim!');
    }

    public function show($id)
    {
        // get data user
        $user = Auth::user();

        // get data intended user
        $recipient = User::findOrFail($id);

        $reads = Consultation::where('recipient_id', $user->id)
                        ->where('sender_id', $recipient->id)
                        ->where('status', 'unread')
                        ->update(['status' => 'read']);

        // get all data chat
        $chats = Consultation::where(function($query) use ($user, $recipient) {
                            $query->where('sender_id', $user->id)
                                ->where('recipient_id', $recipient->id);
                        })->orWhere(function($query) use ($user, $recipient) {
                            $query->where('sender_id', $recipient->id)
                                ->where('recipient_id', $user->id);
                        })->orderBy('created_at', 'ASC')->get();

        return ResponseFormatter::success($chats, 'Data berhasil ditampilkan!');
    }

    public function attachment(Request $request)
    {
        $user = Auth::user();

        // process upload image
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('public/attachments');
            $attachmentName = basename($attachmentPath);
        } else {
            $attachmentName = '';
        }

        $chat = Consultation::create([
            'attachment' => $attachmentName,
            'sender_id' => $user->id,
            'recipient_id' => $request->recipient_id,
        ]);

        return ResponseFormatter::success($chat, 'Berhasil dikirim!');
    }

    public function deletePerson($id)
    {
        $user = Auth::user();

        $chats = Consultation::where(function($query) use ($user, $id) {
                        $query->where('sender_id', $user->id)
                            ->where('recipient_id', $id);
                    })
                    ->orWhere(function($query) use ($user, $id) {
                        $query->where('sender_id', $id)
                            ->where('recipient_id', $user->id);
                    })
                    ->delete();

        return ResponseFormatter::success($chats, 'Berhasil dihapus!');
    }
}
