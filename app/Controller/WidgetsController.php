<?php

App::uses('AppController', 'Controller');

/**
 * Widgets Controller
 *
 * @property Widget $Widget
 */
class WidgetsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Widget->recursive = 0;
        $this->set('widgets', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Widget->exists($id)) {
            throw new NotFoundException(__('Invalid widget'));
        }
        $options = array('conditions' => array('Widget.' . $this->Widget->primaryKey => $id));
        $this->set('widget', $this->Widget->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Widget->create();
            if ($this->Widget->save($this->request->data)) {
                $this->Session->setFlash(__('The widget has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The widget could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Widget->exists($id)) {
            throw new NotFoundException(__('Invalid widget'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Widget->save($this->request->data)) {
                $this->Session->setFlash(__('The widget has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The widget could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Widget.' . $this->Widget->primaryKey => $id));
            $this->request->data = $this->Widget->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Widget->id = $id;
        if (!$this->Widget->exists()) {
            throw new NotFoundException(__('Invalid widget'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Widget->delete()) {
            $this->Session->setFlash(__('Widget deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Widget was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
