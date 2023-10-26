<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    protected $table = 'guaranters';

    use HasFactory;

    public static function entityFields()
    {
        return [
            [
                'label' => 'Nome completo',
                'name' => 'full_name',
                'attributes' => ''
            ],
            [
                'label' => 'Profissão',
                'name' => 'profession',
                'attributes' => ''
            ],
            [
                'label' => 'Número de B.I',
                'name' => 'nic',
                'attributes' => ''
            ],
            [
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
                'attributes' => ''
            ],
            [
                'label' => 'Address',
                'name' => 'address',
                'attributes' => ''
            ],
            [
                'label' => 'Telefone',
                'name' => 'phone_num',
                'attributes' => ''
            ],
        ];
    }
}
