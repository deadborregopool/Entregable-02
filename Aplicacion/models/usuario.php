<?php
class Usuario {
    public $nombre;
    public $email;
    public $clave;

    public function __construct($nombre, $email, $clave) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->clave = password_hash($clave, PASSWORD_DEFAULT); // Hashea la contraseña
    }
}
?>
