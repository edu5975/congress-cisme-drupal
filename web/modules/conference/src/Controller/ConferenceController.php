<?php

namespace Drupal\conference\Controller;

use Drupal\conference\Dao\ConferenceDAO;

class ConferenceController
{
  public function listConference(){
    return[
      '#title' => 'Información de conferencias y talleres',
      '#theme' => 'conference-list',
      '#conference_list' => ConferenceDAO::getAll(),
        '#conference_add' => \Drupal::currentUser()->hasPermission('conference add'),
        '#conference_update' => \Drupal::currentUser()->hasPermission('conference update'),
        '#conference_delete' => \Drupal::currentUser()->hasPermission('conference delete')
    ];
  }

    public function listProgram(){
        return[
            '#title' => 'Programa',
            '#theme' => 'program-list',
            '#program_list' => ConferenceDAO::getAll(),
            '#program_days' => ConferenceDAO::getDay()
        ];
    }
}
