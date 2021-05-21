<?php

namespace Drupal\hotel\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\hotel\Dao\HotelDao;

class HotelAddForm extends FormBase
{

	function getFormID() {
		return 'bd_hotel_add';
	}

	function buildForm(array $form, FormStateInterface $form_state, $extra=null) {
		$form['name'] = array(
		  '#type' => 'textfield',
		  '#title' => t('Nombre'),
		  //'#value' => $extra,
		);
        $form['location'] = array(
            '#type' => 'textfield',
            '#title' => t('Ubicacion'),
            //'#value' => $extra,
        );
        $form['phone'] = array(
            '#type' => 'textfield',
            '#title' => t('Telefono'),
            //'#value' => $extra,
        );
        $form['price'] = array(
            '#type' => 'textfield',
            '#title' => t('Costo'),
            //'#value' => $extra,
        );
        $form['latitude'] = array(
            '#type' => 'textfield',
            '#title' => t('Latitud'),
            //'#value' => $extra,
        );
        $form['longitude'] = array(
            '#type' => 'textfield',
            '#title' => t('Longitud'),
            //'#value' => $extra,
        );

		$form['actions'] = array('#type' => 'actions');
		$form['actions']['submit'] = array(
		  '#type' => 'submit',
		  '#value' => 'Agregar',
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
      $form_state->setErrorByName('name', $this->t('Por favor ingresa el Nombre'));
    }
        if (strlen($form_state->getValue('location')) <= 0) {
            $form_state->setErrorByName('location', $this->t('Por favor ingresa la Ubicacion'));
        }
        if (strlen($form_state->getValue('phone')) <= 0) {
            $form_state->setErrorByName('phone', $this->t('Por favor ingresa el Telefono'));
        }
        if (strlen($form_state->getValue('price')) <= 0) {
            $form_state->setErrorByName('price', $this->t('Por favor ingresa el Costo'));
        }
        if (strlen($form_state->getValue('latitude')) <= 0) {
            $form_state->setErrorByName('latitude', $this->t('Por favor ingresa la Latitud'));
        }
        if (strlen($form_state->getValue('longitude')) <= 0) {
            $form_state->setErrorByName('longitude', $this->t('Por favor ingresa la Longitud'));
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
		HotelDao::add(Html::escape($name),
                    Html::escape($location),
                    Html::escape($phone),
                     Html::escape($price),
                     Html::escape($latitude),
                     Html::escape($longitude)
        );

    \Drupal::messenger()->addMessage("Hotel agregado.");
		$form_state->setRedirect('hotel');
		return;
	}
}
