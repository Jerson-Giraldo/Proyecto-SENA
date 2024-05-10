<?php
class Cliente extends Orm//la clase Cliente es un modelo que interactua con la base de datos utilizando la clase ORM
{
  public function __construct(PDO $coneccion) //El constructor toma el objeto PDO como parámetro de conexión a la base de datos
  {
    /*Dentro de este constructor Cliente se llama al constructor de la clase Orm se pasan tres parámetros 
    id: esta es la clave primaria en la tabla de la base de datos
    cliente: este es el nombre de la tabla de la base de datos
    $coneccion: este es el objeto PDO que representa la conexión a la base de datos.
    Se pasa al constructor de Orm para permitir que la clase Cliente realice consultas y otras operaciones en la base de datos.*/
    parent::__construct('id', 'cliente', $coneccion); //pasamos los valores de los párametros de la clase padre ORM
  }
}
/*La clase Cliente representa un modelo que interactúa con la base de datos para realizar operaciones relacionadas 
con los clientes. Utiliza la clase Orm como base para manejar la interacción con la base de datos, 
lo que sugiere que sigue un enfoque de mapeo objeto-relacional (ORM) para el acceso a los datos.*/