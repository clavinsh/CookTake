<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Tag') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <form method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" />
            </div>
            <input type="submit" value="Submit">
        </form>
    </div>
</x-app-layout>