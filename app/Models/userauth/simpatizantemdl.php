<?php

namespace App\Models\userauth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;

class simpatizantemdl extends Model
{
protected $table = 'militantes.simpatizantes';
    protected $primaryKey = 'id';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = ['id', 'id_persona', 'id_tipo_simpatizante', 'id_usercreate', 'id_userupd', 'fe_usercreate', 'fe_userupd', 'id_confirmante', 'id_verificador', 'id_status', 'de_observ', 'id_user', 'id_pensa_politico'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fecha = time(); // Establecer la fecha actual en formato timestamp
    }   
}
