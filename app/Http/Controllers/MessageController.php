<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages.
     */
    public function index()
    {
        $receivedMessages = Message::where('recipient_id', Auth::id())
            ->whereNull('parent_id')
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $sentMessages = Message::where('sender_id', Auth::id())
            ->whereNull('parent_id')
            ->with('recipient')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('messages.index', compact('receivedMessages', 'sentMessages'));
    }

    /**
     * Show the form for creating a new message.
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.create', compact('users'));
    }

    /**
     * Store a newly created message in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:messages,id'
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('messages.index')->with('success', 'Message sent successfully!');
    }

    /**
     * Display the specified message with its replies.
     */
    public function show(Message $message)
    {
        // Check if user is authorized to view this message
        if ($message->sender_id !== Auth::id() && $message->recipient_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Mark as read if user is recipient
        if ($message->recipient_id === Auth::id() && !$message->read) {
            $message->update(['read' => true]);
        }

        $replies = $message->replies()->with('sender')->orderBy('created_at', 'asc')->get();
        
        return view('messages.show', compact('message', 'replies'));
    }

    /**
     * Show the form for replying to a message.
     */
    public function reply(Message $message)
    {
        // Check if user is authorized to reply to this message
        if ($message->sender_id !== Auth::id() && $message->recipient_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('messages.reply', compact('message'));
    }

    /**
     * Remove the specified message from storage.
     */
    public function destroy(Message $message)
    {
        // Check if user is authorized to delete this message
        if ($message->sender_id !== Auth::id() && $message->recipient_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $message->delete();
        
        return redirect()->route('messages.index')->with('success', 'Message deleted successfully!');
    }
}