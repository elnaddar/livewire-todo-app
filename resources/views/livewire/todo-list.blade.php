<div id="content" class="mx-auto" style="max-width:500px;">
    {{-- The Master doesn't talk, he acts. --}}
    @include('livewire.todo-list.create-form')
    {{ count($todos) }}
</div>
