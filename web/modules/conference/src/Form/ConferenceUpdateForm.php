<?php

namespace Drupal\conference\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\conference\Dao\ConferenceDAO;

class ConferenceUpdateForm extends FormBase
{

	protected $id;

	function getFormID() {
		return 'bd_conference_update';
	}

	function buildForm(array $form, FormStateInterface $form_state, $id = '') {
		$this->id = $id;
    $conference = ConferenceDAO::get($id);

    $form['titulo'] = array(
      '#type' => 'textfield',
      '#title' => t('Titulo'),
      '#default_value' => $conference->titulo
    );
    $form['resumen'] = array(
      '#type' => 'textarea',
      '#title' => t('Resumen'),
      '#default_value' => $conference->resumen
    );
    $form['fecha'] = array(
      '#type' => 'date',
      '#title' => t('Fecha'),
      '#default_value' => $conference->fecha
    );
    $form['lugar'] = array(
      '#type' => 'textfield',
      '#title' => t('Lugar'),
      '#default_value' => $conference->lugar
    );
    $form['hora'] = array(
      '#type' => 'textfield',
      '#title' => t('Hora'),
      '#default_value' => $conference->hora
    );
    $form['nombreConferencista'] = array(
      '#type' => 'textfield',
      '#title' => t('Nombre del conferencista'),
      '#default_value' => $conference->nombreConferencista
    );
    $form['cvConferencista'] = array(
      '#type' => 'textfield',
      '#title' => t('Resumen CV del conferencista'),
      '#default_value' => $conference->cvConferencista
    );

		$form['actions'] = array('#type' => 'actions');

		$form['actions']['submit'] = array(
		  '#type' => 'submit',
		  '#value' => t('Save'),
		);
    $form['actions']['cancel'] = array(
      '#type' => 'submit',
      '#value' => 'Cancel',
    );
		return $form;
	}

	function validateForm(array &$form, FormStateInterface $form_state) {
      $input = $form_state->getUserInput();

      if (isset($input['op']) && $input['op'] === 'Cancel') {
        $form_state->setRedirect('conferenceList');
        return;
      }

	    if (strlen($form_state->getValue('titulo')) <= 0) {
            $form_state->setErrorByName('titulo', $this->t('Please enter titulo'));
        }
    }

	function submitForm(array &$form, FormStateInterface $form_state) {

    $input = $form_state->getUserInput();

    if (isset($input['op']) && $input['op'] === 'Cancel') {
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

		ConferenceDAO::update($this->id,
      Html::escape($titulo),
      Html::escape($resumen),
      Html::escape($fecha),
      Html::escape($lugar),
      Html::escape($hora),
      Html::escape($nombreConferencista),
      Html::escape($cvConferencista));

    \Drupal::messenger()->addMessage("Conference updated.");
		$form_state->setRedirect('conferenceList');
	}
}
