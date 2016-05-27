<?php
use Fuel\Core\Controller_Template;

class Controller_User extends Controller_Template {
    public function action_oauth($provider = null)
    {
        // bail out if we don't have an OAuth provider to call
        if ($provider === null)
        {
            \Messages::error(__('login-no-provider-specified'));
            \Response::redirect_back();
        }
    
        // load Opauth, it will load the provider strategy and redirect to the provider
        \Auth_Opauth::forge();
    }
}