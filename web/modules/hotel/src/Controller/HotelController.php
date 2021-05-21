<?php

namespace Drupal\hotel\Controller;
use Drupal\hotel\Dao\HotelDao;

class HotelController
{
  public function show()
  {
     return[
    '#title'=>'Lista de Hoteles',
    '#theme'=>'hotel-list',
    '#hotel_list'=> HotelDao::getHotels(),
         '#hotel_add' => \Drupal::currentUser()->hasPermission('hotel add'),
         '#hotel_update' => \Drupal::currentUser()->hasPermission('hotel update'),
         '#hotel_delete' => \Drupal::currentUser()->hasPermission('hotel delete'),
    ];
   }
  }
