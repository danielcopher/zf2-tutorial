<?php
namespace AlbumRest\Controller;
 
use Zend\Mvc\Controller\AbstractRestfulController;
 
use Album\Model\Album;
use Album\Form\AlbumForm;
use Album\Model\AlbumTable;
use Zend\View\Model\JsonModel;
 
//protected $albumTable;
////todo: connect to database!

class AlbumRestController extends AbstractRestfulController
{

 //todo: connect to database!
    public function getList()
    {   // Action used for GET requests without resource Id
	
	$album = $this->getAlbumTable()->fetchAll();
	
        return new JsonModel($album);
            // array('data' =>
                // array(
                    // array('id'=> 1, 'name' => 'Mothership', 'band' => 'Led Zeppelin'),
                    // array('id'=> 2, 'name' => 'Coda',       'band' => 'Led Zeppelin'),
                    // array('id'=> 3, 'name' => 'Blurp',      'band' => 'Seether'),
                // )
            // )
        // );
    }
 
    public function get($id)
    {   // Action used for GET requests with resource Id

        $id = (int) $this->params()->fromRoute('id', 0);
        // if (!$id) {
            // return $this->redirect()->toRoute('album', array(
                // 'action' => 'add'
            // ));
        // }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $album = $this->getAlbumTable()->getAlbum($id);

        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'index'
            ));
        }
		
	return new JsonModel(array("data" => array('id'=> $id, 'name' => $album->title, 'band' => $album->artist)));
	//print_r($album);
    }

    public function create($data)
    {   // Action used for POST requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'Updated Album', 'band' => 'Updated Band')));
    }

    public function delete($id)
    {   // Action used for DELETE requests
        return new JsonModel(array('data' => 'album id 3 deleted'));
    }

	protected $albumTable;
    private function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
	return $this->albumTable;
    }	
	
}



