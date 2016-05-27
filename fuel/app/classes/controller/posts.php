<?php
/**
 * Post Controller fuel/app/classes/controller/posts.php
 */
class Controller_Posts extends Controller_Base
{
    public function before()
    {
        parent::before();
        if ( ! Auth::check())
        {
            Session::set_flash('error', 'You must be logged in.');
            Response::redirect('user/login');
        }
    }
    
    //list posts
    function action_index()
    {
        $posts = \Model_Post::find('all');
        
        $view  = \View::forge('listing');
        $view->set('posts', $posts, false);
        
        //In config file View objects are whitelisted so Fuelphp will not escape the html.
        $this->template->content = $view;
    }
 
    //add new one
    function action_add()
    {
        $fieldset = Fieldset::forge()->add_model('Model_Post');
        $form     = $fieldset->form();
        //$form->set_attribute('id', 'edit_article_form');
        
        $form->add(
            'submit',
            '',
            array('type' => 'submit', 'value' => 'Add', 'class' => 'btn medium btn-primary')
        );
        
        if($fieldset->validation()->run() == true)
        {
            $fields = $fieldset->validated();
        
            $post = new Model_Post;
            $post->post_title     = $fields['post_title'];
            $post->post_content   = $fields['post_content'];
            $post->author_name    = $fields['author_name'];
            $post->author_email   = $fields['author_email'];
            $post->author_website = $fields['author_website'];
            $post->post_status    = $fields['post_status'];
        
            if($post->save())
            {
                \Response::redirect('posts/edit/'.$post->id);
            }
        }
        else
        {
            $this->template->messages = $fieldset->validation()->error();
            
            // giu lai gia tri da nhap khi validate loi
            $fieldset->repopulate();
        }
        
        //false will tell fuel not to convert the html tags to safe string.
        $this->template->set('content', $form->build(), false);
        $this->template->content = $form;
    }
 
    //edit
    function action_edit($id)
    {
        $post = \Model_Post::find($id);
        
        //model post object is passed to the populate method
        $fieldset = Fieldset::forge()->add_model('Model_Post')->populate($post);
        $form     = $fieldset->form();
        $form->add(
            'submit',
            '',
            array('type' => 'submit', 'value' => 'Save', 'class' => 'btn medium btn-primary')
        );
        
        if($fieldset->validation()->run() == true)
        {
            $fields = $fieldset->validated();
        
            //$post = new Model_Post;
            $post->post_title     = $fields['post_title'];
            $post->post_content   = $fields['post_content'];
            $post->author_name    = $fields['author_name'];
            $post->author_email   = $fields['author_email'];
            $post->author_website = $fields['author_website'];
            $post->post_status    = $fields['post_status'];
        
            if($post->save())
            {
                \Response::redirect('posts/edit/'.$id);
            }
        }
        else
        {
            $this->template->messages = $fieldset->validation()->error();
        }
        
        $this->template->set('content', $form->build(), false);
    }
}