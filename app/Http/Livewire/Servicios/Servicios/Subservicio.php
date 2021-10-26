<?php

namespace App\Http\Livewire\Servicios\Servicios;

use App\Servicios\Subservice;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Subservicio extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarSubServicio'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'subservices.id';
    public $orderAsc       = true;
    public $estado         = 'activo';


    public function render()
    {
         $data = Subservice::join('services', 'subservices.service_id','=','services.id')
                ->where(function($query){
                    $query->where('subservices.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('services.nombre', 'like', '%' . $this->search . '%');
                })
                ->select('subservices.*','services.nombre as servicio')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
           // dd($data);
        return view('livewire.servicios.servicios.subservicio',compact('data'));
    }


    public function sortBy($field)
    {
        if ($this->orderBy === $field) {
            $this->orderAsc = !$this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $field;
    }

    public function estadochange($id)
    {
 
        $estado = Subservice::find($id);
        $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
        $estado->save();
 
         $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);
 
    }


    public function editSubservice($id){

        return redirect()->to("servicios/subservicios?subservices={$id}");

    }

    public function eliminarSubServicio($id)
    {
        $c = Subservice::find($id);
        $c->delete();
        $this->emit('info',['mensaje' => 'Servicio Eliminada Correctamente']);
    }



}
