<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

//    public function login() {
//        if ($this->request->is('post')) {
//            if ($this->Auth->login()) {
//                $this->redirect($this->Auth->redirect());
//            } else {
//                $this->Session->setFlash('Your username or password was incorrect.');
//            }
//        }
//    }
    
    public function login() {
        if ($this->Session->read('Auth.User')) {
        $this->Session->setFlash('You are logged in!');
        $this->redirect('/', null, false);
    }
    }

    public function logout() {
        $this->Session->setFlash('Good-Bye');
        $this->redirect($this->Auth->logout());
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
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
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function beforeFilter() {
        parent::beforeFilter();

//        // For CakePHP 2.0
//        $this->Auth->allow('*');
//
//        // For CakePHP 2.1 and up
        $this->Auth->allow();
    }

//    public function beforeFilter() {
//        parent::beforeFilter();
//        $this->Auth->allow('initDB'); // We can remove this line after we're finished
//    }
//
//    public function initDB() {
//        $group = $this->User->Group;
//        //Allow admins to everything
//        $group->id = 1;
//        $this->Acl->allow($group, 'controllers');
//
//        //allow managers to posts and widgets
//        $group->id = 2;
//        $this->Acl->deny($group, 'controllers');
//        $this->Acl->allow($group, 'controllers/Posts');
//        $this->Acl->allow($group, 'controllers/Widgets');
//
//        //allow users to only add and edit on posts and widgets
//        $group->id = 3;
//        $this->Acl->deny($group, 'controllers');
//        $this->Acl->allow($group, 'controllers/Posts/add');
//        $this->Acl->allow($group, 'controllers/Posts/edit');
//        $this->Acl->allow($group, 'controllers/Widgets/add');
//        $this->Acl->allow($group, 'controllers/Widgets/edit');
//        //we add an exit to avoid an ugly "missing views" error message
//        echo "all done";
//        exit;
//    }

}
