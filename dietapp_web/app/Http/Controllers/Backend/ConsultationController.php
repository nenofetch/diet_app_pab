<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatListUpdated;
use Illuminate\Support\Facades\Storage;

class ConsultationController extends Controller
{
    public function index()
    {
        return view('backend.consultations.index');
    }

    public function list(Request $request) {
        $user = Auth::user();

        $listChats = Consultation::where('sender_id', $user->id)
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

        $latestChats = collect();
        foreach ($listChats as $chats) {
            $latestChats->push($chats->first());
        }

        $users = User::whereIn('id', $latestChats->pluck('sender_id'))
                ->orWhereIn('id', $latestChats->pluck('recipient_id'))
                ->get();

        $listView = view('backend.consultations.list', compact('latestChats', 'users'))->render();

        $data = [
            'listView' => $listView,
        ];

        return response()->json($data);
    }

    public function new()
    {
        $users = User::all();

        $listUser = view('backend.consultations.new', compact('users'))->render();

        $data = [
            'listUser' => $listUser,
        ];

        return response()->json($data);
    }

    public function person($id)
    {
        // get data user
        $user = Auth::user();

        // get data user yang dituju
        $recipient = User::findOrFail($id);

        return view('backend.consultations.person', compact('recipient'));
    }

    public function content($id)
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


        $content = view('backend.consultations.content', compact('chats'))->render();
        return response()->json(['content' => $content]);
    }

    public function send(Request $request)
    {
        $admin = Auth::user();

        $chat = new Consultation;
        $chat->message = $request->message;
        $chat->sender_id = $admin->id;
        $chat->recipient_id = $request->recipient;
        $chat->save();

        return response()->json(['success' => true]);
    }

    public function attachment(Request $request)
    {
        $admin = Auth::user();

        // process upload image
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('public/attachments');
            $attachmentName = basename($attachmentPath);
        } else {
            $attachmentName = '';
        }

        $chat = new Consultation;
        $chat->attachment = $attachmentName;
        $chat->sender_id = $admin->id;
        $chat->recipient_id = $request->recipient;
        $chat->save();

        return response()->json(['success' => true]);
    }

    public function deleteAll(Request $request)
    {
        $user = Auth::user();

        $chats = Consultation::where(function($query) use ($user, $request) {
                        $query->where('sender_id', $user->id)
                            ->where('recipient_id', $request->recipient);
                    })
                    ->orWhere(function($query) use ($user, $request) {
                        $query->where('sender_id', $request->recipient)
                            ->where('recipient_id', $user->id);
                    })
                    ->delete();

        return response()->json(['success' => true]);
    }
}
