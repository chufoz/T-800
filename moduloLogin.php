<?php
include_once '../controladores/sistemaSeguridad.php';
$seguridad = new sistemaSeguridad();
/*como usar la funcion para encriptar datos*/
echo $encriptacion = $seguridad->seguridadPassword("d3str1pad0r060","2014-02-09 14:30:11")."--> encriptaremos el password apartir de un fecha <br>";
// esto es un bloque
$seguridad->existeCookie('@monolinux',null ,'crisis');
    /*para esto se debe tener el campo cookie_identificacion de la tabla jc_identificaciones debe ser 0*/
  echo $seguridad->verificarAcceso()." no existe una cookie y el password es incorrecto <br>";
  // fin del bloque
  // esto es un bloque
$seguridad->existeCookie('@monolinux',null ,'d3str1pad0r060');
    /*para esto se debe tener el campo cookie_identificacion de la tabla jc_identificaciones debe ser 0*/
  echo $seguridad->verificarAcceso()." no existe una cookie y el password es correcto <br>";
  // fin del bloque
  
 // las siguientes instrucciones es para poder sacar informacion dentro de la cookie
  $seguridad->crearCookies('@monolinux', $seguridad->seguridadPassword("d3str1pad0r060","2014-02-09 14:30:11"));
  echo $_COOKIE['automatico']."---> equi esta ya la cookie creada <br>";
  // primero actualizamos el campo cookie_idetificacion UPDATE `bd_erp`.`jc_identificaciones` SET `cookie_identificacion`='1' WHERE `pk_id_identificacion`='1';
   $seguridad->existeCookie('@monolinux',$_COOKIE['automatico'] ,'d3str1pad0r');
   echo $seguridad->verificarAcceso()."Los datos son correctos <br>"; //datos correctos
// para esta prueba se necesita actualizar el campo candado_identificacion 
 $seguridad->existeCookie('@monolinux',$_COOKIE['automatico'] ,'d3str1pad0r');
   echo $seguridad->verificarAcceso()."Isuario deshabilitado <br>"; //datos correctos
   $seguridad->generaCredencial('@monolinux');
   var_dump($seguridad->_CREDENCIAL);
   unset($_COOKIE["id_extreme"]);
   var_dump($_COOKIE);
        