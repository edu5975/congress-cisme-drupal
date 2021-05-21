<?php

namespace Drupal\visitor\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\visitor\Dao\VisitorDAO;

class VisitorMail extends FormBase
{

	function getFormID() {
		return 'visitor_email';
	}

  function buildForm(array $form, FormStateInterface $form_state, $id = '') {
    $this->id = $id;
    if($id != ''){
      $visitor = VisitorDAO::get($id);
      $form['email'] = array(
        '#type' => 'textfield',
        '#title' => t('Correo del usuario'.$visitor->nombres.$visitor->apellidos),
        '#value' => $visitor->email,
      '#attributes' => array('readonly' => 'readonly'),
      );
    }
    else{
      $form['email'] = array(
        '#type' => 'textfield',
        '#title' => t('Correo destino'),
        '#value' => 'El correo sera enviado a todos los usuarios',
        '#attributes' => array('readonly' => 'readonly'),
      );
    }

		$form['asunto'] = array(
		  '#type' => 'textfield',
		  '#title' => t('Asunto')
		);
		$form['mensaje'] = array(
		  '#type' => 'textarea',
		  '#title' => t('Mensaje')
		);

		$form['actions'] = array('#type' => 'actions');
		$form['actions']['submit'] = array(
		  '#type' => 'submit',
		  '#value' => 'Enviar',
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

    if (strlen($form_state->getValue('asunto')) <= 0) {
      $form_state->setErrorByName('asunto', $this->t('Ingrese el asunto'));
    }
    if (strlen($form_state->getValue('mensaje')) <= 0) {
      $form_state->setErrorByName('asunto', $this->t('Ingrese el mensaje'));
    }

	}

	function submitForm(array &$form, FormStateInterface $form_state) {

    $input = $form_state->getUserInput();

    if (isset($input['op']) && $input['op'] === 'Cancelar') {
      $form_state->setRedirect('visitorList');
      return;
    }

		$asunto = $form_state->getValue('asunto');
		$mensaje = $form_state->getValue('mensaje');

    $mailManager = \Drupal::service('plugin.manager.mail');
    $module = 'visitor';
    $key = 'email_contacto'; // clave que identifica el email

    // configuración del envio
    $html = file_get_contents(str_replace('src/Form', 'templates/mail.html', __DIR__));
    $params['subject'] = $asunto;
    $params['message'] = str_replace('{{mensaje}}', $mensaje, $html) ;
    $params['Cc'] = [];
    $langcode = \Drupal::currentUser()->getPreferredLangcode();
    $send = true;

    if($this->id != ''){
      $to = $form_state->getValue('email');
      $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
    }
    else{
      foreach (VisitorDAO::getAll() as $id => $f) {
        $to = $f->email;
        $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
      }
    }

    // guardamos en el log de Drupal el resultado del envio
    $message = ($result['result'] !== true)?'Se ha producido un error en el envio de email':'Email enviado';
    \Drupal::logger('contactForm')->notice($message);


    \Drupal::messenger()->addMessage("Email send.");
		$form_state->setRedirect('visitorList');
		return;
	}
}
