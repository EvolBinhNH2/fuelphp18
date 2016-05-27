<?php
class Model_Post extends \Orm\Model
{
    protected static $_table_name = 'posts';
    
    protected static $_primary_key = array('id');
    
    protected static $_properties = array(
        'id',
        'post_title' => array( //column name
            'data_type' => 'string',
            'label' => 'Post Title', //label for the input field
            'validation' => array('required', 'max_length'=>array(100), 'min_length'=>array(10)), //validation rules
            'form' => array('class' => 'form-control'),
        ),
        'post_content' => array(
            'data_type' => 'string',
            'label' => 'Post Content',
            'validation' => array('required'),
            'form' => array('class' => 'form-control'),
        ),
        'author_name' => array(
            'data_type' => 'string',
            'label' => 'Author Name',
            'validation' =>  array('required', 'max_length'=>array(65), 'min_length'=>array(2)),
            'form' => array('class' => 'form-control'),
        ),
        'author_email' => array(
            'data_type' => 'string',
            'label' => 'Author Email',
            'validation' =>  array('required', 'valid_email'),
            'form' => array('class' => 'form-control'),
        ),
        'author_website' => array(
            'data_type' => 'string',
            'label' => 'Author Website',
            'validation' =>  array('required', 'valid_url', 'max_length'=>array(60)),
            'form' => array('class' => 'form-control'),
        ),
        'post_status' => array(
            'data_type' => 'string',
            'label' => 'Post Status',
            'validation' => array('required'),
            'form' => array('type' => 'select', 'options' => array(1=>'Published', 2=>'Draft'), 'class' => 'form-control'),
        )
    );
}