<?php
/* =========================================================
 * @utor:Juan Luis Garcia Corrales                         |
 * email: juanluis.garcia@junglacode.org                   |
 * web: junglacode.org                                     |
 * Avatar: Monolinux                                      |
 * Skype:  monounix                                       |  
 * ===============================================================
 * Archivo sistemaSeguridad.php                                 |
 * Fecha: 06-02-2014                                            |
 * Clase que se conecta ala base de datos para validar accesos  |
 * y extraer informacion para proveer de accesos alos usuarios  |
 * y poder ingresar dentro del sistema                         |
 * ===============================================================*/
require_once('../modelos/conexionMysql.php');
class sistemaSeguridad extends conexionMysql {
    //variables que sirven para el envio de la información
    public $_CREDENCIAL = array(); //arreglo donde van todas las variables para cada modulo
    private $_PASSWORD=null;
    private $_USUARIO=null;
/********************************************************/
    public function verificarAcceso() {       
        $identificacion = parent::getClavesSeguridad("SELECT usuario_identificacion as user ,password_identificacion as pass , candado_identificacion as candado from jc_identificaciones where usuario_identificacion = '$this->_USUARIO'"); 
        if ($identificacion) { // if1 existe un registro
                if($identificacion['candado']!=0){//if2 verificar si el usuario esta deshabilitado 
                     if (!array_key_exists($this->_USUARIO, $identificacion)) {//if3
          $acceso = (strcmp($identificacion['pass'],$this->_PASSWORD) == 0) ? 1 : 0; ////compara con el password con el sistema cryp
         /*si es 1 si es el password si es 0  no es password*/ }//if3
            else{/*elseif3*/$acceso=11;/*elseif3*/} }//if2
             else{/*elseif2*/$acceso = 777;/*elseif2*/}/*esta deshabilatado el usuario if1*/}
                    else {/*elseif1*/ $acceso = 666;/*elseif1*/}//no existe registro   
        return $acceso;
    } // funcion que valida los datos del usuario para que pueda acceder ala aplicación


     public function seguridadPassword($password,$datetime){
       return crypt($password,$this->giveHash($datetime));
   }//fin de la funcion encriptaPassword


   private function giveHash($datetime){ //funcion que nos permitira obtener el hash apartir del dia que se dio de alta
        $semilla = 33;//este numero es para que se puedan visualizar un caracter y no arroje datos erroneos
        list($fecha,$tiempo) = explode(" ", $datetime);
        list($año,$mes,$dia) = explode("-",$fecha);
        $sf= (int)(($año/($dia+$mes)));//evitamos que existan numeros decimales
        list($hora,$minutos,$segundos) = explode(":",$tiempo);
        $st=(($hora-$segundos)+($minutos+$semilla));
        return $hash = chr($st).chr($sf);//genera la semilla convirtiendolo en un asccii
    }//fin de la funcion giveHash
    
   private function recordarPassword($cookie){
   list($machine,$usuario,$password) = explode("%",$cookie);
   if(strcmp(gethostbyaddr($_SERVER['REMOTE_ADDR']),$machine)==0){//verificar si son la misma maquina
   $centinela = $password;}//listos para ser puestos en la interface
   else{$centinela=29;}/*posiblesuplantaciondeidentidad*/
   return $centinela;
}//-----> fin del autologin
    
    public function existeCookie($usuario,$cookie,$password){
     $this->_USUARIO= $usuario;//se iniciliza las variables globales
    $identificacion = parent::getClavesSeguridad("SELECT cookie_identificacion as cookie, fecha_identificacion  as fecha from jc_identificaciones where usuario_identificacion = '$usuario'");
    if($identificacion['cookie']==1){
       $this->_PASSWORD = $this->recordarPassword($cookie);//el password lo saca de la cookie
    }//verificar si tiene una cookie
    else{ 
     $this->_PASSWORD=$this->seguridadPassword($password,$identificacion['fecha']);/*saca el password de un hast cryp*/}
    }//fin de la funcion cookies
    

public function administracionCookies($usuario,$password,$checkbox){
    if($flag==1){
    $cookie = gethostbyaddr($_SERVER['REMOTE_ADDR'])."%".$usuario.'%'.$password.'%'.md5(uniqid(rand(), true));//creaelidunicoparalacookie
    setcookie('automatico',$cookie, time()+604800,'/');
    parent::ejecutaConsulta($consulta);
    /*creaunacookieentucomputador*/}
    else{unset($_COOKIE['automatico']);}
     }//findecrearcookies
     
  public function generaCredencial($usuario) {
   $datos= parent::getClavesSeguridad("SELECT r.pk_id_rol as privilegio,i.pk_id_identificacion as usuario ,c.foto_credencial as foto,
c.nombre_credencial as nombre,p.nombre_perfil as perfil from jc_roles as r inner join jc_perfiles as p inner join jc_identificaciones as i inner join jc_credenciales as c on r.pk_id_rol = p.fk_roles_perfiles and  
p.pk_id_perfil = i.fk_perfiles_identificaciones and i.pk_id_identificacion = c.fk_identificaciones_credenciales where i.usuario_identificacion ='$usuario'");
        $this->_CREDENCIAL['privilegio']=$datos['privilegio'];//dato para saber aque modulos puede entrar y aque no
        $this->_CREDENCIAL['usuario']=$datos['usuario'];//el id del usuario el cual identificara en todo el trayecto del sistema
        $this->_CREDENCIAL['foto']=$datos['foto'];//fotografia del usuario
        $this->_CREDENCIAL['nombre']=$datos['nombre'];//nombre del usuario
        $this->_CREDENCIAL['perfil']=$datos['perfil'];//puesto del usuario
    }//generaPrivilegios Extrae toda la informacion necesaria para evaluar sus acceso
    


    public function __destruct() {
        $this->desconectaConexion();
    }//fin de la funcion desconectar sistema
    

}

//fin de la clase
