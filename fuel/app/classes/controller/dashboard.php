<?php

/**
 * The Dashboard Controller.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Dashboard extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		return Response::forge(Presenter::forge('dashboard/index'));
	}

	public function action_list()
	{
	    return Response::forge(Presenter::forge('dashboard/list'));
	}

}
