<?php
class ApiUpload
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	public function profile($filename = NULL)
	{ 
		$image = NULL;
		if ($_FILES[$filename]['size'] > 0) {
            $path = 'assets/uploads/register/';
            $this->MakeDirectory($path);
            $this->CI->load->library('upload');
            $config['upload_path'] = $path;
            $config['allowed_types'] = "gif|jpg|jpeg|png|tif";
            $config['max_size'] = 0;
            $config['encrypt_name'] = TRUE;
            $this->CI->upload->initialize($config);
            if (!$this->CI->upload->do_upload($filename)) {
                $error = $this->CI->upload->display_errors();
            }
            $image = $this->CI->upload->file_name;
        }
        return $image;
	}
    /**TODO:: Auto create folder **/
    public function MakeDirectory($path = '')
    {
        if ($path != '') {
            if (!file_exists($path)) {
                $oldmask = umask(0);
                mkdir($path, 0777, true);
                umask($oldmask);
            }
        }
    }
}