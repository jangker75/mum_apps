<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Maatwebsite\Excel\Facades\Excel;
	class AdminKecamatanController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->table = "kecamatan";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Provinsi","name"=>"provinsi_id","join"=>"provinsi,nama"];
			$this->col[] = ["label"=>"Kota","name"=>"kota_id","join"=>"kota,nama"];
			$this->col[] = ["label"=>"Kode","name"=>"kode"];
			$this->col[] = ["label"=>"Nama","name"=>"nama"];
			$this->col[] = ["label"=>"Kode Pos","name"=>"kode_pos"];
			$this->col[] = ["label"=>"Keterangan","name"=>"keterangan"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Provinsi Id','name'=>'provinsi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'provinsi,nama'];
			$this->form[] = ['label'=>'Kota Id','name'=>'kota_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'kota,nama','parent_select'=>'provinsi_id'];
			$this->form[] = ['label'=>'Kode','name'=>'kode','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Nama','name'=>'nama','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			$this->form[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'text','validation'=>'min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Provinsi Id','name'=>'provinsi_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'provinsi,nama'];
			//$this->form[] = ['label'=>'Kota Id','name'=>'kota_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'kota,nama','parent_select'=>'provinsi_id'];
			//$this->form[] = ['label'=>'Kode','name'=>'kode','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Nama','name'=>'nama','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter the letter only'];
			//$this->form[] = ['label'=>'Keterangan','name'=>'keterangan','type'=>'text','validation'=>'min:1|max:255','width'=>'col-sm-10'];
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
			$this->index_button[] = ['label'=>'Import Data','url'=>action('AdminKecamatanController@getImportXls'),'icon'=>'fa fa-upload'];



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

		public function getImportXls() {
	    	return view('kecamatan_import');
		}
		public function postImportXls() {
	    	ini_set('memory_limit', '256M');
	    	set_time_limit(1000);

	    	$file = Request::file('userfile');
	    	$file->move(public_path('import'),$file->getClientOriginalName());

	    	\Excel::filter('chunk')->selectSheetsByIndex(0)->load(public_path('import/'.$file->getClientOriginalName()))->chunk(500,function($result) { 

				$no = 1;
				$sukses =0;
				$error = 0;
			    foreach($result->toArray() as $row) {
						   $a = [];	
						
						$prov = DB::table('provinsi')->where('kode',$row['kode_provinsi'])->orderBy('id','asc')->first();
					
						
						
						if ($prov) {
							$kota = DB::table('kota')
							->where('kode',$row['kode_kota'])
							->where('provinsi_id',$prov->id)
							->orderBy('id','asc')
							->first();

							if($kota){
								$kec = DB::table('kecamatan')
								->where('kode',$row['kode_kecamatan'])
								->where('kota_id',$kota->id)
								->where('provinsi_id',$prov->id)->orderBy('id','asc')
								->first();

								if($kec){
									echo $no.' | '.$row['kode_provinsi'].$row['kode_kota'].$row['kode_kecamatan'].' | '.$row['nama'].' | Failed import, kode Kecamatan sudah ada<br/>';
									// echo $no.' | '.$row['kode_kecamatan'].' | '.$row['nama'].' | Failed import, kode Kecamatan sudah ada<br/>';
									$no++;
									$error++;
								}else{

									$a['provinsi_id'] = $prov->id;
									$a['kota_id'] = $kota->id;
									$a['kode'] = $row['kode_kecamatan'];
									$a['nama'] = $row['nama'];
									$a['kode_pos'] = $row['kode_pos'];
									$a['keterangan'] = $row['keterangan'];
									DB::table('kecamatan')->insert($a);
									// echo $no.' | '.$row['kode_provinsi'].$row['kode_kota'].$row['kode_kecamatan'].' | '.$row['nama'].' | Success import,<br/>';
									// $no++;
									$sukses++;
								}
							}
							else{
								echo $no.' | '.$row['kode_kota'].' | '.$row['nama'].' | Failed import, kode Kota tidak terdaftar<br/>';
									$no++;
									$error++;
							}
						}
						else{
							echo $no.' | '.$row['kode_provinsi'].' | '.$row['nama'].' | Failed import, kode Provinsi tidak terdaftar<br/>';
							$no++;
							$error++;
						}
						
						
					}
						echo '<br/>DONE, total data Sukses '.$sukses.' data. Total Data Error '.$error.' data.';
			});
		}


	    //By the way, you can still create your own method in here... :) 


	}