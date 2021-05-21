<?php


namespace Drupal\hotel\Dao;

use Drupal\Core\Database\Database;

class HotelDao
{


  public static function getHotels()
  {
    $conn = Database::getConnection();
    return $conn->query('select * from hoteles')->fetchAllAssoc('id');
  }

  public static function getHotel($id)
  {
    $conn = Database::getConnection();
    return $conn->query('select * from hoteles where id = :id',array(':id' => $id))->fetchObject();
  }



  public static function update($id, $name,$location,$phone,$price,$latitude,$longitude) {
    $conn = Database::getConnection();
    $conn->update('hoteles')->fields(
      array(
        'nombre' => $name,
          'direccion' => $location,
          'telefono' => $phone,
          'costoHabitacion' => $price,
          'latitud' => $latitude,
          'longitud' => $longitude
      )
    )->condition('id', $id, '=')->execute();

  }

  public static function delete($id) {
    $conn = Database::getConnection();
    $conn->delete('hoteles')->condition('id', $id, '=')->execute();
  }

    public static function  add($name,$location,$phone,$price,$latitude,$longitude)
    {
        $conn = Database::getConnection();
        $conn -> insert('hoteles')->fields(
            [
                'nombre'=> $name,
                'direccion'=>$location,
                'telefono'=>$phone,
                'costoHabitacion'=>$price,
                'latitud'=>$latitude,
                'longitud'=>$longitude
            ]
        )->execute();
    }
}
