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

  public function getTotalCars($dealer) {
    $this->db->select('cars.id');
    $this->db->where(array('dealers.name' => $dealer));
    $this->db->join('dealers', 'cars.dealer = dealers.id', 'left');
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

    $totalRecords = $this->getTotalCars($dealer);
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

		$offset = $page < 2 ? 0 : $page; // $pageSize * ($page - 1);
		$limit = $related ? 2 : $pageSize;

    $this->db->select('cars.*, cars.id as id, dealers.name as dealer');
    $this->db->where(array('dealers.name' => $dealer));
    $this->db->order_by('cars.id', $order);
    $this->db->limit($limit, $offset);  
    $this->db->join('dealers', 'cars.dealer = dealers.id', 'left');
    $query = $this->db->get('cars');
    // echo $this->db->last_query();exit;
    $data = $query->result(); 

    
    // paging 

    $this->load->helper('url');
    $this->load->library("pagination");
    $config = array();
    $config["base_url"] = base_url() . "api";
    $config["total_rows"] = $totalRecords;
    $config["per_page"] = $limit;
    $config["num_links"] = $totalRecords/$pageSize;
    $config["uri_segment"] = 3;
    $config['page_query_string'] = FALSE;

    $this->pagination->initialize($config);
    $links = $this->pagination->create_links();
    // $links = str_replace("<strong>", "<a href='' data-ci-pagination-page='1'>", $links);
    // $links = str_replace("</strong>", "</a>", $links);
    
    if($related) {
      
      $response = "";


      if(!empty($data)) {

        // $response .= "<div class='row1' >";
        $response .= "<div class='related-content flex-cls flex-content' >";
        forEach($data as $key => $value) {
          $response .= "<div class='related-content-list'>
            <div class='related-content-img'><a href='$value->url'><img src='$value->image' class='resp-img img-responsive' alt='$value->title' id='$value->id'></a></div>
            <div class='related-content-title text-center'><h4>$value->title</h4><a class='learn-more-btn' href='$value->url'>Know More</a></div></div>";
	     	$response .= "</div>";
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

	     	forEach($data as $key => $value) {
	    		$response .= "<div class='service-content flex-cls flex-content' link='$value->url'>";
	     		$response .= "<div class='service-img'>
	     			<img src='$value->image' class='resp-img img-responsive' alt='$value->title' id='$value->id'>
		     			<div class='desc desc_$value->id'><p class='desc_content'>$value->title</p></div></div>";
	     		$response .= "<div class='service-desc'><h4>$value->title</h4><p>$value->blurb</p></div>";
	     		$response .= "<div class='service-link'><a class='learn-more-btn' href='$value->url'>Learn More</a></div>";
	     		$response .= "</div>";
	     	}
        $response .= "<div class='row' id='pages'>".$links."</div>";
        
	    } else {
	    	$response .= "<div class='col'> No Record Found </div>";
	    }

	    $respFormat['data'] = $response;
	    echo json_encode($respFormat); 
      // echo $response;
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