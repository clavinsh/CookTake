<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All tags') }}
        </h2>
    </x-slot>
    <div class="py-12">
        @if(count($tags) == 0)
        <p>No tags found in the database!</p>
        @else
        <table>
            <tr>
                <td>Tag ID</td>
                <td>Name</td>
            </tr>
            @foreach($tags as $tag)
            <tr>
                <td>{{$tag->id}}</td>
                <td>{{$tag->name}}</td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>
</x-app-layout>