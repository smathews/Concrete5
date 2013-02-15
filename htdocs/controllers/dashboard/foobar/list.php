<?php 
defined('C5_EXECUTE') or die("Access Denied.");
class DashboardFoobarListController extends Controller {

    public function on_start()
    {
        Loader::model('prefer_city');
    }

    public function view() {
        $preferCity = new PreferCity();
        $preferCity->setName('Dallas')
                   ->setLatitude(32.1234)
                   ->setLongitude(-96.1111)
                   ->save();

        echo "<pre>";
        var_dump($preferCity);

        $preferCity->setName('Houston')->save();
        var_dump($preferCity);
        
        exit;


    }

    public function edit() {
	//stuff
    }

    public function add(){
	//stuff
    }
}
