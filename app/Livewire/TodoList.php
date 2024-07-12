<?php

namespace App\Livewire;

use App\Models\Todo;

use Livewire\Attributes\Validate;
use Livewire\Component;

class TodoList extends Component
{
    #[Validate("required|min:5|max:250")]
    public $name = '';
    public function create(){
        $this -> validate();
        Todo::create([
            'name'=> $this -> name,
        ]);
        $this -> reset();
        session() -> flash("success", "New item added successfully");
    }
    public function render()
    {
        $todos = Todo::latest()->get();
        return view('livewire.todo-list', [
            'todos'=> $todos
        ]);
    }
}
