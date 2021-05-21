<?php

namespace Drupal\conference\Dao;

use Drupal\Core\Database\Database;

class ConferenceDAO{

    public static function getAll(){
        $conn = Database::getConnection();
        $result = $conn->query('select * from conferencias order by fecha,hora;')->fetchAll();
        return $result;
    }

  public static function get($id) {
    $conn = Database::getConnection();
    $result = $conn->query('select * from conferencias where id  = :id', array(':id' => $id))->fetchObject();
    return $result;
  }

  public static function getDay() {
        $conn = Database::getConnection();
        $result = $conn->query('select fecha from conferencias group by fecha order by fecha;')->fetchAll();
        return $result;
  }

  public static function add($titulo, $resumen, $fecha, $lugar, $hora, $nombreConferencista,$cvConferensista){
    $conn = Database::getConnection();
    $conn->insert('conferencias')->fields([
        'titulo' => $titulo,
        'resumen' => $resumen,
        'fecha' => $fecha,
        'lugar' => $lugar,
        'hora' => $hora,
        'nombreConferencista' => $nombreConferencista,
        'cvConferencista' => $cvConferensista
      ]
    )->execute();
  }

  public static function update($id, $titulo, $resumen, $fecha, $lugar, $hora, $nombreConferencista,$cvConferensista) {
    $conn = Database::getConnection();
    $conn->update('conferencias')->fields(
      array(
        'titulo' => $titulo,
        'resumen' => $resumen,
        'fecha' => $fecha,
        'lugar' => $lugar,
        'hora' => $hora,
        'nombreConferencista' => $nombreConferencista,
        'cvConferencista' => $cvConferensista
      )
    )->condition('id', $id, '=')->execute();

  }

  public static function delete($id) {
    $conn = Database::getConnection();
    $conn->delete('conferencias')->condition('id', $id, '=')->execute();
  }
}
