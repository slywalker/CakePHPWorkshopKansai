<?php
class PostsController extends AppController {

	var $name = 'Posts';
	var $helpers = array('Html', 'Form');

	function index() {
		$joins = array();
		$conditions = array();
		if (!empty($this->passedArgs['tag'])) {
			$joins[] = array(
				'table' => 'posts_tags',
				'alias' => 'PostsTag',
				'type' => 'INNER',
				'conditions' => array('Post.id = PostsTag.post_id'),
			);
			$conditions = array('PostsTag.tag_id' => $this->passedArgs['tag']);
		}
		$this->paginate = array(
			'conditions' => $conditions,
			'joins' => $joins,
			'contain' => array(
				'User' => array('fields' => array('id', 'username')),
			),
		);
		$this->set('posts', $this->paginate());
		$tags = $this->Post->Tag->find('list');
		$this->set(compact('tags'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Post', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Post->contain(array(
			'User' => array('fields' => array('id', 'username')),
			'Tag',
		));
		$this->set('post', $this->Post->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Post->create();
			if ($this->Post->save($this->data)) {
				$this->Session->setFlash(__('The Post has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Post could not be saved. Please, try again.', true));
			}
		}
		$tags = $this->Post->Tag->find('list');
		$users = $this->Post->User->find('list');
		$this->set(compact('tags', 'users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Post', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Post->save($this->data)) {
				$this->Session->setFlash(__('The Post has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Post could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Post->contain(array(
				'User' => array('fields' => array('id', 'username')),
				'Tag',
			));
			$this->data = $this->Post->read(null, $id);
		}
		$tags = $this->Post->Tag->find('list');
		$users = $this->Post->User->find('list');
		$this->set(compact('tags','users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Post', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Post->del($id)) {
			$this->Session->setFlash(__('Post deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Post could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>