<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use SnappyImage;
	class AdminTenantController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "nama";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "tenant";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Nama Tenant","name"=>"nama"];
			$this->col[] = ["label"=>"Nama Client","name"=>"client_id","join"=>"client,nama"];

			$this->col[] = ["label"=>"Area","name"=>"alamat"];
			$this->col[] = ["label"=>"Kota","name"=>"kota_id", "join"=>"kota,nama"];
			$this->col[] = ["label"=>"ID tenant","name"=>"qr_id"];

			$this->col[] = [
				"label" => "QR Code", "name" => "qr_id","callback" => function ($row) {
					// $client = DB::table('tenant')->where('id', $row->client_id)->orderBy('id','asc')->first();
					$kota = DB::table('kota')->where('id', $row->kota_id)->orderBy('id','asc')->first();
					
					return (
					"<a data-toggle='modal' data-target='#Modal' href='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$row->qr_id'>
					
					<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".$row->qr_id."' 
					onclick='#' alt='Barcode' width='50px' height='50px'></a>
					<br>
					<button type='button' class='btn' data-toggle='modal' data-target='#Modal".$row->id."' >Preview</button>
				
			<div class='modal fade' id='Modal".$row->id."' data-id='".$row->id."'>
			<div class='modal-dialog' role='document'>

				<div class='modal-content'>

				<div class='modal-header'>
					<h5 class='modal-title' id='exampleModalLabel'>Preview Qrcode</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				  </button>
					</div>
					
			
					<div class='modal-body' id='html-content-holder".$row->id."' data-id='".$row->id."' style='background-color: #FFFFFF;  
					color: #000000; width: 500px; padding-top: 10px;'>

					<div class='row'>
						<div class='col-lg-5'>
						<img src='https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=$row->qr_id' 
								id='noregNow' data=".$row->qr_id."
								onclick='#' alt='Barcode' style='width:250px;height:250px;'>
								</div>
						<div class='col-lg-7' style='padding-top: 20px; padding-left: 40px'>
								<h4 style='font-size:30px'>".$row->nama."</h4><br>
								<h4 style='font-size:20px'>Area :<br>
								".$row->alamat."<br><br>
								Kota :<br>
								".$kota->nama."
								</h4>
								</div>
					</div>
					</div>
					<div class='modal-footer'>
					<button type='button' class='btn' data-dismiss='modal'>Close</button>
					
					
					</div>
				</div>
				
			</div>	
						");},"image"=>1

			];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'ID Tenant','name'=>'qr_id','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nama','name'=>'nama','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$this->form[] = ['label'=>'Nama Client','name'=>'client_id','type'=>'select2','width'=>'col-sm-10','datatable'=>'client,nama' ,'validation'=>'required'];
			// $this->form[] = ['label' => 'Alamat', 'name' => 'alamat', 'type' => 'text', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
			$this->form[] = ['label' => 'Latitude', 'name' => 'latitude', 'type' => 'text', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
			$this->form[] = ['label' => 'Longitude', 'name' => 'longitude', 'type' => 'text', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
			$this->form[] = ['label'=>'Area','name'=>'alamat','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Provinsi','name'=>'provinsi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'provinsi,nama'];
			$this->form[] = ['label'=>'Kota','name'=>'kota_id','type'=>'select','validation'=>'|integer|min:0','width'=>'col-sm-10','datatable'=>'kota,nama','parent_select'=>'provinsi_id'];
			$this->form[] = ['label'=>'Kecamatan','name'=>'kecamatan_id','type'=>'select','validation'=>'|integer|min:0','width'=>'col-sm-10','datatable'=>'kecamatan,nama','parent_select'=>'kota_id'];
			// $this->form[] = ['label'=>'Kota','name'=>'kota','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Nama','name'=>'nama','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			//$this->form[] = ['label'=>'Alamat','name'=>'alamat','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Kota','name'=>'kota','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();
			$this->addaction[] = ['label'=>'Print Label','color' => 'success',"icon"=>"fa fa-print",
			"url"=>CRUDBooster::mainpath('print_label/[id]')];

	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
			if(!(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId()=='3')){

			$client = DB::table('cms_users')->where('id',CRUDBooster::myId())->first();
			$query->where('client_id',$client->client_id);
	 	   }
	}
	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }

		public function getPrint_label($id){
			$data = DB::table('tenant')->where('id', $id)->first();
			$kota = DB::table('kota')->where('id', $data->kota_id)->first();
			$foto = asset('/' . $data->qr_id);
			// $barcode ='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$data->kode_box;
			$pdf = SnappyImage::loadView('label.label', compact('data', 'foto','kota'))
			
			->setOption('width', '1500')
			->setOption('height', '900')
			->setOption('quality', 100)
			;
			return $pdf->download('QR Code ' . $data->qr_id . '.png');
		}
		
		public function getDetail($id)
		{
			$data['page_title'] = 'Detail Tenant';
			$data['page']        = 'Detail';
			
			$data['data']        = DB::table('tenant')->where('id', $id)->first();
			// $data['url']        = CRUDBooster::mainpath();
			
			$data['client'] = DB::table('client')->where('id',$data['data']->client_id )->first();
			
			return view('detail_tenant', $data);
		}

	    //By the way, you can still create your own method in here... :) 


	}