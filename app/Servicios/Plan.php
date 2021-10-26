<?php

namespace App\Servicios;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable =[

        'fecha_vigencia',
        'descripcion',
        'costo',
       ];


       public function tipoplan (){
           return $this->belongsTo('App\Servicios\Tipoplan','tipoplan_id','id');
       }

       public function documento()
       {
           return $this->morphOne('App\Document', 'documentable');
       }


       public function subservicio(){
           return $this->belongsTo('App\Servicios\Subservice');
       }


       public function shops(){
        return $this->hasMany('App\Tienda\Shop');
    }

       public function scopePlanes($query, $id)
       {
           return $query->where('tipoplan_id',$id)->get();
       }

}
