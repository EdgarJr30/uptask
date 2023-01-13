<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];


    //La declaracion de las variables en esta parte al parecer son opcionales, tal vez me marca error por el intelephense
    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $token;
    public $confirmado;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    //Validar el Login de usuarios
    public function validarLogin(): array {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no Valido';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }

        return self::$alertas;
    }

    //Validacion para cuentas nuevas
    public function validarNuevaCuenta(): array {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Usuario es Obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los password son diferentes';
        }

        return self::$alertas;
    }

    //Valida un email
    public function validarEmail(): array {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no Valido';
        }

        return self::$alertas;
    }

    //Valida el password
    public function validarPassword(): array {
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    //Validar el nombre y correo
    public function validar_perfil(): array {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }

        return self::$alertas;
    }

    public function nuevo_password(): array {
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacio';
        }
        if (!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacio';
        }
        if (strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    //Comprobar el password
    public function comprobar_password(): bool {
        return password_verify($this->password_actual, $this->password);
    }

    //Hashear el password
    public function hashPassword(): void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Generar un token
    public function crearToken(): void {
        //Diferentes formas de crear un token
        //Con md5 y pasandole uniqid es mas segura
        //uniqid sola es un poco mas vulnerable, para para un token de uso rapido esta bien
        // $this->token = md5(uniqid());
        $this->token = uniqid();
    }
}
