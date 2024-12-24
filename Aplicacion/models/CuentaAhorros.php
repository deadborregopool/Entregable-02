<?php
class CuentaAhorros {
    public $id_usuario;
    public $numero_cuenta;
    public $saldo;

    public function __construct($id_usuario, $numero_cuenta, $saldo = 0.00) {
        $this->id_usuario = $id_usuario;
        $this->numero_cuenta = $numero_cuenta;
        $this->saldo = $saldo;
    }
}
?>
