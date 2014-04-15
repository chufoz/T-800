<?php
require_once 'terminator.inc.php';
class AccesoSistema extends T800{
    private $_NOTACCESS='notautorizacion.html';
    
        public function ValidacionDatos($usuario,$password)
        {  
            $this->_USUARIO=$usuario;
            $this->_PASSWORD=$password;
            $this->generaSession(parent::verificarAcceso(),$this->_USUARIO);
        }//fin de la funcion

        private function generaSession($flag,$usuario)
        {
            if ($flag== 1)
                {
                 session_start();//crea la variable para estar activo siempre en el sistema  
                 $_SESSION['usuario']=$usuario;
                 echo $flag;
                }
                else
                     {
                      echo $flag; 
                     }
        }//fin de la funcion generar Session
    
        public function verificaSession($session)
        {
            if(is_null($session))
            {
                header("Location: $this->_NOTACCESS");
                exit;
            }
        }//fin verifica session

        public function cerrarSesion()
        {
            session_destroy();
        }

}//fin de la clase

?>