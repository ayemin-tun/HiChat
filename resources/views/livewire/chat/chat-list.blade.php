<div 
   x-data="{type:'all',query:@entangle('query')}"
    x-init="
      setTimeout(()=>{
         conversationElement = document.getElementById('conversation-'+query);
         // scroll to that element
         if(conversationElement){
            conversationElement.scrollIntoView({ behavior: 'smooth' });
         }
      },200);

      Echo.private('users.{{Auth()->User()->id}}').notification((notification)=>{
              @this.dispatch('refresh');
        });
      "

      @scroll-top.window="$nextTick(() => {
         document.getElementById('conversation-'+query).scrollIntoView({ behavior: 'smooth' });
      })"    

      class="flex flex-col transition-all h-full overflow-hidden">

   <header class="px-3 z-10 bg-white sticky top-0 w-full py-2">
      <div class="border-b justify-between flex items-center pb-2">
         <div class="flex items-center gap-2">
            <h5 class="font-extrabold text-xl">Chats</h5>
         </div>

         <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class='w-7 h-7' fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
               <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
            </svg>
         </button>
      </div>
      <!-- Filters -->
      <!-- <div class="flex gap-3 items-center py-2 bg-white">
         <button @click="type='all'" :class="{'bg-blue-200 border-0 text-black':type=='all'}" class="inline-flex justif-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">
            All
         </button>
         <button @click="type='deleted'" :class="{'bg-blue-200 border-0 text-black':type=='deleted'}" class="inline-flex justif-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">
            Deleted
         </button>
      </div> -->
   </header>

   <main class="overflow-y-scroll overflow-hidden grow h-full relative" style="contain:content">
      <ul class="p-2 grid w-full space-y-2">
         @if($conversations->count() >0)
         @foreach($conversations as $key=>$conversation)
         <li id="conversation-{{$conversation->id}}" wire:key={{$conversation->id}} class="py-3 hover:bg-gray-200 rounded-2xl drak:hover:bg-gray-700/20 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 {{$conversation->id == $selectedConversation?->id?'bg-gray-200':''}}">
            <a href="{{route('chat',$conversation->id)}}" class="shrink-0">
               <x-avatar src="{{$conversation->getReceiver()->image}}" />
            </a>
            <aside class="grid grid-cols-12 w-full">
               <a href="{{route('chat',$conversation->id)}}" class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1">
                  <!-- name and date -->
                  <div class="flex justify-between w-full item-center">
                     <!-- Name -->
                     <h6 class="truncate font-medium tracking-wider text-gray-800">
                        {{$conversation->getReceiver()->name}}
                     </h6>
                     <!-- Date -->
                     <small class="text-gray-700">
                        {{$conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans()}}
                     </small>
                  </div>

                  <!-- message body -->
                  <div class="flex gap-x-2 items-center">
                  @if($conversation->messages?->last()?->sender_id === auth()->id())
                     @if($conversation->messages?->last()->isRead())
                     <!-- double tip -->
                     <span class="text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                           <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                           <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />
                        </svg>
                     </span>
                     @else
                     <!-- single tip -->
                     <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                           <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                        </svg>
                     </span>
                     @endif
                     you: 
                  @endif

                     <p @class([ 
                        'grow truncate text-sm font-[100]' , 
                        'font-extrabold'=> $conversation?->isNewMessage()])
                        >
                        {{$conversation->messages?->last()?->body}}
                     </p>

                     @if($conversation->isNewMessage())
                     <span class="font-bold p-px px-2 text-sm shrink-0 rounded-full bg-blue-500 text-white">
                        {{$conversation->unreadMessageCount()}}
                     </span>
                     @endif
                  </div>
               </a>

               <!-- dropdown -->
               <div class="col-span-1 flex flex-col text-center my-atuo">
                  <x-dropdown align="right" width="48">
                     <x-slot name="trigger">
                        <button class="hover:text-blue-700 transition-colors">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical w-6 h-6" viewBox="0 0 16 16">
                              <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                           </svg>
                        </button>
                     </x-slot>

                     <x-slot name="content">
                        <div class="w-full">
                           <!-- <button class="items-center gap-3 flex w-full px-4 py-2 text-sm leading-5 text-gray-500 hover:bg-gray-200 transition-all duration-150 ease-in-out focus:outline-none foucs:bg-gray-100">
                              <span>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                                 </svg>
                              </span>
                              View Profile
                           </button> -->
                           <button 
                           onclick="confirm('Are You Sure! You want to delete this?') || event.stopImmediatePropagation()"
                           wire:click="deleteByUser('{{encrypt($conversation->id)}}')"
                           class="items-center gap-3 flex w-full px-4 py-2 text-sm leading-5 text-gray-500 hover:bg-gray-200 transition-all duration-150 ease-in-out focus:outline-none foucs:bg-gray-100">
                              <span>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                 </svg>
                              </span>
                              Deleted
                           </button>
                        </div>
                     </x-slot>
                  </x-dropdown>
               </div>
            </aside>
         </li>
         @endforeach
         @else
            <div class="w-full h-[60vh] flex flex-col items-center justify-center">
               No Conversation  ...
               <a href={{route('users')}}>
               <button class="px-4 py-1 bg-blue-500 text-white rounded-lg text-sm">
                  start
               </button>
               </a>
            </div>
         @endif
      </ul>
   </main>
   
</div>