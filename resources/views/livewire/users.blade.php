<div class="max-w-6xl mx-auto my-16">
    <h5 class="text-center text-5xl font-bold py-3">Users</h5>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 p-2">
        @foreach($users as $key=>$user)
        <div class="w-full bg-white border-gray-200 rounded-lg shadow-lg border">
            <div class="flex flex-col items-center pb-10">
                <div class="bg-blue-300 h-16 w-full relative flex justify-center rounded-t-lg">
                    <x-avatar src="{{$user->image}}" class="w-20 h-20 mb-2 5 rounded-full shadow lg absolute -bottom-10"/>
                </div>
               
                <h5 class="mb-1 text-xl font-medim text-gray-900 mt-10">
                    {{$user->name}}
                </h5>
                <span class="text-sm text-gray-500">{{$user->email}}</span>
                <div class="flex mt-4 spae-x-3 md:mt-6 gap-2">
                    <!-- <x-secondary-button>Add Friend</x-secondary-button> -->
                    <x-primary-button wire:click="message({{$user->id}})" class="hover:animate-bounce transition-transform duration-300 ease-in-out">Message</x-primary-button>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>