<?php

namespace Kanboard\Plugin\Sendmessage;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Security\Role;
use Kanboard\Core\Translator;
use Kanboard\Plugin\Sendmessage\Helper\SendmessageHelper;

class Plugin extends Base
{
    public function initialize()
    {
        $this->template->hook->attach('template:project:header:after', 'Sendmessage:message');
        $this->template->hook->attach('template:config:sidebar', 'Sendmessage:admin/sidebar');
        $this->hook->on('template:layout:css', array('template' => 'plugins/Sendmessage/styles.css'));
        $this->helper->register('sendmessage', new SendmessageHelper($this->container));
		
        $this->applicationAccessMap->add('SendmessageController', array('show', 'save', 'deleteMessage'), Role::APP_ADMIN);
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'Sendmessage';
    }

    public function getPluginAuthor()
    {
        return 'innokentiyt';
    }

    public function getPluginVersion()
    {
        return '0.0.1';
    }

    public function getPluginDescription()
    {
        return 'A Kanboard plugin to send one-way messages for individual users.';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/innokentiyt/plugin-sendmessage/';
    }
}
