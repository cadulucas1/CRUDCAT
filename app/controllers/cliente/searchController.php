<?php

require_once __DIR__ . '/../../models/geral/GeralModel.php';

class searchController extends RenderView {

    public function search() {
        $model = new GeralModel;

        $lojas = $model->getAllLojas();

        $this->loadView('cliente/search' ,[
            'lojas' => $lojas
        ]);
    }

}