<?php

namespace Drupal\hotel\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\hotel\Dao\HotelDao;

class HotelUpdateForm2 extends FormBase
{

	protected $id;

	function getFormID() {
		return 'bd_hotel_update';
	}

	function buildForm(array $form, FormStateInterface $form_state, $id = '') {
		$this->id = $id;
        $hotel = HotelDao::getHotel($id);

		$form['name'] = array(
		  '#type' => 'textfield',
		  '#title' => t('Nombre'),
		  '#default_value' => $hotel->nombre,
		);

        $form['location'] = array(
            '#type' => 'textfield',
            '#title' => t('Ubicación'),
            '#default_value' => $hotel->direccion,
        );

        $form['phone'] = array(
            '#type' => 'textfield',
            '#title' => t('Telefono'),
            '#default_value' => $hotel->telefono,
        );

        $form['price'] = array(
            '#type' => 'textfield',
            '#title' => t('Precio'),
            '#default_value' => $hotel->costoHabitacion,
        );

        $form['latitude'] = array(
            '#type' => 'textfield',
            '#title' => t('Latitud'),
            '#default_value' => $hotel->latitud,
        );

        $form['longitude'] = array(
            '#type' => 'textfield',
            '#title' => t('Longitud'),
            '#default_value' => $hotel->longitud,
        );

		$form['actions'] = array('#type' => 'actions');

		$form['actions']['submit'] = array(
		  '#type' => 'submit',
		  '#value' => t('Guardar'),
		);

        $form['actions']['cancel'] = array(
            '#type' => 'submit',
         '#value' => 'Cancelar',
         );
		return $form;
	}

	function validateForm(array &$form, FormStateInterface $form_state) {
      $input = $form_state->getUserInput();

      if (isset($input['op']) && $input['op'] === 'Cancelar') {
        $form_state->setRedirect('hotel');
        return;
      }

	    if (strlen($form_state->getValue('name')) <= 0) {
            $form_state->setErrorByName('name', $this->t('Por favor ingresa el nombre'));
        }
        if (strlen($form_state->getValue('location')) <= 0) {
            $form_state->setErrorByName('location', $this->t('Por favor ingresa la ubicacion'));
        }
        if (strlen($form_state->getValue('phone')) <= 0) {
            $form_state->setErrorByName('phone', $this->t('Por favor ingresa el telefono'));
        }
        if (strlen($form_state->getValue('price')) <= 0) {
            $form_state->setErrorByName('price', $this->t('Por favor ingresa el costo'));
        }
        if (strlen($form_state->getValue('latitude')) <= 0) {
            $form_state->setErrorByName('latitude', $this->t('Por favor ingresa la latitud'));
        }
        if (strlen($form_state->getValue('longitude')) <= 0) {
            $form_state->setErrorByName('longitude', $this->t('Por favor ingresa la longitud'));
        }


    }


	function submitForm(array &$form, FormStateInterface $form_state) {

    $input = $form_state->getUserInput();

    if (isset($input['op']) && $input['op'] === 'Cancelar') {
      $form_state->setRedirect('hotel');
      return;
    }

		$name = $form_state->getValue('name');
        $location = $form_state->getValue('location');
        $phone = $form_state->getValue('phone');
        $price = $form_state->getValue('price');
        $latitude = $form_state->getValue('latitude');
        $longitude = $form_state->getValue('longitude');
		HotelDao::update($this->id,
            Html::escape($name),
            Html::escape($location),
            Html::escape($phone),
            Html::escape($price) ,
            Html::escape($latitude),
            Html::escape($longitude));

    \Drupal::messenger()->addMessage("Hotel updated.");
		$form_state->setRedirect('hotel');
}
}
