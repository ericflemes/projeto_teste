<?php

class FaleMaisController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $tx = new Application_Model_Taxas();
        $this->view->ddd = $tx->Ddd();
        $this->view->planos = $tx->planos();
        $this->view->taxas = $tx->taxaPadrao();
    }

    public function taxAction() {
        $post = $this->getRequest()->getParams();
        $tx = new Application_Model_Taxas();
        $retorno = $tx->taxaPagMais($post['origem'], $post['destino'], $post['tempo'], $post['plano']);
        echo json_encode($retorno);
    }

}
