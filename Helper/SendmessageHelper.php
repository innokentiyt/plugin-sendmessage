<?php

namespace Kanboard\Plugin\Sendmessage\Helper;

use Kanboard\Core\Base;
use Kanboard\Plugin\Sendmessage\Model\SendmessageMessageModel;

class SendmessageHelper extends Base
{
    public function render()
    {
        $user_id = $this->userSession->getId();
		$messages_unobtained = SendmessageMessageModel::getInstance($this->container)->getMessages($user_id);

        if (! empty($messages_unobtained) ) {
            $html = 'Есть сообщение!';
			
			foreach ($messages_unobtained as $message) {
				$rowid = $message['rowid'];
				$content = $message['message'];
				$user_id = $message['user_id'];
				if($message['obtained'] == 0) {
					$html='
					<div class="alert">
						<form style="float:right; font-size:9pt" method="post" action="'.$this->helper->url->href('SendmessageController', 'dismiss', array('plugin' => 'Sendmessage')).'" autocomplete="off">'
							.$this->helper->form->csrf().'
							<input type="hidden" name="rowid" value="'.$rowid.'">
							<input type="hidden" name="message" value="'.$content.'">
							<input type="hidden" name="user_id" value="'.$user_id.'">
							<button type="submit" class="btn btn-blue">Отметить прочтенным</button>
						</form>
						Вы получили сообщение от администратора: <b>'.$this->helper->text->markdown($content).'</b>
						<div style="clear:both"></div>
					</div>';
					echo $html;
				}				
			}
			
			
			/*$html = '<div id="broadcast-message"><div id="broadcast-message-inner">';
            $html .= '<div class="page-header"><h2>'.t('Announcement').'</h2></div>';
			
			foreach ($messages_unobtained as $message) {
                $html .= '<div class="markdown">'.$this->helper->text->markdown($message).'</div>';
            }
            
            $html .= '<div class="form-actions"><a href="'.$this->helper->url->href('SendmessageController', 'dismiss', array('plugin' => 'Sendmessage')).'" class="btn btn-blue">'.t('Close').'</a></div>';
            $html .= '</div></div>';*/
        }

        return '';
    }
}