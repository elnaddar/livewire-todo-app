<div id="todos-list">
    @forelse ($todos as $todo)
        @include('livewire.todo-list.todo-card')
    @empty
        <div class="text-xs text-center text-gray-500">
            @if ($search == '')
                No todos till now try to add some.
            @else
                No todos for "{{ $search }}" till now try to add some.
            @endif
        </div>
    @endforelse
    <div class="my-2">
        {{ $todos->links() }}
    </div>
</div>
