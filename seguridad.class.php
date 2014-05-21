<?php
require_once 'terminator.inc.php';
require_once 'configuracion.php';
class AccesoSistema extends T800{

        public function validacionDatos($usuario,$password)
        {              
                $this->_USUARIO=$usuario;
                $this->_PASSWORD=$password;
                $this->generaSession(parent::verificarAcceso(),$this->_USUARIO);
            
        }//fin de la funcion
        
        public function verificacionPassword($usuario,$password)
        {              
                $this->_USUARIO=$usuario;
                $this->_PASSWORD=$password;
                return parent::verificarAcceso();//implementacion para la actualizacion de password
            
        }//fin de la funcion

        private function generaSession($flag,$usuario)
        {
            if ($flag== 1)
                {
                 session_start();//crea la variable para estar activo siempre en el sistema  
                 $_SESSION['globales']=parent::setsessionGlobals($usuario);//clave,user,hash
                 $_SESSION['llavero']=parent::administracionPassword($usuario);//sessiones de llavero
                 echo $flag;
                }
                else
                     {
                      echo $flag; 
                     }
        }//fin de la funcion generar Session
        
        public function generaCredencial($usuario)
        {
            $credencial= array();//crea los servicios
            parent::ejecutaConsultas("SELECT r.nombre_rol as privilegio,i.pk_id_identificacion as usuario ,c.foto_credencial as foto,c.nombre_credencial as nombre,
                p.nombre_perfil as perfil from jc_roles as r inner join jc_perfiles as p inner join jc_identificaciones as i inner join jc_credenciales as c on r.pk_id_rol = p.fk_id_roles_perfiles 
                and  p.pk_id_perfil = i.fk_id_perfiles_identificaciones and 
                i.pk_id_identificacion = c.fk_identificaciones_credenciales where i.usuario_identificacion ='$usuario';");
            $datos = $this->_QUERY->fetch();
            $credencial['privilegio']=$datos['privilegio'];//dato para saber aque modulos puede entrar y aque no
            $credencial['id']=$datos['usuario'];//el id del usuario el cual identificara en todo el trayecto del sistema
            $credencial['foto']=$datos['foto'];//fotografia del usuario
            $credencial['nombre']=$datos['nombre'];//nombre del usuario
            $credencial['puesto']=$datos['perfil'];//puesto del usuario*/
            return $credencial;//la credencial ya esta hecha
        }//generaPrivilegios Extrae toda la informacion necesaria para evaluar sus acceso version beta
                
        public function tienePrivilegio($listaccesos ,$privilegio)
        {//esta funcion debe tener las siguiente sintaxis "root-sysadmin-admin"
            if(strcmp($listaccesos,'*')!=0)
            {
            $flag=false;
            $index = 0;
            $config =  new Config_Ini();
            $accesos = explode('-',$listaccesos);
            while ($index < count($accesos) && !$flag): 
                    $flag = (strcmp($accesos[$index], $privilegio)==0) ? $flag=TRUE : $flag=FALSE;
                    $index++;
            endwhile;//verificamos si existe privilegio
             if(!$flag)
                {
                   header("Location: ../vistas/".$config->getsinPrivilegio());
                   exit;
                }//dame el acceso
            }//comodin de accesos
        }//fin de la funcion verificaPrivilegio
        
        
        public function permiteAcceso($listapuestos,$puesto,$accion,$consecuencia="")
        {
            if(strcmp($listapuestos,'*')!=0)
            {        
            $flag=false;
            $index = 0;
            $accesos = explode('-',$listapuestos);
            while ($index < count($accesos) && !$flag): 
                    $flag = (strcmp($accesos[$index], $puesto)==0) ? $flag=TRUE : $flag=FALSE;
                    $index++;
            endwhile;//verificamos si existe privilegio
             if($flag)
                {
                  return $accion;
                }//dame el acceso
                else
                    {
                    return $consecuencia;
                    }
            }//comodin de accesos
            else
                {
                return $accion;
                }
        }//fin del perimte

        public function verificaSession($session)
        {
           $config =  new Config_Ini();
                if(is_null($session))
                 {
                    header("Location: ../vistas/".$config->getsinAcceso());
                     exit;
                 }
        }//fin verifica session

        public function cerrarSesion()
        {
            session_destroy();
        }
        
        public function __destruct() {
            parent::terminarConexion();
        }

}//fin de la clase

?>