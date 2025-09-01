<div class="flex justify-center items-center">
    <flux:navbar >
        <flux:navbar.item  wire:navigate href="/club">All Club</flux:navbar.item>
        <flux:navbar.item  wire:navigate href="/club/member">Member</flux:navbar.item>
        <flux:navbar.item  wire:navigate href="/club/waiting-list">Request Member
        @if ($waitingCount>0)

            <small class="bg-red-500 flex top-0 right-0 w-[20px] h-[20px] justify-center items-center rounded-lg absolute" style="width: 20px;height: 20px;">
                @if ($waitingCount<9)

            {{$waitingCount}}
            @else
            9+
            @endif
            </small>
            @endif
        </flux:navbar.item>
    </flux:navbar>
</div>
