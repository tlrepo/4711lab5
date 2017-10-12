<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2017-10-12
 * Time: 3:59 PM
 */

class Views extends Application {
    public function index() {
        $this->data['pagetitle'] = 'Ordered TODO List';
        $tasks = $this->tasks->all();   // get all the tasks
        $this->data['content'] = 'Ok'; // so we don't need pagebody
        $this->data['leftside'] = 'by_priority';
        $this->data['rightside'] = 'by_category';

        $this->render('template_secondary');
    }
}