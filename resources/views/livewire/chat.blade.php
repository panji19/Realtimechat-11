<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- `wire:poll` akan me-refresh komponen ini secara berkala untuk menampilkan pesan baru --}}
                    <div wire:poll>
                        @forelse ($messages as $message)
                            {{-- Menentukan posisi chat bubble (kiri/kanan) --}}
                            <div class="chat @if($message->from_user_id == auth()->id()) chat-end @else chat-start @endif">
                                <div class="chat-image avatar">
                                    <div class="w-10 rounded-full">
                                        {{-- PERBAIKAN: Mengambil gambar profil dari user pengirim secara dinamis --}}
                                        {{-- Ganti 'profile_photo_url' sesuai dengan nama kolom/accessor di model User Anda --}}
                                        <img alt="User Avatar" src="{{ $message->fromUser->profile_photo_url ?? 'https://img.daisyui.com/images/profile/demo/kenobee@192.webp' }}" />
                                    </div>
                                </div>
                                <div class="chat-header">
                                    {{ $message->fromUser->name }}
                                    <time class="text-xs opacity-50">{{ $message->created_at->diffForHumans() }}</time>
                                </div>
                                <div class="chat-bubble">{{ $message->message }}</div>
                                <div class="chat-footer opacity-50">Delivered</div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500">
                                No messages yet. Start the conversation!
                            </div>
                        @endforelse
                    </div>

                    {{-- Form untuk mengirim pesan --}}
                    <div class="form-control pt-4">
                        <form wire:submit.prevent="sendMessage">
                            <textarea class="textarea textarea-bordered w-full" wire:model.defer="message" placeholder="Send your message..."></textarea>
                            <button type="submit" class="btn btn-primary w-full mt-2">Send</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>