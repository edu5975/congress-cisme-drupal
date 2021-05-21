<?php

namespace Drupal\visitor\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\visitor\Dao\VisitorDAO;

class VisitorDeleteForm extends ConfirmFormBase {

  protected $id;

  function getFormID() {
    return 'bd_visitor_delete';
  }

  function getQuestion() {
    return t('¿Seguro de querer eliminar registro con id %id?', array('%id' => $this->id));
  }

  function getConfirmText() {
    return t('Eliminar');
  }

  function getCancelUrl() {
    return new Url('visitorList');
  }

  function buildForm(array $form, FormStateInterface $form_state, $id = '') {
    $this->id = $id;
    $visitor = VisitorDAO::get($id);

    $form['nombres'] = array(
      '#type' => 'textfield',
      '#title' => t('Nombre(s)'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $visitor->nombres
    );
    $form['apellidos'] = array(
      '#type' => 'textfield',
      '#title' => t('Apellidos'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $visitor->apellidos
    );
    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('Email'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $visitor->email
    );
    $form['telefono'] = array(
      '#type' => 'textfield',
      '#title' => t('Telefono'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $visitor->telefono
    );
    $form['genero'] = [
      '#type' => 'select',
      '#title' => t('Genero'),
      '#options' => [
        'H' => $this->t('Hombre'),
        'M' => $this->t('Mujer'),
        'N' => $this->t('No definido'),
      ],
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $visitor->genero
    ];
    $form['ciudad'] = array(
      '#type' => 'textfield',
      '#title' => t('Ciudad'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $visitor->ciudad
    );
    $form['vieneDe'] = array(
      '#type' => 'textfield',
      '#title' => t('Empresa o institución'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $visitor->vieneDe
    );
    $form['tipoIdentificacion'] = [
      '#type' => 'select',
      '#title' => t('Tipo de identificación'),
      '#options' => [
        '1' => $this->t('INE'),
        '2' => $this->t('Pasaporte'),
        '3' => $this->t('Cedula'),
      ],
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $visitor->tipoIdentificacion
    ];
    $form['tipoParticipante'] = [
      '#type' => 'select',
      '#title' => t('Tipo de participante'),
      '#options' => [
        '1' => $this->t('Participante'),
        '2' => $this->t('Conferencista'),
        '3' => $this->t('Invitado especial'),
      ],
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $visitor->tipoParticipante
    ];

    return parent::buildForm($form, $form_state);
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    VisitorDAO::delete($this->id);
    \Drupal::messenger()->addMessage("Visitor deleted.");
    $form_state->setRedirect('visitorList');
  }
}
