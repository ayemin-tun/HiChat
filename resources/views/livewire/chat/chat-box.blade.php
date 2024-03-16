<div class="w-full overflow-hidden">

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
                    <x-avatar class="h-9 w-9 lg:h-11 lg:w-11" />
                </div>
                <h6 class="font-bold truncate">
                    {{fake()->name}}
                </h6>
            </div>
        </header>

        <!-- body -->
        <div class="flex flex-col gap-3 p-2.5 overflow-auto flex-grow overscroll-contain overflow-x-hidden w-full my-auto">
            <div @class([ 'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2' ])>
                <div @class([ 'shrink-0' ])>
                    <x-avatar />
                </div>

                <div @class([ 'flex flex-wrap txt-[15px] rounded-xl p-2.5 flex flex-col text-black bg-blue-600' , 'rounded-bl-noe border border-gray-200/40'=>false,
                    'rounded-br-none bg-blue-500/80 text-white'=>true
                    ])>
                    <p class="whitespace-normal truncate text-sm md:text-base tracking-wide lg:tracking-normal">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio consequatur similique repellat nostrum quibusdam id laboriosam sed quia excepturi, natus maxime fugit accusantium? Corrupti earum, ipsum illum eveniet nisi dolores.
                    </p>

                    <!-- message send date -->
                    <div class="ml-auto flex gap-2">
                        <p @class([ 'text-xs' , 'text-gray-500'=>false,
                            'text-white'=>true,
                            ])>
                            5:25 am
                        </p>
                        <!-- message status show or not -->
                        <div>
                            <!-- double ticks -->
                            <span @class('text-gray-500')>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                    <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                                    <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />
                                </svg>
                            </span>

                            <!-- single ticks -->
                            <!-- <span @class('text-gray-500')>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                            </svg>
                        </span> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- footer -->
        <footer class="shrink-0 z-10 bg-white inset-x-0">
            <div class="p-2 border-t">
                <form action="post" autocapitalize="off">
                    @csrf
                    <input type="hidden" autocomplete="false" style="display: none;">
                    <div class="grid grid-cols-12">
                        <input type="text" autocomplete="off" autofocus placeholder="Write your message here" maxlength="1700" class="col-span-10 bg-gray-100 border-0 outline-0 focus:border-0 focus:ring-0 hover:ring-0 rounded-lg focus:outline-none">

                        <button class="col-span-2 flex gap-2 justify-center text-blue-800 items-center" type="submit">
                            Send
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