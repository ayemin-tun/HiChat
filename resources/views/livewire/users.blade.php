<div class="max-w-6xl mx-auto my-16">
    <h5 class="text-center text-5xl font-bold py-3">Users</h5>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 p-2">
        @foreach($users as $key=>$user)
        <div class="w-full bg-white border-gray-200 rounded-lg p-5 shadow">
            <div class="flex flex-col items-center pb-10">
                <img src="https://source.unsplash.com/500x500?face-{{$key}}" alt="" class="w-20 h-20 mb-2 5 rounded-full shadow lg">
                <h5 class="mb-1 text-xl font-medim text-gray-900">
                    {{$user->name}}
                </h5>
                <span class="text-sm text-gray-500">{{$user->email}}</span>
                <div class="flex mt-4 spae-x-3 md:mt-6 gap-2">
                    <x-secondary-button>Add Friend</x-secondary-button>
                    <x-primary-button wire:click="message({{$user->id}})">Message</x-primary-button>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>