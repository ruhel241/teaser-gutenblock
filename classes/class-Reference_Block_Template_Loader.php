<?php
class Reference_Block_Template_Loader extends Gamajo_Template_Loader {
	protected $filter_prefix = 'reference-block';
	protected $theme_template_directory = 'reference-block-templates';
	protected $plugin_directory = REFERENCE_BLOCK_DIR;

	public function get_templates( $slug ){
		$paths = $this->get_template_paths();
		$templates = array();
		$files = array();
		foreach( $paths as $path ){
			$these_files = glob( $path.$slug.'*.php');
			if($these_files && !empty( $these_files )){
				foreach( $these_files as $file ){
					$this_file_info = get_file_data( $file, array( 
						'template_name' => 'Template Name'
					) );
					$this_file_info['path'] = $file;
					$this_file_info['basename'] = basename($file, '.php');
					/* if( $slug === $this_file_info['basename'] ){
						$this_file_info['basename'] = 'default';
					} */
					$files[] = $this_file_info;
				}
			}
		}

		//put base template first
		$key = array_search($slug , array_column($files, 'basename'));
		$mover = $files[$key];
		unset($files[$key]);
		array_unshift($files, $mover);
		return $files;
	}
}