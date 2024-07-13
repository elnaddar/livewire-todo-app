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

    public function delete($todoID)
    {
        try {
            $todo = Todo::findOrFail($todoID);
            $todo->delete();
        } catch (\Exception $e) {
            session()->flash("error", "Can't find the todo item.");
            return;
        }

    }

    public function toggleEdit($todoID)
    {
        try {
            $todo = Todo::findOrFail($todoID);
            if ($this->editTodoId != $todo->id) {
                $this->editTodoId = $todo->id;
                $this->editNewName = $todo->name;
            } else {
                $this->editTodoId = '';
                $this->editNewName = '';
            }
        } catch (\Exception $e) {
            session()->flash("error", "Can't find the todo item.");
            return;
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

    public function toggle($todoID)
    {
        try {
            $todo = Todo::findOrFail($todoID);
            $todo->update([
                "completed" => !$todo->completed
            ]);
        } catch (\Exception $e) {
            session()->flash("error", "Can't find the todo item.");
            return;
        }
    }

    public function update($todoID)
    {
        try {
            $todo = Todo::findOrFail($todoID);
            $this->validateOnly('editNewName');
            $todo->update([
                "name" => $this->editNewName
            ]);
            $this->editTodoId = '';
        } catch (\Exception $e) {
            session()->flash("error", "Can't find the todo item.");
            return;
        }
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
