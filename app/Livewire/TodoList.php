<?php

namespace App\Livewire;

use App\Models\Todo;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Validate("required|min:5|max:250")]
    public $name = '';
    public $search = '';
    public $editTodoId = '';
    #[Validate("required|min:5|max:250")]
    public $editNewName = '';

    public function delete(Todo $todo)
    {
        $todo->delete();
    }

    public function toggleEdit(Todo $todo)
    {
        if ($this->editTodoId != $todo->id) {
            $this->editTodoId = $todo->id;
            $this->editNewName = $todo->name;
        } else {
            $this->editTodoId = '';
            $this->editNewName = '';
        }
    }

    public function create()
    {
        $this->validateOnly('name');
        Todo::create([
            'name' => $this->name,
        ]);
        $this->reset();
        session()->flash("success", "New item added successfully");
    }

    public function toggle(Todo $todo)
    {
        $todo->update([
            "completed" => !$todo->completed
        ]);
    }

    public function update(Todo $todo)
    {
        $this->validateOnly('editNewName');
        $todo->update([
            "name" => $this->editNewName
        ]);
        $this->editTodoId = '';
    }

    public function render()
    {
        // "%{$this->search}%" called wildcard srarch like in sql.
        $todos = Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5);
        return view('livewire.todo-list', [
            'todos' => $todos
        ]);
    }
}
