<?php

class GeralController extends RenderView {

    public function index() {
        $this->loadView('geral/home' ,[]);
    }

}