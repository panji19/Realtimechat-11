<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class Chat extends Component
{
    // Properti untuk menampung data user penerima pesan
    public User $receiver;

    // Properti untuk menampung pesan baru yang akan dikirim (terhubung dengan <textarea>)
    public string $message = '';

    /**
     * Method ini dijalankan saat komponen pertama kali dimuat.
     * Menerima instance User sebagai penerima chat.
     */
    public function mount(User $user)
    {
        $this->receiver = $user;
    }

    /**
     * Method ini dipanggil saat form pengiriman pesan di-submit.
     */
    public function sendMessage()
    {
        // Validasi agar pesan tidak kosong
        $this->validate([
            'message' => 'required|string',
        ]);

        // Membuat record baru di database
        Message::create([
            'from_user_id' => auth()->id(), // <-- Menggunakan ID user yang sedang login sebagai pengirim
            'to_user_id' => $this->receiver->id, // Menggunakan ID user penerima
            'message' => $this->message,
        ]);

        // Mengosongkan kembali textarea setelah pesan terkirim
        $this->reset('message');
    }

    /**
     * Method render() akan dijalankan ulang oleh `wire:poll`
     * untuk mengambil data pesan terbaru dari database.
     */
    public function render()
    {
        // Mengambil semua pesan antara user yang login dan user penerima
        $messages = Message::where(function ($query) {
                $query->where('from_user_id', auth()->id())
                      ->where('to_user_id', $this->receiver->id);
            })->orWhere(function ($query) {
                $query->where('from_user_id', $this->receiver->id)
                      ->where('to_user_id', auth()->id());
            })
            ->oldest() // Mengurutkan dari yang paling lama
            ->get();
            
        // Mengirim data messages ke view
        return view('livewire.chat', [
            'messages' => $messages
        ]);
    }
}