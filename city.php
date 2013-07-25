<?php

class City extends Controller {
    
    var $base;
    var $css;

    
	function City()
	{
		//echo $search;
		parent::Controller();	
		
		$this->load->database();
		//Call model
		$this->load->model('city_model');
		
		$this->base = $this->config->item('base_url');
      $this->css = $this->config->item('css');
        
        //Loaction: /system/application/helper/parameter_helper.php
      $this->load->helper('parameter');
		$this->load->library('session');
// ====================default tile and desc and keywords=====================================  //
$this->title = $this->config->item('default_title');
$this->description = $this->config->item('default_description');
$this->keywords = $this->config->item('default_keywords');
// ====================default tile and desc and keywords=====================================  //
		
	}
	
	function index($value='')
	{
		$data['css'] = $this->css;
      $data['base'] = $this->base;
		$data['search_results'] =  $this->city_model->getList();
		$this->load->view('city_view',$data);
		
	}
	function show()
	{
		$data['css'] = $this->css;
      $data['base'] = $this->base;
      $city = trim($this->input->post('destnsel'));
		$this->destination($city);
	}
	
	
	function feature(){
	  $data['css'] = $this->css;
     $data['base'] = $this->base;
     $data['feature'] = trim($this->input->post('feature_select'));
     $data['cityid'] = trim($this->input->post('cityid'));
     
     
     
     	$data['city_list_result'] = $this->city_model->get_cities($data['feature']);
     	
     $data['destinationDrop']=$this->destinationDrop($data['city_list_result']['result'],$data['cityid'] );
/*
     	
     $result_options="<select name=\"destnsel\" id=\"destnsel\" style=\"margin-top:15px; width:185px;\"   onChange=\"document.city_select_form.submit();\" >";
      foreach($data['city_list_result']['result'] AS $cities)
       {
          //echo "<option  value=\"".$dest->cityid."</option>."\">".ucwords($dest->cityname)."</option>";
          $result_options.="<option value=\"".$cities->cityid."\" title=\"".  ucwords(strip_tags($cities->description))   ."\" >".ucwords($cities->cityname)." ( ".ucwords($cities->shortname)." )</option>";
       } 
       $result_options.="</select>";
*/
   print $data['destinationDrop'];
   // print $data['city_list_result']['query'] ;
    
	}
	function info()
	{
		$data['css'] = $this->css;
        $data['base'] = $this->base;
// ====================default tile and desc and keywords=====================================  //
$this->title = $this->config->item('default_title');
$this->description = $this->config->item('default_description');
$this->keywords = $this->config->item('default_keywords');
// ====================default tile and desc and keywords=====================================  //
       
	  $map_key = trim($this->input->post('mapkey'));
	  $city_link = strtolower(trim($this->input->post('citylink')));
	  $city_url = trim($this->input->post('cityurl'));
	  
       $data['tags'] = ' ';
       //$data['ad'] = "<marquee>YOUR AD HERE </marquee>";
      
	  
      $this->load->view('header',$data);
	  $this->load->view('content_start',$data);
	
						
      //$this->load->view('menu');
	  $this->load->view('info/places/'.$city_url.'.html', $data);
		/* ================================================ */
		/* ================================================ */
		/* ================================================ */
		// function to show links as seen in find locatons
		
        $this->load->helper('parameter');
	  	$data['location_link']=get_location_links($map_key,$city_link,$this->base); 
		
		/* ================================================ */
		/* ================================================ */
		/* ================================================ */
		// load city menu map,package ,hotel
	  $this->load->view('city_menu',$data);	
		
	  $this->load->view('content_end',$data);
      $this->load->view('footer');
		
	}
	
	function destination($cityid='8'){
		$data['css'] = $this->css;
      $data['base'] = $this->base;
		$this->load->helper('url');
		//check for city description
		$city_rst = $this->city_model->checkcitydescription(intval($cityid));
		//print_r($city_rst);
		if(empty($city_rst))
		{
			//echo $url="home/places/";
				$this->session->set_userdata('search_type',"city");
			redirect('/search/', 'refresh');
			
		} 
		else if($city_rst->descr=='' AND $city_rst->url=='')
		{
			$this->session->set_userdata('search_type',"city");
			redirect('/search/', 'refresh');
		}
		else if ($city_rst->descr=='' AND $city_rst->url!='')
		{
			$this->session->set_userdata('search_type',"city");
			$this->session->set_userdata('key_word',trim($city_rst->url));
			redirect('/search/', 'refresh');
			//$this->touristspot(30);
		}
		else if($city_rst->descr!='')
		{
		
		//else show old page
		
// ====================default tile and desc and keywords=====================================  //
$data['title'] =ucwords( $city_rst->city)."-".strip_tags($city_rst->descr)." ".$this->title ;
      $data['description'] =$this->description;
 $data['keywords'] =$this->keywords;
// ====================default tile and desc and keywords=====================================  //
	//$data['title'] = " Your Ultimate Travel Companion";
		$data['extra'] = '<link href="'.$this->base.'css/DestinationPage.css" rel="stylesheet" type="text/css"/>
											<script src="'.$this->base.'js/showmap.js" type="text/javascript"></script>
											<script src="'.$this->base.'js/DestinationPage.js" type="text/javascript"></script>
											<script type="text/javascript" language="javascript" src="'.$this->base.'js/AcordionJQuery.js"></script>
											<script type="text/javascript" language="javascript" src="'.$this->base.'js/script.js"></script>   
											<script src="http://maps.google.com/maps?file=api&v=2&sensor=true&key='.$this->config->item('mapkey').'" type="text/javascript"></script>';

		 $this->load->view('header',$data);
		 $this->load->view('content_start',$data);
		 $this->load->model('package_model');
		 $this->load->model('hotel_model');
		 //load description for the city
		 $data['city_description'] =  $this->city_model->getdestinationdescriptions($cityid);	 
		 //load 3 packages for this city
		 $data['hotpackges'] =  $this->package_model->getdestinationhotpackges($cityid);	
		//loade 3 hotels for this city
		 $data['hotels'] =  $this->hotel_model->getdestinationhotels($cityid);
		 // loade city how to reach	 
		 $data['city'] =  $this->city_model->howtoreach($cityid);
		 $data['cityid'] =$cityid;
		// search in right side bar
		// ================================================================================
		
		 $data['destnoption'] =  $this->city_model->destinationlist();
		 		 // loade city city Attractions	 
		 $data['cityAttractions'] =  $this->city_model->listcityfeature($cityid, $type="attractions"); // attractions
		 // loade city Tour Guide 
		 $data['TourGuide'] =  $this->city_model->listcityfeature($cityid, $type="tourgiuide"); // tourgiuide
		 // loade city images	 
		 $data['cityimages'] =  $this->city_model->showdestinationimage($cityid);
		 		 $data['destnoption'] =  $this->city_model->destinationlist();
		 		 $data['cats'] =  $this->package_model->getPackageCategory();
		 		 $data['packageCities'] =  $this->city_model->getPackageUnderCategory(); 
		 		 $data['cityFeatures'] =  $this->city_model->get_city_features(); 
		 		 $data['destinationDrop']=$this->destinationDrop($data['destnoption'],$cityid);
						$data['pkgCat'] = $this->package_model->getPackageCategory();
						
		 		// $data['packageCitiesDrop']=$this->packageCitiesDrop($data['packageCities'] ['citiesResult']);

		 		 
		 		 
		// ================================================================================
		$data['destination_search']=	$this->load->view('plugins/destination_search',$data,TRUE);
		$data['hotel_search']=	$this->load->view('plugins/hotel_search',$data,TRUE);
		$data['package_search']=	$this->load->view('plugins/package_search',$data,TRUE);
		$data['flight_search']=	$this->load->view('plugins/flight_search',$data,TRUE);
		// ================================================================================
		 
		 //load map here
       $data['mapdata'] = $city_rst->city." kerala india" ; 		 
		 $data['showmapdata'] = $this->load->view('map/map_view',$data,TRUE);
		 $this->load->view('destination.html',$data);
		 
		 $data['right_sidebar'] = $this->load->view('destination_right',$data,TRUE);
		
		 $this->load->view('content_end',$data);
		 $this->load->view('footer');
	 }
	}
	
	// tourist spot page eg: munnar,varkala
	function touristspot($cityid='30'){
		$data['css'] = $this->css;
      $data['base'] = $this->base;
		$this->load->helper('url');
		//check for city description
		$city_rst = $this->city_model->checkcitydescription($cityid);
		//print_r($city_rst);
/*
		
		if(1)
		{
*/
		
		//else show old page
		
// ====================default tile and desc and keywords=====================================  //
$data['title'] =ucwords( $city_rst->city)."-".strip_tags($city_rst->descr)." ".$this->title ;
      $data['description'] =$this->description;
 $data['keywords'] =$this->keywords;
// ====================default tile and desc and keywords=====================================  //
	//$data['title'] = " Your Ultimate Travel Companion";
		$data['extra'] = '<link href="'.$this->base.'css/DestinationPage.css" rel="stylesheet" type="text/css"/>
						  <link href="'.$this->base.'css/about.css" rel="stylesheet" type="text/css"/>
		              <script src="'.$this->base.'js/showmap.js" type="text/javascript"></script>
					     <script src="'.$this->base.'js/DestinationPage.js" type="text/javascript"></script>
					     <script type="text/javascript" language="javascript" src="'.$this->base.'js/AcordionJQuery.js"></script>
                    <script type="text/javascript" language="javascript" src="'.$this->base.'js/script.js"></script>   
					     <script src="http://maps.google.com/maps?file=api&v=2&sensor=true&key='.$this->config->item('mapkey').'" type="text/javascript"></script>';

		 $this->load->view('header',$data);
		 $this->load->view('content_start',$data);
		 $this->load->model('package_model');
		 $this->load->model('hotel_model');
		 //load description for the city
		 $data['city_description'] =  $this->city_model->getdestinationdescriptions($cityid);	 
		 //load 3 packages for this city
		 $data['hotpackges'] =  $this->package_model->getdestinationhotpackges($cityid);	
		//loade 3 hotels for this city
		 $data['hotels'] =  $this->hotel_model->getdestinationhotels($cityid);
		 // loade city how to reach	 
		 $data['city'] =  $this->city_model->howtoreach($cityid);
		 $data['cityid'] =$cityid;
		// search in right side bar
		// ================================================================================
		
		 $data['destnoption'] =  $this->city_model->destinationlist();
		 		 // loade city city Attractions	 
		 $data['cityAttractions'] =  $this->city_model->listcityfeature($cityid, $type="attractions"); // attractions
		 // loade city Tour Guide 
		 $data['TourGuide'] =  $this->city_model->listcityfeature($cityid, $type="tourgiuide"); // tourgiuide
		 // loade city images	 
		 $data['cityimages'] =  $this->city_model->showdestinationimage($cityid);
		 		 $data['destnoption'] =  $this->city_model->destinationlist();
		 		 $data['cats'] =  $this->package_model->getPackageCategory();
		 		 $data['packageCities'] =  $this->city_model->getPackageUnderCategory(); 
		 		 $data['cityFeatures'] =  $this->city_model->get_city_features(); 
		 		 $data['destinationDrop']=$this->destinationDrop($data['destnoption'],$cityid);
						$data['pkgCat'] = $this->package_model->getPackageCategory();
						
		 		// $data['packageCitiesDrop']=$this->packageCitiesDrop($data['packageCities'] ['citiesResult']);

		 		 
		 		 
		// ================================================================================
		$data['destination_search']=	$this->load->view('plugins/destination_search',$data,TRUE);
		$data['hotel_search']=	$this->load->view('plugins/hotel_search',$data,TRUE);
		$data['package_search']=	$this->load->view('plugins/package_search',$data,TRUE);
		$data['flight_search']=	$this->load->view('plugins/flight_search',$data,TRUE);
		// ================================================================================
		
		// loade city city Attractions	 
		 $cityAttractions =  $this->city_model->listcityfeature($cityid, $type="attractions"); // attractions
		  $data['right_sidebar'] ='<div id="generalright" >
                               <div id="right_link_head" class="base_sub_heading">More</div>
                               <div id="right_link_head">';
				foreach($cityAttractions as $cityAttractions) {
					$data['right_sidebar'] .= "<li class=\"bullet\"><a class=\"bulletlink\" href=\"".$this->base."index.php/city/attractions/" . $cityAttractions->cityid."/".$cityAttractions->featureid."\">" . $cityAttractions->name . "</a></li>";
				}		   
			$data['right_sidebar'] .=' </div>'; 
		 
		 
		 //load map here
         $data['mapdata'] = $city_rst->city." kerala india" ; 		 
		 $data['showmapdata'] = $this->load->view('map/map_view',$data,TRUE);
		 $this->load->view('touristspot.html',$data);
		 
		 //$data['right_sidebar'] = $this->load->view('destination_right',$data,TRUE);
		
		 $this->load->view('content_end',$data);
		 $this->load->view('footer');
	 //}
	}
	
	
	function packageCitiesDrop($cont){
		$data['packageCitiesDrop']=" <select name=\"destnsel\" id=\"destnsel\" style=\"margin-top:15px; width:185px;\" >
           <option selected=\"selected\" class=\"base-font select-option\" value=\"0\">Select Destination</option>      ";
        $r="";
        foreach($cont AS $cities)
       {
       $r.="<option value=\"".$cities->cityid."\" title=\"".  ucwords($cities->cityname)   ."\" >".ucwords($cities->cityname)."</option>";
       } 
       $data['packageCitiesDrop'].= $r;
       $data['packageCitiesDrop'].=" </select>";
		return $data['packageCitiesDrop'];
	}
	
	function destinationDrop($content="",$cityid=0){
		 $data['destinationDrop']=" <select name=\"destnsel\" id=\"destnsel\" style=\"margin-top:15px; width:185px;\"   onChange=\"if(this.value!=0) { document.city_select_form.submit(); } \"  >
           <option selected=\"selected\" class=\"base-font select-option\" value=\"0\">Select Destination</option>      ";
        $d="";
       foreach($content  AS $dest){$d.= '<option value="'.$dest->cityid.'"   ';     if(!(empty($cityid)) &&($dest->cityid==$cityid)){  $d.= ' selected="selected" ';}  $d.= ' >'.ucwords($dest->cityname).'</option>';    } 
        $data['destinationDrop'].= $d;
        $data['destinationDrop'].= "       </select> ";
		return  $data['destinationDrop'];
	}
	
	
	
	
	
	function attractions($cityid='',$featureid='') {
	   $data['css'] = $this->css;
       $data['base'] = $this->base;
       $data['extra'] = '<link href="'.$this->base.'css/aboutus.css" rel="stylesheet" type="text/css" />';
       // ====================default tile and desc and keywords=====================================  //
	   $this->title = $this->config->item('default_title');
	   $this->description = $this->config->item('default_description');
	   $this->keywords = $this->config->item('default_keywords');
	   // ====================default tile and desc and keywords=====================================  //
       //echo "value=".$value;
       //$data['ad'] = "<marquee>YOUR AD HERE </marquee>";
       $cityAttractions =  $this->city_model->listcityfeature($cityid, $type="attractions",$featureid); // attractions
	   //print_r($cityAttractions);		
	   //$this->load->view('menu');
	   // foreach($data['cityAttractions'] AS $attr)
	   // {
	   $head=$cityAttractions[0]->name;//$attr->name;
	   $cityname=trim($cityAttractions[0]->cityname);//$attr->cityname;
	   $desc=$cityAttractions[0]->description;//$attr->description;
	   // }
	   $data['info'] = "<div id=\"generalhead\" class=\"generalheadtext\"><a href=\"".$this->base."index.php/city/destination/".$cityid."\"><span style=\"font-size:24px;color:#888888\">".ucwords($cityname)."</span></a> / ".$head."</div>";
	   $data['info'] .=$desc;
	  
		// loade city city Attractions	 
		 $cityAttractions =  $this->city_model->listcityfeature($cityid, $type="attractions"); // attractions
		 
		 
		 //echo print_r($cityAttractions);
		 // loade city Tour Guide 
		 $TourGuide =  $this->city_model->listcityfeature($cityid, $type="tourgiuide"); // tourgiuide
		  
			 $data['right_sidebar'] ='<div id="generalright" >
                               <div id="right_link_head" class="base_sub_heading">More</div>
                               <div id="right_link_head">';
				foreach($cityAttractions as $cityAttractions) {
					$data['right_sidebar'] .= "<li class=\"bullet\"><a class=\"bulletlink\" href=\"".$this->base."index.php/city/attractions/" . $cityAttractions->cityid."/".$cityAttractions->featureid."\">" . $cityAttractions->name . "</a></li>";
				}		   
			$data['right_sidebar'] .=' </div>'; 
			
			
			
			$data['info_left'] = '<li class="leftlink"><a href="#"><b>Tour Guide</b></a></li>';
			 	foreach($TourGuide as $TourGuide) {
					$data['info_left'] .= "<li class=\"leftlink\"><a class=\"bulletlink\" href=\"".$this->base."index.php/city/tourguide/" . $TourGuide->cityid."/".$TourGuide->featureid."\">" . $TourGuide->name . "</a></li>";
				}		   	  

	   $this->load->view('header',$data);
	   $this->load->view('content_start',$data);
	   $this->load->view('info_layout',$data);	 
	   $this->load->view('content_end',$data);
       $this->load->view('footer',$data);
    }
	
	
	
	
	
	function tourguide($cityid='',$featureid='') {
	   $data['css'] = $this->css;
       $data['base'] = $this->base;
      
       $data['extra'] = '<link href="'.$this->base.'css/aboutus.css" rel="stylesheet" type="text/css" />';
     
    // ====================default tile and desc and keywords=====================================  //
	$this->title = $this->config->item('default_title');
	$this->description = $this->config->item('default_description');
	$this->keywords = $this->config->item('default_keywords');
	// ====================default tile and desc and keywords=====================================  //      
	 $cityAttractions =  $this->city_model->listcityfeature($cityid, $type="tourgiuide",$featureid); // attractions
	 $head=$cityAttractions[0]->name;//$attr->name;
	 $desc=$cityAttractions[0]->description;//$attr->description;
	  $data['info'] = "<div id=\"generalhead\" class=\"generalheadtext\">".$head."</div>";
	  $data['info'] .=$desc;

		// loade city city Attractions	Rafeek 
		 $cityAttractions =  $this->city_model->listcityfeature($cityid, $type="attractions"); // attractions
		 // loade city Tour Guide  Rafeek 
		 $TourGuide =  $this->city_model->listcityfeature($cityid, $type="tourgiuide"); // tourgiuide
		 $data['right_sidebar'] ='<div id="generalright" >
                               <div id="right_link_head" class="base_sub_heading">Attractions</div>
                               <div id="right_link_head">';
				foreach($cityAttractions as $cityAttractions) {
					$data['right_sidebar'] .= "<li class=\"bullet\"><a class=\"bulletlink\" href=\"".$this->base."index.php/city/attractions/" . $cityAttractions->cityid."/".$cityAttractions->featureid."\">" . $cityAttractions->name . "</a></li>";
				}		   
			$data['right_sidebar'] .=' </div>'; 
			
			$data['info_left'] = '<li class="leftlink"><a href="#"><b>Tour Guide</b></a></li>';
			 	foreach($TourGuide as $TourGuide) {
					$data['info_left'] .= "<li class=\"leftlink\"><a class=\"bulletlink\" href=\"".$this->base."index.php/city/tourguide/" . $TourGuide->cityid."/".$TourGuide->featureid."\">" . $TourGuide->name . "</a></li>";
				}		   	  
      $this->load->view('header',$data);
	  $this->load->view('content_start',$data);
	  $this->load->view('info_layout',$data);	 
	  $this->load->view('content_end',$data);
      $this->load->view('footer',$data);
      
	}
	
	function gallery($cityid='8') {
	   $data['css'] = $this->css;
      $data['base'] = $this->base;
      	   
	   // loade city images	 
	   $data['cityimages'] =  $this->city_model->showdestinationimage($cityid);
      
	   $this->load->view('gallery.html',$data);
	}
	
	function weather($place='kochi') {
	   $data['css'] = $this->css;
      $data['base'] = $this->base;
      $data['extra'] = '<link href="'.$this->base.'css/DestinationPage.css" rel="stylesheet" type="text/css" />';;
      $data['place']= $place;
	   $this->load->view('map/weather',$data);
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
