<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Models\Tarea;
use Livewire\Component;

class DeleteTarea extends Component
{
    public $tareaID,$modalDelete=false;
    public  $tName;
    public $ticketID;

    public function ConfirmDelete($id){
        $supplier=Tarea::find($id);
        $this->ticketID=$supplier->ticket_id;
        $this->tName= $supplier->id;
        $this->modalDelete=true;
    }
    public function DeleteTarea($id){
        $supplierDel=Tarea::find($id);
        $supplierDel->delete();
        $supplierDel->save();
        return redirect()->route('tck.tarea', ['id' => $this->ticketID]);
    }
    public function render()
    {
        return view('livewire.tickets.tareas.delete-tarea');
    }
}
