<?php

namespace Drupal\visitor\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\visitor\Dao\VisitorDAO;

class VisitorUpdateForm extends FormBase
{

	protected $id;

	function getFormID() {
		return 'bd_visitor_update';
	}

	function buildForm(array $form, FormStateInterface $form_state, $id = '') {
		$this->id = $id;
    $visitor = VisitorDAO::get($id);

    $form['nombres'] = array(
      '#type' => 'textfield',
      '#title' => t('Nombre(s)'),
      '#default_value' => $visitor->nombres
    );
    $form['apellidos'] = array(
      '#type' => 'textfield',
      '#title' => t('Apellidos'),
      '#default_value' => $visitor->apellidos
    );
    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('Email'),
      '#default_value' => $visitor->email
    );
    $form['telefono'] = array(
      '#type' => 'textfield',
      '#title' => t('Telefono'),
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
      '#default_value' => $visitor->genero
    ];
    $form['ciudad'] = array(
      '#type' => 'textfield',
      '#title' => t('Ciudad'),
      '#default_value' => $visitor->ciudad
    );
    $form['vieneDe'] = array(
      '#type' => 'textfield',
      '#title' => t('Empresa o institución'),
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
      '#default_value' => $visitor->tipoParticipante
    ];

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
        $form_state->setRedirect('visitorList');
        return;
      }

	    if (strlen($form_state->getValue('nombres')) <= 0) {
            $form_state->setErrorByName('nombres', $this->t('Please enter titulo'));
        }
    }

	function submitForm(array &$form, FormStateInterface $form_state) {

    $input = $form_state->getUserInput();

    if (isset($input['op']) && $input['op'] === 'Cancel') {
      $form_state->setRedirect('visitorList');
      return;
    }

    $nombres = $form_state->getValue('nombres');
    $apellidos = $form_state->getValue('apellidos');
    $email = $form_state->getValue('email');
    $telefono = $form_state->getValue('telefono');
    $genero = $form_state->getValue('genero');
    $ciudad = $form_state->getValue('ciudad');
    $pais = $form_state->getValue('pais');
    $vieneDe = $form_state->getValue('vieneDe');
    $tipoIdentificacion = $form_state->getValue('tipoIdentificacion');
    $tipoParticipante = $form_state->getValue('tipoParticipante');

		VisitorDAO::update(
		  $this->id,
      Html::escape($nombres),
      Html::escape($apellidos),
      Html::escape($email),
      Html::escape($telefono),
      Html::escape($genero),
      Html::escape($ciudad),
      Html::escape($pais),
      Html::escape($vieneDe),
      Html::escape($tipoIdentificacion),
      Html::escape($tipoParticipante));

    \Drupal::messenger()->addMessage("Visitor updated.");
		$form_state->setRedirect('visitorList');
	}
}
