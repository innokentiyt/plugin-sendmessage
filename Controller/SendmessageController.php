<?php

namespace Kanboard\Plugin\Sendmessage\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\Sendmessage\Model\SendmessageMessageModel;
use Kanboard\Plugin\Sendmessage\Validator\MessageValidator;

class SendmessageController extends BaseController
{
    public function show(array $values = [], array $errors = [])
    {
		$model = SendmessageMessageModel::getInstance($this->container);
		$allmessages = $model->getMessages(NULL);
		
        $this->response->html($this->helper->layout->config('Sendmessage:admin/message', [
            'title' => t('Settings').' &gt; '.t('Send Message'),
            'values' => $values,
            'errors' => $errors,
			'allmessages' => $allmessages
        ]));
    }

    public function save()
    {
        $values = $this->request->getValues();
        list($valid, $errors) = MessageValidator::getInstance($this->container)->validateMessage($values);
		
        if ($valid && is_numeric($values['user_id']) ) {
            SendmessageMessageModel::getInstance($this->container)->save($values['message'], $values['user_id']);
			
            $this->response->redirect($this->helper->url->to('SendmessageController', 'show', ['plugin' => 'Sendmessage']));
            return;
        }

        $this->response->redirect($this->helper->url->to('SendmessageController', 'show', ['plugin' => 'Sendmessage']));
    }

    public function dismiss()
    {
		$values = $this->request->getValues();
		$message = $values['message'];
		$user_id = $values['user_id'];
		$rowid = $values['rowid'];
		
		SendmessageMessageModel::getInstance($this->container)->dismiss($message, $user_id, $rowid);
		
		//here I couldn't make it to redirect to already opened page, so it redirects to 1st project's Board...
        $this->response->redirect($this->helper->url->to('BoardViewController', 'show', ['project_id' => 1]));
    }
	
	public function deleteMessage()
    {
		$values = $this->request->getValues();
		$message = $values['message'];
		$user_id = $values['user_id'];
		$rowid = $values['rowid'];
		
		SendmessageMessageModel::getInstance($this->container)->deleteMessage($message, $user_id, $rowid);

        $this->response->redirect($this->helper->url->to('SendmessageController', 'show', ['plugin' => 'Sendmessage']));
    }
}
