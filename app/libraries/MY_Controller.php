<?php

class MY_Controller extends Controller
{
	protected $ACTUAL_MODULE;                                                   // Nombre del modulo en uso.
	protected $default_menu;
	protected $INNER_JS_DATA = NULL;                                            // Arreglo con los datos dinamicos para el JScript interno
    protected $COMP_NIT;
    protected $COMP_NAME;
    
	public function __construct()
	{
		parent::__construct();
            
		if(!$this->session->userdata('logged_in'))
			redirect('auth/inicio');
			
		$this->ACTUAL_MODULE = $this->uri->segment(1);
        $this->COMP_NIT = $this->session->userdata('com_nit');
        $this->COMP_NAME = $this->session->userdata('com_nom');

		$this->default_menu = array (
				 array('val' => '<img src="'.base_url().'assets/images/add-files.png" />','title' => 'Agregar una Registro'),
				 array('val' => '<img src="'.base_url().'assets/images/search.png" />','title' => 'Buscar un registro'),
				 array('val' => '<img src="'.base_url().'assets/images/pdf.png" />','title' => 'Exportar a PDF'),
				 array('val' => '<img src="'.base_url().'assets/images/xls.png" />','title' => 'Exportar a Excel')
		);

		$this->output->enable_profiler( $this->config->item('enable_profiler') );
	}

    /**
     * run
     *
     * Funcion principal para cargar una vista de NERP,
     * esta se encarga de cargar archivjs javascript y css pedido por los controladores.
     * a su vez carga el archivo javascript y css propios de cada modulo.
     * este utilizara el template referenciado en la configuracion de nerp layour.
     *
     * @param String $view      Nombre de la vista dinamica a cargar
     * @param Array $content    Arreglo con las variables que se enviaran a la vista dinamica
     * @param String $title     Titulo del modulo
     * @param Array $menu       Arreglo con los items del menu
     * @param Array $js         Arreglo con los archivos javascript a cargar
     * @param Array $css        Arreglo con los archivos css a cargar
     */

    protected function run( $view, $content=null,$title = '::  ::', $menu = null, $js=null, $css=null, $inner_js_file = null)
	{
            if(is_array($content)) $content = array_merge( $content,array
                (
                    'company_nit' => $this->COMP_NIT,
                    'company_name' => $this->COMP_NAME,
                    'bod_cod'      => $this->session->userdata('bod_cod'),
                    'bod_nom'      => $this->session->userdata('bod_nom')
                )
                );
            $this->INNER_JS_DATA = array('bod_cod' => $this->session->userdata('bod_cod'));
            // Titulo
            $data['title'] = ':: ' . $this->ACTUAL_MODULE . ' :: ';
            $data['mod_title'] =$title;

            // Menu del modulo
            $data['mod_menu'] = $this->generate_mod_menu($menu);
            
            // external assets
            $jsfiles 	= (is_array($js)) ? array_merge( $this->config->item('js','assets'),$js ) : $this->config->item('js','assets');
            $cssfiles 	= (is_array($css)) ? array_merge( $this->config->item('css','assets'),$css ) : $this->config->item('css','assets');

            $data['jsfiles'] 	= implode(array_map('map_jsitem',$jsfiles));
            $data['cssfiles'] 	= implode(array_map('map_cssitem',$cssfiles));

            // Archivo javascript interno del modulo
            if(is_null($inner_js_file))
            {
                $jsfile = $this->add_js_file();
                $data['jsfile'] = ( $jsfile == FALSE) ? NULL : $this->load->module_view($this->ACTUAL_MODULE, $jsfile,$this->INNER_JS_DATA, true);
            }
            else
            {
                $data['jsfile']= $this->load->module_view($this->ACTUAL_MODULE, $inner_js_file,$this->INNER_JS_DATA, true);
            }
            
            // cargar la vista dinamica
            $data['content'] = $this->load->module_view
                                            (
                                                $this->ACTUAL_MODULE,
                                                $view,
                                                $content,
                                                TRUE
                                            );

            // cargar el menu del modulo
            $data['left_menu'] = $this->load->module_view
                                                        (
                                                        $this->ACTUAL_MODULE,
                                                        $this->config->item('module_menu','files'),
                                                        NULL,
                                                        TRUE
                                                        );
            // cargar el layout principal
            $this->load->view(
                            $this->config->item('layout','files'),
                            $data
                            );
	}

    /**
     * add_js_file
     *
     * Revisa que exista un archivo js especial de un modulo
     * y lo agrega a la vista
     */
    protected function add_js_file()
    {
       $file = APPPATH . 'modules/'.$this->ACTUAL_MODULE .'/views/'.$this->config->item('jsfile','files');

       if(file_exists($file))
           return $this->config->item('jsfile','files');
       return FALSE;
    }
    
	private function generate_mod_menu( $items )
	{
            if(!is_array($items))
                    return '';

            $menu  = '<ul class="n_mod_menu">';

                    foreach( $items as $key => $val):
                            $href = ( isset( $val['href']) ) ? $val['href']: '';
                            $id   = ( isset( $val['id']  )   ) ? $val['id'] : '' ;
                            $callback   = (isset($val['callback'])) ? $val['callback'] : '';
                            $value   = '';
                            $title   = ( isset( $val['title']  )   ) ? $val['title'] : '' ;
                            $class   = ( isset( $val['class']  )   ) ? $val['class'] : '' ;
                            $menu .= '<li> <a title="'.$title.'" href="'.$href.'"  id="'.$id.'"  class="'.$class.'"  onclick="'.$callback.'">'. $val['val']. '</a> </li>';
                    endforeach;

            $menu .= '</ul>';

            return $menu;
	}

	
	public function info( $key, $field= NULL, $fieldname=NULL )
	{
            if(!isset($this->_main_table) || !isset($this->_key))
                    return 0;

            $data = $this->db->get_where( $this->_main_table,array($this->_key => $key) );

            if($data->num_rows() > 0)
            {
                    $data = $data->row_array();

                    if( is_null($field) )
                    {
                            $table = '<table>';
                                    foreach( $data as $key => $value ):
                                            if( $key !== $this->_key )  $table .= '<tr><td>'.utf8_decode($value).'</td></tr>';
                                    endforeach;
                            $table .='</table>';

                            echo $table;
                    }
                    else
                    {
                            echo $fieldname . ': ' . $data[$field];
                            return;
                    }
            }
            else
            {
                    echo '';
                    return;
            }
	}


   function ajax_result($ret=null,$msg=null,$arreglo=null){
    $datos = Array('ret'=>$ret,'msg'=>$msg);
    if(!is_null($arreglo)) $datos = array_merge ($datos,$arreglo);
    echo json_encode($datos);
    }
    
    
     protected function imprimir( $view, $content=null,$title = ':: NERP ::', $menu = null, $js=null, $css=null, $inner_js_file = null)
	{
            if(is_array($content)) $content = array_merge( $content,array
                (
                    'company_nit' => $this->COMP_NIT,
                    'company_name' => $this->COMP_NAME,
                    'bod_cod'      => $this->session->userdata('bod_cod'),
                    'bod_nom'      => $this->session->userdata('bod_nom')
                )
                );
            $this->INNER_JS_DATA = array('bod_cod' => $this->session->userdata('bod_cod'));
            // Titulo
            $data['title'] = ':: ' . $this->ACTUAL_MODULE . ' :: ';
            $data['mod_title'] =$title;

            // Menu del modulo
            $data['mod_menu'] = $this->generate_mod_menu($menu);
            
            // external assets
            $jsfiles 	= (is_array($js)) ? array_merge( $this->config->item('js','assets'),$js ) : $this->config->item('js','assets');
            $cssfiles 	= (is_array($css)) ? array_merge( $this->config->item('css','assets'),$css ) : $this->config->item('css','assets');

            $data['jsfiles'] 	= implode(array_map('map_jsitem',$jsfiles));
            $data['cssfiles'] 	= implode(array_map('map_cssitem',$cssfiles));

            // Archivo javascript interno del modulo
            if(is_null($inner_js_file))
            {
                $jsfile = $this->add_js_file();
                $data['jsfile'] = ( $jsfile == FALSE) ? NULL : $this->load->module_view($this->ACTUAL_MODULE, $jsfile,$this->INNER_JS_DATA, true);
            }
            else
            {
                $data['jsfile']= $this->load->module_view($this->ACTUAL_MODULE, $inner_js_file,$this->INNER_JS_DATA, true);
            }
            
            // cargar la vista dinamica
            $data['content'] = $this->load->module_view
                                            (
                                                $this->ACTUAL_MODULE,
                                                $view,
                                                $content,
                                                TRUE
                                            );

            // cargar el menu del modulo
            $data['left_menu'] = $this->load->module_view
                                                        (
                                                        $this->ACTUAL_MODULE,
                                                        $this->config->item('module_menu','files'),
                                                        NULL,
                                                        TRUE
                                                        );
            // cargar el layout principal
            $this->load->view(
                            'template_impresion_view',
                            $data
                            );
	}
        
        
     protected function module_imprimir($module, $view, $content=null,$title = ':: NERP ::', $menu = null, $js=null, $css=null, $inner_js_file = null)
	{
         $this->ACTUAL_MODULE=$module;
            if(is_array($content)) $content = array_merge( $content,array
                (
                    'company_nit' => $this->COMP_NIT,
                    'company_name' => $this->COMP_NAME,
                    'bod_cod'      => $this->session->userdata('bod_cod'),
                    'bod_nom'      => $this->session->userdata('bod_nom')
                )
                );
            $this->INNER_JS_DATA = array('bod_cod' => $this->session->userdata('bod_cod'));
            // Titulo
            $data['title'] = ':: ' . $this->ACTUAL_MODULE . ' :: ';
            $data['mod_title'] =$title;

            // Menu del modulo
            $data['mod_menu'] = $this->generate_mod_menu($menu);
            
            // external assets
            $jsfiles 	= (is_array($js)) ? array_merge( $this->config->item('js','assets'),$js ) : $this->config->item('js','assets');
            $cssfiles 	= (is_array($css)) ? array_merge( $this->config->item('css','assets'),$css ) : $this->config->item('css','assets');

            $data['jsfiles'] 	= implode(array_map('map_jsitem',$jsfiles));
            $data['cssfiles'] 	= implode(array_map('map_cssitem',$cssfiles));

            // Archivo javascript interno del modulo
            if(is_null($inner_js_file))
            {
                $jsfile = $this->add_js_file();
                $data['jsfile'] = ( $jsfile == FALSE) ? NULL : $this->load->module_view($this->ACTUAL_MODULE, $jsfile,$this->INNER_JS_DATA, true);
            }
            else
            {
                $data['jsfile']= $this->load->module_view($this->ACTUAL_MODULE, $inner_js_file,$this->INNER_JS_DATA, true);
            }
            
            // cargar la vista dinamica
            $data['content'] = $this->load->module_view
                                            (
                                                $this->ACTUAL_MODULE,
                                                $view,
                                                $content,
                                                TRUE
                                            );

            // cargar el menu del modulo
            $data['left_menu'] = $this->load->module_view
                                                        (
                                                        $this->ACTUAL_MODULE,
                                                        $this->config->item('module_menu','files'),
                                                        NULL,
                                                        TRUE
                                                        );
            // cargar el layout principal
            $this->load->view(
                            'template_impresion_view',
                            $data
                            );
	}    


        function permiso(){
          if( $this->session->userdata('rol')==1 || $this->session->userdata('rol')==2 ){
              return true;
          } else{
            return false;  
          } 
        }
        
        
}
