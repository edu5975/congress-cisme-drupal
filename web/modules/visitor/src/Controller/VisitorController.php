<?php

namespace Drupal\visitor\Controller;

use Drupal\visitor\Dao\VisitorDAO;

class VisitorController
{
  public function listVisitor(){
      if(\Drupal::currentUser()->hasPermission('visitor update')){
          return[
              '#title' => 'Información de los visitantes',
              '#theme' => 'visitor-list',
              '#visitor_list' => VisitorDAO::getAll()
          ];
      }
      header('Location: /visitor/add');
      exit;
  }
}
