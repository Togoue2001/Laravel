<div class="m-6 flex h-[620px] text-sm border rounded-xl shadow overflow-hidden bg-white">

    {{-- listes de utilisateurs --}}
    <div class="w-1/4 border-r bg-gray-50">
        <div class="p-4 font-bold text-gray-700 border-b">Users</div>
        <div class="divide-y">
            @foreach ($users as $user)
                <div wire:click="selectUser({{ $user->id }})"
                    class="p-3 cursor-pointer hover:bg-blue-100 transition
                    {{ $selectedUser->id === $user->id ? 'bg-blue-50 font-semibold' : '' }}">
                    <div class="text-gray-800">{{ $user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- section chat --}}
    <div class="flex flex-col w-3/4">

        {{-- Header --}}
        @if ($selectedUser)
            <div class="p-4 border-b bg-gray-50">
                <div class="text-lg text-gray-800 font-semibold">{{ $selectedUser->name }}</div>
                <div class="text-xs text-gray-500">{{ $selectedUser->email }}</div>
            </div>
        @endif

        {{-- Messages --}}
        <div class="flex-1 p-4 overflow-y-auto space-y-2 bg-gray-50">
            @foreach ($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} ">
                    <div class="max-w-xs p-4 py-2 rounded-2xl shadow 
                    {{ $message->sender_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }} ">
                        {{ $message->message }}
                    </div>
                </div>
            @endforeach
        </div>

        <div id="typing-indicator" class="px-4 pb-1 text-xs text-gray-400 italic"></div>

        {{-- Inputs --}}
        <form wire:submit="submit" action="#" class="p-4 border-t bg-white flex items-center gap-2">
            <input wire:model.live="newMessage"
                class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus-outline" type="text"
                placeholder="Tape ton message..." />
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-full">send</button>
        </form>

    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('userTyping', (event) => {
            console.log(event);
            window.Echo.private(`chat.${event.selectedUserID}`).whisper("typing", {
                userID: event.userID,
                userName: event.userName
            });
        });

        window.Echo.private(`chat.{{ $loginID }}`).listenForWhisper('typing', (event) => {
            var t = document.getElementById("typing-indicator");
            t.innerText = `${event.userName} is Typing...`;

            setTimeout(() => {
                t.innerText = '';
            }, 2000);
        })
    });
</script>
