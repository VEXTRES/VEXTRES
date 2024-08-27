<?php

namespace App\Livewire;

use App\Models\Chat;
use App\Models\Contact;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessage;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ChatController extends Component
{

    public $search;
    public $contactChat;
    public $chat;
    public $bodyMessage;
    public $chat_id;
    public $users;


    public function mount()
    {
        $this->users = collect();

    }
    public function render()
    {

        return view('livewire.chat-controller')->layout('layouts.chat');
    }
    // public function getChatsProperty()
    // {
    //     return Chat::whereHas('users', function ($query) {
    //         $query->where('user_id', auth()->id());
    //     })
    //     ->with('messages')
    //     ->get();
    // }

    public function getContactsProperty()
    {
        return Contact::where('user_id', auth()->id())
            ->when($this->search, function ($query) {

                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($query) {
                            $query->where('email', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->get() ?? [];
    }
    public function getMessagesProperty()
    {
        return $this->chat ? $this->chat->messages : [];
    }

    public function getChatsProperty()
    {
        return auth()->user()->chats->sortByDesc('last_message_at');
    }

public function getUsersNotificationsProperty(){
    return $this->chat ? $this->chat->users->where('id','!=', auth()->id()): [];
}


    public function open_chat_contact(Contact $contact)
    {
        $chat = auth()->user()->chats()->whereHas('users', function ($query) use ($contact) {
            $query->where('user_id', $contact->contact_id);
        })
            ->has('users', 2)
            ->first();

        if ($chat) {
            $this->chat = $chat;
            $this->chat_id = $chat->id;
            $this->reset('bodyMessage', 'contactChat', 'search');
        } else {
            $this->contactChat = $contact;
            $this->reset('bodyMessage', 'chat', 'search');
        }

        return $chat;
    }

    public function open_chat(Chat $chat)
    {
        $this->chat = $chat;
        $this->chat_id = $chat->id;
        $this->reset('bodyMessage', 'contactChat');
    }

  public function sendMessage()
    {
        $this->validate([
            'bodyMessage' => 'required'
        ]);

        if (!$this->chat) {
            $this->chat = Chat::create();
            $this->chat_id = $this->chat->id;
            $this->chat->users()->attach([auth()->user()->id, $this->contactChat->contact_id]);
        }

        $this->chat->messages()->create([
            'body'    => $this->bodyMessage,
            'user_id' => auth()->user()->id
        ]);

        Notification::send($this->users_notifications,new NewMessage());

        $this->reset('bodyMessage', 'contactChat');
    }


}
