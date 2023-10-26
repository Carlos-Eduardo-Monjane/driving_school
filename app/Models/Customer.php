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
                'label' => 'Endereço do negócio',
                'name' => 'address_bus'
            ],
            [
                'label' => 'Profissão',
                'name' => 'profession'
            ],
            [
                'label' => 'Telefone',
                'name' => 'phone_num'
            ],
        ];
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
