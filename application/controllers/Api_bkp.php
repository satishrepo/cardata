<?php
//require APPPATH . 'libraries/REST_Controller.php';
     
class Api extends CI_Controller {
    
  /**
   * Get All Data from this method.
   *
   * @return Response
  */
  public function __construct() {
  	header('Access-Control-Allow-Origin: *');
  	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
     	parent::__construct();
     	$this->load->database();
  }

  public function getTotalCars() {
  	$query = $this->db->get('cars');
  	return $query->num_rows();
  }
       
  /**
   * Get All Data from this method.
   *
   * @return Response
  */
	public function get($relatedContent = false)
	{
		$params = $this->input->get();
		$page = is_array($params) && isset($params['page']) ? (int)$params['page'] : 1;
		$pageSize = is_array($params) && isset($params['pagesize']) ? (int)$params['pagesize'] : 10;
		$order = is_array($params) && isset($params['order']) ? $params['order'] : 'ASC';
    $dealer = is_array($params) && isset($params['dealer']) ? trim($params['dealer']) : '';
		$related = is_array($params) && isset($params['related']) ? $params['related'] : '';

		$respFormat = array(
	    	// 'page' => $page,
	    	// 'pagesize' => $pageSize,
	    	// 'total' => $this->getTotalCars(),
	    	'data' => '',
	    	'errortext' => ''
	  	);

		if($dealer == '') {
			$respFormat['errortext'] .= ' Dealer field missing. ';
			echo json_encode($respFormat);
			exit;
		}

		$offset = $page < 2 ? 0 : $pageSize * ($page - 1);
		$limit = $related ? 2 : 50;//$pageSize;

    $this->db->where(array('dealer' => $dealer, 'status' => '1'));
    $this->db->order_by('id', $order);  
    $this->db->limit($limit, $offset);  
    $data = $this->db->get("cars")->result();
    // echo $this->db->last_query();exit;

    if($related) {
      
      $response = "";


      if(!empty($data)) {

        // $response .= "<div class='row1' >";
        $response .= "<div class='row color-row' >";
        forEach($data as $key => $value) {

          $response .= "<div class='col-sm-6'>
            <div class='text-center'>$value->title</div>
            <img src='$value->image' class='resp-img img-responsive' alt='$value->title' id='$value->id'>
            </div>";
        }
        $response .= "</div>";
      
      } else {
      	
      	$response = "<div class='col'>No Data Found</div>";

      }

      $respFormat['data'] = $response;
	    
	    echo json_encode($respFormat); 

    }else{

      $response = "";

	    if(count($data)) {
          // $response .= "<div class='row1' >";
	     	forEach($data as $key => $value) {
	    		$response .= "<div class='row color-row' link='$value->url'>";
	     		$response .= "<div class='col-lg-3 col-md-3 hidden-sm-down hidden-xs-down'><span class='align-middle'>$value->title</span></div>";
	     		$response .= "<div class='col-lg-3 col-md-6 hidden-sm-down hidden-xs-down'><span class='align-middle'>$value->blurb</span></div>";
	     		$response .= "<div class='col-lg-6 col-md-3 col-xs-12 col-sm-12'>
	     			<img src='$value->image' class='resp-img img-responsive' alt='$value->title' id='$value->id'>
		     			<div class='desc desc_$value->id'>
	            	<p class='desc_content'>$value->title</p>
	        		</div>
	     			</div>";
	   			$response .= "</div>";
	     	}
        // $response .= "</div>";
	    } else {
	    	$response .= "<div class='col'> No Record Found </div>";
	    }

	    $respFormat['data'] = $response;
	    echo json_encode($respFormat); 
    }
    
    
    exit;
       
	}

  public function getCardDetails($id) {
    $query = "SELECT b.* FROM `cars` a JOIN cars b on a.dealer = b.dealer WHERE a.id = $id LIMIT 2";
    $rs = $this->db->query($query);
    return $rs->result();

  }


	public function index_get($id = false)
	{
		$data = [];
        if($id){
            $data = $this->db->get_where("cars", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("cars")->result();
        }
       	$data1 = 'sattish';
        $this->response($data111, REST_Controller::HTTP_OK);
	}
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();
        $this->db->insert('items',$input);
     
        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('items', $input, array('id'=>$id));
     
        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('items', array('id'=>$id));
       
        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}