<div class="w-full overflow-hidden"
    x-data="{
        height:0,
        conversationElement:document.getElementById('conversation')
        }"
    x-init="
        height = conversationElement.scrollHeight;
         $nextTick(()=>conversationElement.scrollTop=height); //nextTrick is run after the alpine update is finish
    " 
    @scroll-bottom.window=" $nextTick(()=>conversationElement.scrollTop=height);">

    <div class="border-b flex flex-col h-full grow overflow-y-scroll">

        <!-- Header -->
        <header class="w-full sticky inset-x-0 flex pb-[5px] pt-[5x] top-0 z-10 bg-white border-b">
            <div class="flex w-full items-center px-2 py-2 lg:px-4 gap-2 md:gap-5">
                <a href="" class="shrink-0 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div class="shrink-0">
                    <x-avatar src="{{$selectedConversation->getReceiver()->image}}" class="h-9 w-9 lg:h-11 lg:w-11" />
                </div>
                <h6 class="font-bold truncate">
                    {{$selectedConversation->getReceiver()->name}}<br/>
                    <span class="text-gray-400 text-xs">{{$selectedConversation->getReceiver()->email}}</span>
                </h6>
            </div>
        </header>

        <!-- body -->
        <div 
        @scroll="
            scrollTop=$el.scrollTop;
            if(scrollTop <=0){
                $dispatch('loadMore');
            }
        "
        @update-chat-height.window ="
            $nextTick(() => {
            const newHeight = $el.scrollHeight;
            const heightDifference = newHeight - height;
            if (heightDifference > 0) {
                $el.scrollTop += heightDifference;
            }
            height = newHeight;
        });
        "
        id='conversation' 
        class="flex flex-col gap-3 p-2.5 overflow-auto flex-grow overscroll-contain overflow-x-hidden w-full my-auto">

            @if($loadedMessages->count()>0)

            @php
            $previousMessage = null;
            @endphp

            @foreach($loadedMessages as $key=>$message)

            @if($key>0)
            @php
            $previousMessage = $loadedMessages->get($key-1); 
            @endphp
            @endif

            <div @class([ 
                'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2' ,
                'ml-auto'=> $message->sender_id=== auth()->id()
                ])>

                <div @class([ 
                    'shrink-0' , 
                    'invisible'=>$previousMessage?->sender_id === $message->sender_id,
                    'hidden'=>$message->sender_id === auth()->id()
                    ])>
                    <x-avatar src="{{$selectedConversation->getReceiver()->image}}"/>
                </div>

                <div @class([ 'flex flex-wrap txt-[15px] rounded-xl p-2.5 flex flex-col text-black ' , 'rounded-bl-none border bg-gray-200'=>!($message->sender_id=== auth()->id()),
                    'rounded-br-none bg-blue-500/80 text-white bg-blue-600'=>$message->sender_id=== auth()->id()
                    ])>
                    <p class="whitespace-normal truncate text-sm md:text-base tracking-wide lg:tracking-normal">
                        {{$message->body}}
                    </p>

                    <!-- message send date -->
                    <div class="ml-auto flex gap-2">
                        <p @class([ 'text-xs' , 'text-gray-500'=>!($message->sender_id=== auth()->id()),
                            'text-white'=>$message->sender_id=== auth()->id(),
                            ])>
                            @formatDate($message->updated_at)
                        </p>
                        <!-- message status show or not -->
                        @if($message->sender_id === auth()->id())

                        <div>
                            @if ($message->isRead())
                            <!-- double ticks -->
                            <span @class('text-gray-100')>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                    <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                                    <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />
                                </svg>
                            </span>
                            @else
                            <!-- single ticks -->
                            <span @class('text-gray-300')>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                                </svg>
                            </span>
                            @endif

                        </div>
                        @endif
                    </div>
                </div>

            </div>
            @endforeach
            @else
            <div class="w-full flex justify-center items-center h-full text-gray-500">
                No Message Yet ...
            </div>
            @endif
        </div>

        <!-- footer -->
        <footer class="shrink-0 z-10 bg-white inset-x-0">
            <div class="p-2 border-t">
                <form action="post" autocapitalize="off" x-data="{body:@entangle('body')}" @submit.prevent="$wire.sendMessage">
                    @csrf
                    <input type="hidden" autocomplete="false" style="display: none;">
                    <div class="grid grid-cols-12">
                        <input x-model="body" type="text" placeholder="Write your message here" maxlength="1700" class="col-span-10 bg-gray-200 border-0 outline-0 focus:border-0 focus:ring-0 hover:ring-0 rounded-lg focus:outline-none">

                        <button x-bind:disabled="!body.trim()" class="col-span-2 flex gap-2 justify-center text-blue-800 items-center" type="submit">
                            <span class="sm:block hidden">
                                Send
                             </span>
                            <span class="rotate-45">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>

                @error('body')
                <p>{{$message}}</p>
                @enderror
            </div>
        </footer>

    </div>

</div>