<?php

namespace Drupal\conference\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\conference\Dao\ConferenceDAO;

class ConferenceAddForm extends FormBase
{

	function getFormID() {
		return 'bd_conference_add';
	}

	function buildForm(array $form, FormStateInterface $form_state, $extra=null) {
		$form['titulo'] = array(
		  '#type' => 'textfield',
		  '#title' => t('Titulo')
		);
		$form['resumen'] = array(
		  '#type' => 'textarea',
		  '#title' => t('Resumen'),
		);
    $form['fecha'] = array(
      '#type' => 'date',
      '#title' => t('Fecha'),
    );
    $form['lugar'] = array(
      '#type' => 'textfield',
      '#title' => t('Lugar'),
    );
    $form['hora'] = array(
      '#type' => 'textfield',
      '#title' => t('Hora'),
    );
    $form['nombreConferencista'] = array(
      '#type' => 'textfield',
      '#title' => t('Nombre del conferencista'),
    );
    $form['cvConferencista'] = array(
      '#type' => 'textarea',
      '#title' => t('Resumen CV del conferencista'),
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
      $form_state->setRedirect('conferenceList');
      return;
    }

    if (strlen($form_state->getValue('titulo')) <= 0) {
      $form_state->setErrorByName('question', $this->t('Please enter question'));
    }

	}

	function submitForm(array &$form, FormStateInterface $form_state) {

    $input = $form_state->getUserInput();

    if (isset($input['op']) && $input['op'] === 'Cancelar') {
      $form_state->setRedirect('conferenceList');
      return;
    }

		$titulo = $form_state->getValue('titulo');
    $resumen = $form_state->getValue('resumen');
    $fecha = $form_state->getValue('fecha');
    $lugar = $form_state->getValue('lugar');
    $hora = $form_state->getValue('hora');
    $nombreConferencista = $form_state->getValue('nombreConferencista');
    $cvConferencista = $form_state->getValue('cvConferencista');

    ConferenceDAO::add(Html::escape($titulo),
      Html::escape($resumen),
      Html::escape($fecha),
      Html::escape($lugar),
      Html::escape($hora),
      Html::escape($nombreConferencista),
      Html::escape($cvConferencista));

    \Drupal::messenger()->addMessage("Conferencia añadida.");
		$form_state->setRedirect('conferenceList');
		return;
	}
}
