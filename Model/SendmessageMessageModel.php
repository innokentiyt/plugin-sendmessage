<?php

namespace Kanboard\Plugin\Sendmessage\Model;

use Kanboard\Core\Base;
use Kanboard\Model\UserModel;

class SendmessageMessageModel extends Base
{
    const TABLE = 'sendmessage_messages';

    public function save($message, $user_id)
    {
        if (!empty($user_id) && !empty($message) ) {
            return $this->db->table(self::TABLE)->insert([
				'message' => $message,
				'user_id' => $user_id,
				'obtained' => 0
			]);
        }
    }
	
	public function dismiss($message, $user_id, $rowid)
    {
        return $this->db->table(self::TABLE)
			->eq('message', $message)
			->eq('user_id', $user_id)
			->eq('rowid', $rowid)
			->eq('obtained', 0)
			->update(['obtained' => 1]);
    }

    public function deleteMessage($message, $user_id, $rowid)
    {
        return $this->db->table(self::TABLE)
			->eq('message', $message)
			->eq('user_id', $user_id)
			->eq('rowid', $rowid)
			->remove();
    }

    public function getMessages($user_id)
    {
        if(!empty($user_id)) {
			return $this->db->table(self::TABLE)
				->eq('user_id', $user_id)
				->columns('rowid', 'message', 'user_id', 'obtained')
				->findAll();
		}
		else {
			return $this->db->table(self::TABLE)
			->notNull('message')
            ->columns('rowid', 'message', 'user_id', 'obtained')
            ->findAll();
		}
    }
}
