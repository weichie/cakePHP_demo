<?php
class PostsController extends AppController{
	public $helper = array('Html', 'Flash', 'Form');

	public function isAuthorized($user){
		//All registered users can add posts
		if($this->action === 'add'){
			return true;
		}

		//the owner of the post can edit and delete
		if(in_array($this->action, array('edit', 'delete'))){
			$postId = (int) $this->request->params['pass'][0];
			if($this->Post->isOwnedBy($postId, $user['id'])){
				return true;
			}

			return parent::isAuthorized($user);
		}
	}

	public function index(){
		$this->set('posts', $this->Post->find('all'));
		$current_user = $this->Auth->user('username');

		$this->set('current_user', $current_user);
	}

	public function view($id = null){
		if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}

		$post = $this->Post->findById($id);
		if(!$post){
			throw new NotFoundException(__('Invalid post'));
		}

		$this->set('post',$post);
	}

	public function add(){
		if($this->request->is('post')){
			$this->Post->create();
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			if($this->Post->save($this->request->data)){
				// $this->Flash->success(__('Your post has been saved!'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error(__('Unable to add your post.'));
		}
	}

	public function edit($id = null){
		if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}
		
		$post = $this->Post->findById($id);
		if(!$post){
			throw new NotFoundException(__('Invalid post'));
		}

		if($this->request->is(array('post', 'put'))){
			$this->Post->id = $id;
			if($this->Post->save($this->request->data)){
				$this->Flash->success(__('The post has been edited!'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error(__('nable to edit your post...'));
		}

		if(!$this->request->data){
			$this->request->data = $post;
		}
	}

	public function delete($id){
		if($this->request->is('get')){
			throw new MethodNotAllowedException();
		}

		if($this->Post->delete($id)){
			$this->Flash->success(__('The post with the id: %s has been deleted.', h($id)));
		}else{
			$this->Flash->error(__('The post with the id: %s could not be deleted.', h($id)));
		}

		return $this->redirect(array('action' => 'index'));
	}
}
?>