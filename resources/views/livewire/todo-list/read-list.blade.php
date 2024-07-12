<div id="todos-list">
    @foreach ($todos as $todo)
        @include('livewire.todo-list.todo-card')
    @endforeach

    <div class="my-2">
        <!-- Pagination goes here -->
    </div>
</div>
