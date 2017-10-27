<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'logout', 'login');
	}

	public function index(){
		$this->set('users', $this->User->find('all'));
		$current_user = $this->Auth->user('username');

		$this->set('current_user', $current_user);
	}

	public function login(){
		if($this->request->is('post')){
			if($this->Auth->login()){
				return $this->redirect($this->Auth->redirectUrl());
			}
			// $this->Flash->error(__('Invalid Username or password.'));
		}
	}

	public function logout(){
		return $this->redirect($this->Auth->logout());
	}

	public function view($id = null){
		$this->User->id = $id;
		if(!$this->User->exists()){
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->findById($id));
	}

	public function add(){
		if($this->request->is('post')){
			$this->User->create();
			if($this->User->save($this->request->data)){
				// $this->Flash->success(__('The user has been saved!'));
				return $this->redirect(array('action' => 'index'));
			}
			// $this->Flash->error(__('The user could not be saved. Please try again.'));
		}
	}

	public function edit($id = null){
		$this->User->id = $id;
		if(!$this->User->exists()){
			throw new NotFoundException(__('Invalid user'));
		}

		if($this->request->is(array('post','put'))){
			if($this->User->save($this->request->data)){
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error(__('The user could not be saved. Please try again.'));
		}else{
			$this->request->data = $this->user->findById($id);
			unset($this->request->data['User']['password']);
		}
	}

	public function delete($id = null){
		//before 2.5 -> $this->request->onlyAllow('post');
		$this->request->allowMethod('post');

		$this->User->id = $id;
		if(!$this->User->exists()){
			throw new NotFoundException(__('nvalid user'));
		}

		if($this->User->delete()){
			$this->Flash->success(__('User deleted'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->Flash->error(__('User was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
?>