<?php

namespace Drupal\hotel\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hotel\Dao\HotelDao;

class HotelDeleteForm extends ConfirmFormBase {

  protected $id;

  function getFormID() {
    return 'bd_hotel_delete';
  }

  function getQuestion() {
    return t('¿Estas seguro de querer eliminar el hotel con id %id?', array('%id' => $this->id));
  }

  function getConfirmText() {
    return t('Eliminar');
  }

  function getCancelUrl() {
    return new Url('hotel');
  }

  function buildForm(array $form, FormStateInterface $form_state, $id = '') {
    $this->id = $id;
    $hotel = HotelDao::getHotel($id);
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Nombre'),
      '#attributes' => array('readonly' => 'readonly'),
      '#default_value' => $hotel->nombre,
    );
      $form['location'] = array(
          '#type' => 'textfield',
          '#title' => t('Ubicacion'),
          '#attributes' => array('readonly' => 'readonly'),
          '#default_value' => $hotel->direccion,
      );
      $form['phone'] = array(
          '#type' => 'textfield',
          '#title' => t('Telefono'),
          '#attributes' => array('readonly' => 'readonly'),
          '#default_value' => $hotel->telefono,
      );
      $form['price'] = array(
          '#type' => 'textfield',
          '#title' => t('Costo'),
          '#attributes' => array('readonly' => 'readonly'),
          '#default_value' => $hotel->costoHabitacion,
      );
      $form['latitude'] = array(
          '#type' => 'textfield',
          '#title' => t('Latitud'),
          '#attributes' => array('readonly' => 'readonly'),
          '#default_value' => $hotel->latitud,
      );
      $form['longitude'] = array(
          '#type' => 'textfield',
          '#title' => t('Longitud'),
          '#attributes' => array('readonly' => 'readonly'),
          '#default_value' => $hotel->longitud,
      );


    return parent::buildForm($form, $form_state);
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    HotelDao::delete($this->id);
    \Drupal::messenger()->addMessage("Hotel deleted.");
    $form_state->setRedirect('hotel');
  }
}
