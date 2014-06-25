<?php

class Upload extends WG_Controller
{
    public function index()
    {       
        $this->output->render('upload/index');
    }
}