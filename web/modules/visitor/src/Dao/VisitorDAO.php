<?php

namespace Drupal\visitor\Dao;

use Drupal\Core\Database\Database;

class VisitorDAO{

    public static function getAll(){
        $conn = Database::getConnection();
        $result = $conn->query('select * from visitantes;')->fetchAll();
        return $result;
    }

  public static function get($id) {
    $conn = Database::getConnection();
    $result = $conn->query('select * from visitantes where id  = :id', array(':id' => $id))->fetchObject();
    return $result;
  }


  public static function add($nombres, $apellidos, $email, $telefono, $genero, $ciudad,$pais,$vieneDe,$tipoIdentificacion,$tipoParticipante){
    $conn = Database::getConnection();
    $conn->insert('visitantes')->fields([
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'email' => $email,
        'telefono' => $telefono,
        'genero' => $genero,
        'ciudad' => $ciudad,
        'pais' => $pais,
        'vieneDe' => $vieneDe,
        'tipoIdentificacion' => $tipoIdentificacion,
        'tipoParticipante' => $tipoParticipante
      ]
    )->execute();
  }

  public static function update($id, $nombres, $apellidos, $email, $telefono, $genero, $ciudad,$pais,$vieneDe,$tipoIdentificacion,$tipoParticipante) {
    $conn = Database::getConnection();
    $conn->update('visitantes')->fields(
      array(
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'email' => $email,
        'telefono' => $telefono,
        'genero' => $genero,
        'ciudad' => $ciudad,
        'pais' => $pais,
        'vieneDe' => $vieneDe,
        'tipoIdentificacion' => $tipoIdentificacion,
        'tipoParticipante' => $tipoParticipante
      )
    )->condition('id', $id, '=')->execute();

  }

  public static function delete($id) {
    $conn = Database::getConnection();
    $conn->delete('visitantes')->condition('id', $id, '=')->execute();
  }
}
