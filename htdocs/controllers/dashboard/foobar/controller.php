<?php   defined('C5_EXECUTE') or die("Access Denied.");

class DashboardFoobarController extends Controller {

	public function __construct() {
		$this->redirect('/dashboard/foobar/list');
	}

}

