<?php
/**
 * Post Controller fuel/app/classes/controller/posts.php
 */
class Controller_Base extends \Controller_Template
{
    protected $userInfo = null;
    
    public function before() {
        parent::before();
    
        $this->template->base_url = Config::get('base_url');
        $this->userInfo = Session::get('userInfo');
    }
}