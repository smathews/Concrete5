<?php 
defined('C5_EXECUTE') or die("Access Denied.");
class DashboardFoobarController extends Controller {

    public function on_start()
    {
        Loader::model('prefer_city');

        $token = Loader::helper('validation/token');
        if (!empty($_POST) && !$token->validate()) {
            die($token->getErrorMessage());
        }
        $this->set('token', $token->output('', true));
    }

    public function view() {
        $preferCity = new PreferCity();
        $preferCities = $preferCity->findAll();
        $this->set('preferCities', $preferCities);
    }

    public function delete($id){
        $preferCity = new PreferCity();
        $preferCity = $preferCity->findOneById($id);

        //already deleted, or bad id, either way...
        if(!is_null($preferCity))
        {
            $preferCity->delete();
            $this->set('message', 'Deleted: ' . $preferCity->getName());
        }

        $this->view();
    }
    
    public function edit($id = null)
    {
        $preferCity = new preferCity();

        if(!is_null($id))
        {
            $preferCity = $preferCity->findOneById($id);
        }

        $this->set('id',$id);
        $this->set('preferCity', $preferCity);
    }
        
    public function add()
    {
        //add is the same as an edit, just no pk
        $this->edit();
    }

    public function save()
    {
        //get data from form
        $post   = $this->post();
        $fields = $post['fields'];
        $id     = @$post['id'];

        //validate, catch error?
        if(!$this->validate($fields))
            return false;

        //get old object or new if no id
        $preferCity = new preferCity();
        if(!empty($id))
        {
            $preferCity = $preferCity->findOneById($id);
        }
        
        //populate
        foreach($fields as $column => $value)
        {
            $setFunction = $preferCity->columnToSetter($column);
            $preferCity->$setFunction($value);
        }

        //save
        $preferCity->save();
        
        //send back to view
        $this->set('message', 'Saved: ' . $preferCity->getName());
        $this->view();
    }
        
    private function validate($data)
    {
        //perform whatever tests you want here
        return true;
    }

}
