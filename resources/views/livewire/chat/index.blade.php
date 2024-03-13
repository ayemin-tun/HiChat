<div class="fixed h-full flex bg-white border lg:shadow-sm overflow-hidden inset-0 lg:top-16 lg:inset-x-2 m-auto lg:h-[90%] rounded-lg ">
    <div class="relative w-full md:w-[320px] xl:2-[400px] overflow-y-auto shrink-0 h-full border">
        @include('livewire.chat.chat-list')
    </div>

    <div class="hidden md:grid w-full border-l h-full relative overflow-y-auto" style="contain:contnet">
        <div class="m-auto text-center justify-center flex flex-col gap-3">
            <h4 class="font-medium text-lg">
                Choose a conversion to start chatting
            </h4>
        </div>
    </div>
</div>