<?php

namespace Drupal\conference\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\conference\Dao\ConferenceDAO;

class ConferenceDeleteForm extends ConfirmFormBase {

  protected $id;

  function getFormID() {
    return 'bd_conference_delete';
  }

  function getQuestion() {
    return t('¿Seguro de querer eliminar registro con id %id?', array('%id' => $this->id));
  }

  function getConfirmText() {
    return t('Eliminar');
  }

  function getCancelUrl() {
    return new Url('conferenceList');
  }

  function buildForm(array $form, FormStateInterface $form_state, $id = '') {
    $this->id = $id;
    $conference = ConferenceDAO::get($id);

    $form['titulo'] = array(
      '#type' => 'textfield',
      '#title' => t('Titulo'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $conference->titulo
    );
    $form['resumen'] = array(
      '#type' => 'textarea',
      '#title' => t('Resumen'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $conference->resumen
    );
    $form['fecha'] = array(
      '#type' => 'date',
      '#title' => t('Fecha'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $conference->fecha
    );
    $form['lugar'] = array(
      '#type' => 'textfield',
      '#title' => t('Lugar'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $conference->lugar
    );
    $form['hora'] = array(
      '#type' => 'textfield',
      '#title' => t('Hora'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $conference->hora
    );
    $form['nombreConferencista'] = array(
      '#type' => 'textfield',
      '#title' => t('Nombre del conferencista'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $conference->nombreConferencista
    );
    $form['cvConferencista'] = array(
      '#type' => 'textfield',
      '#title' => t('Resumen CV del conferencista'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $conference->cvConferencista
    );

    return parent::buildForm($form, $form_state);
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    ConferenceDAO::delete($this->id);
    \Drupal::messenger()->addMessage("Conference deleted.");
    $form_state->setRedirect('conferenceList');
  }
}
