<li <?= $this->app->checkMenuSelection('SendmessageController', 'show', 'Sendmessage') ?>>
    <?= $this->url->link(t('Send Message'), 'SendmessageController', 'show', array('plugin' => 'Sendmessage')) ?>
</li>