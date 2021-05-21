<?php

namespace Drupal\visitor\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\visitor\Dao\VisitorDAO;

class VisitorAddForm extends FormBase
{

	function getFormID() {
		return 'bd_visitor_add';
	}



	function buildForm(array $form, FormStateInterface $form_state, $extra=null) {
		$form['nombres'] = array(
		  '#type' => 'textfield',
		  '#title' => t('Nombre(s)')
		);
    $form['apellidos'] = array(
      '#type' => 'textfield',
      '#title' => t('Apellidos')
    );
    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('Email')
    );
    $form['telefono'] = array(
      '#type' => 'textfield',
      '#title' => t('Telefono')
    );
    $form['genero'] = [
      '#type' => 'select',
      '#title' => t('Genero'),
      '#options' => [
        'H' => $this->t('Hombre'),
        'M' => $this->t('Mujer'),
        'N' => $this->t('No definido'),
      ],
    ];
    $form['ciudad'] = array(
      '#type' => 'textfield',
      '#title' => t('Ciudad')
    );
    $form['vieneDe'] = array(
      '#type' => 'textfield',
      '#title' => t('Empresa o institución')
    );
    $form['tipoIdentificacion'] = [
      '#type' => 'select',
      '#title' => t('Tipo de identificación'),
      '#options' => [
        '1' => $this->t('INE'),
        '2' => $this->t('Pasaporte'),
        '3' => $this->t('Cedula'),
      ],
    ];
    $form['tipoParticipante'] = [
      '#type' => 'select',
      '#title' => t('Tipo de participante'),
      '#options' => [
        '1' => $this->t('Participante'),
        '2' => $this->t('Conferencista'),
        '3' => $this->t('Invitado especial'),
      ],
    ];

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
      $form_state->setRedirect('visitorList');
      return;
    }

    if (strlen($form_state->getValue('nombres')) <= 0) {
      $form_state->setErrorByName('nombres', $this->t('Ingrese el nombre'));
    }

	}

	function submitForm(array &$form, FormStateInterface $form_state) {

    $input = $form_state->getUserInput();

    if (isset($input['op']) && $input['op'] === 'Cancelar') {
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

    VisitorDAO::add(
      Html::escape($nombres),
      Html::escape($apellidos),
      Html::escape($email),
      Html::escape($telefono),
      Html::escape($genero),
      Html::escape($ciudad),
      Html::escape($pais),
      Html::escape($vieneDe),
      Html::escape($tipoIdentificacion),
      Html::escape($tipoParticipante)
    );

    \Drupal::messenger()->addMessage("Visitante añadido.");
		$form_state->setRedirect('visitorList');
		return;
	}
}
