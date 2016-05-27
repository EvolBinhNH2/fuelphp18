<?php

class Controller_User extends Controller_Template
{

	public function action_login()
	{
		$this->template->title = 'User &raquo; Login';
		$this->template->content = View::forge('user/login');
	}
	
	public function action_oauth($provider = null){
	    // bail out if we don't have an OAuth provider to call
	    if ($provider === null)
	    {
	        \Messages::error(__('login-no-provider-specified'));
	        \Response::redirect_back();
	    }
	    
	    // load Opauth, it will load the provider strategy and redirect to the provider
	    \Auth_Opauth::forge();
	}
	
	public function action_callback(){
	    try
	    {
	        $opauth = \Auth_Opauth::forge(false);
	    
	        $status = $opauth->login_or_register();
	    
	        $provider = $opauth->get('auth.provider', '?');
	    
	        switch ($status)
	        {
	            case 'linked':
	                \Session::set_flash('success', sprintf(__('login.provider-linked'), ucfirst($provider)));
	                $url = 'posts';
	                break;
	    
	            case 'logged_in':
	                \Session::set_flash('success', sprintf(__('login.logged_in_using_provider'), ucfirst($provider)));
	                $url = 'posts';
	                break;
	    
	            case 'register':
	                \Session::set_flash('success', sprintf(__('login.register-first'), ucfirst($provider)));
	                $url = 'user/register';
	                break;
	    
	            case 'registered':
	                \Session::set_flash('success', __('login.auto-registered'));
	                $url = 'posts';
	                break;
	    
	            default:
	                throw new \FuelException('Auth_Opauth::login_or_register() has come up with a result that we dont know how to handle.');
	        }
	    
	        \Response::redirect($url);
	    }
	    
	    catch (\OpauthException $e)
	    {
	        Log::error($e->getMessage());
	        \Response::redirect_back();
	    }
	    
	    catch (\OpauthCancelException $e)
	    {
	        exit('It looks like you canceled your authorisation.'.\Html::anchor('users/oath/'.$provider, 'Click here').' to try again.');
	    }
	    
	}
	
	public function action_register(){
	    if ($authentication = \Session::get('auth-strategy.authentication', array()))
	    {
	        try
	        {
	            $user = \Session::get('auth-strategy.user');
	    
	            $username_tmp = explode('@', $user['email']);
	            $username = array_shift($username_tmp);
	            // call Auth to create this user
	            $user_id = \Auth::create_user(
	                $username,
	                'dummy',
	                $user['email'],
	                \Config::get('application.user.default_group', 1),
	                array(
	                    'fullname' => $user['name'],
	                )
	                );
	    
	            // if a user was created succesfully
	            if ($user_id)
	            {
	                // don't forget to pass false, we need an object instance, not a strategy call
	                $opauth = \Auth_Opauth::forge(false);
	    
	                // call Opauth to link the provider login with the local user
	                $insert_id = $opauth->link_provider(array(
	                    'parent_id' => $user_id,
	                    'provider' => $authentication['provider'],
	                    'uid' => $authentication['uid'],
	                    'access_token' => $authentication['access_token'],
	                    'secret' => $authentication['secret'],
	                    'refresh_token' => $authentication['refresh_token'],
	                    'expires' => $authentication['expires'],
	                    'created_at' => time(),
	                ));
	                \Auth::instance()->force_login((int) $user_id);
	    
	                \Session::set_flash('success', __('login.new-account-created'));
	                \Response::redirect_back('posts');
	            }
	    
	            else
	            {
	                \Session::set_flash('error', __('login.account-creation-failed'));
	            }
	        }
	    
	        // catch exceptions from the create_user() call
	        catch (\SimpleUserUpdateException $e)
	        {
	            // duplicate email address
	            if ($e->getCode() == 2)
	            {
	                \Session::set_flash('error', __('login.email-already-exists'));
	            }
	    
	            // duplicate username
	            elseif ($e->getCode() == 3)
	            {
	                \Session::set_flash('error', __('login.username-already-exists'));
	            }
	    
	            // this can't happen, but you'll never know...
	            else
	            {
	                \Session::set_flash('error', $e->getMessage());
	            }
	        }
	    }
	    
	    else
	    {
	        \Session::set_flash('error', 'Failed to retrieve a user information from the provider.');
	    }
	    
	    \Response::redirect_back('user/login');
	}
	
	public function action_logout(){
		\Auth::dont_remember_me();

        // logout
        \Auth::logout();

        // and go back to where you came from (or the application
        // homepage if no previous page can be determined)
        \Response::redirect('');
	}

}
