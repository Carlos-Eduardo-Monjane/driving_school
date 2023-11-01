<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function entityFields()
    {
        return [
            [
                'label' => 'Nome completo',
                'name' => 'full_name',
                'attributes' => 'required'
            ],
            [
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email'
            ],
            [
                'label' => 'Número de B.I',
                'name' => 'nic',
                'attributes' => 'required'
            ],
            [
                'label' => 'Naturalidade',
                'name' => 'address_nic'
            ],
            [
                'label' => 'Endereço residencial',
                'name' => 'address'
            ],
            [
                'label' => 'Carta de condução',
                'name' => 'carta',
                'type' => 'select',
                'selectOptions' => TipoCartaConducao::all(),
                'attributes' => 'required'
            ],
            
            [
                'label' => 'Telefone',
                'name' => 'phone_num'
            ],
            [
                'label' => 'Profissão',
                'name' => 'profession'
            ],
            [
                'label' => 'Observações',
                'name' => 'address_bus'
            ],
        ];
    }

    public static function datatables()
    {
    return DataTable::of(self::query())
        ->addColumn('carta', function (Customer $customer) {
            return $customer->tipoCartaConducao->name;
        })
        ->make(true);
    }


    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function tipoCartaConducao()
    {
        return $this->belongsTo(TipoCartaConducao::class, 'carta');
    }
    

}
