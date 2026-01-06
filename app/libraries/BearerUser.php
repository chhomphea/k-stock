<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/php-jwt/JWT.php';
require_once APPPATH . 'third_party/php-jwt/BeforeValidException.php';
require_once APPPATH . 'third_party/php-jwt/ExpiredException.php';
require_once APPPATH . 'third_party/php-jwt/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

class BearerUser
{
    protected $key;
    protected $algorithm;
    protected $token_expire_time = 86400; 

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->config('jwt');
        $this->key        = $this->CI->config->item('jwt_key');
        $this->algorithm  = $this->CI->config->item('jwt_algorithm');
    }
    public function Info()
    {
        $auth = $this->BearerDecrypt();
        if ($auth['status']) {
            return $auth['data'];
        } else {
            return NULL;
        }
    }
    public function BearerEncrypt($data)
    {
        try {
            $token = JWT::encode($data, $this->key, $this->algorithm);
            return $token;
        }
        catch(Exception $e) {
            return 'Message: ' .$e->getMessage();
        }
    }
    public function BearerDecrypt()
    {
        if($this->CI->input->request_headers()['Authorization'] || $this->CI->input->request_headers()['authorization'])
        {
            $authorization = $this->CI->input->request_headers()['Authorization'] ? $this->CI->input->request_headers()['Authorization'] : $this->CI->input->request_headers()['authorization'];
            try
            {
                try {
                    $obj = JWT::decode(str_replace('Bearer ', '', $authorization), $this->key, array($this->algorithm));
                }
                catch(Exception $e) {
                    return ['status' => FALSE, 'message' => $e->getMessage()];
                }

                if(!empty($obj) AND is_object($obj))
                {
                    if(empty($obj->id)) 
                    {
                        return ['status' => FALSE, 'message' => 'User ID Not Define!'];
                    }else if(empty($obj->time OR !is_numeric($obj->time))) {
                        return ['status' => FALSE, 'message' => 'Token Time Not Define!'];
                    }
                    else
                    {
                        if ($this->CI->db->where('id', $obj->id)->get('users')->num_rows()) {
                            return ['status' => TRUE, 'data' => $obj];
                        } else {
                            return ['status' => FALSE, 'message' => 'Please check your account or login again.'];
                        }
                    }
                }else{
                    return ['status' => FALSE, 'message' => 'Forbidden'];
                }
            }
            catch(Exception $e) {
                return ['status' => FALSE, 'message' => $e->getMessage()];
            }
        }else
        {
            return ['status' => FALSE, 'message' => $jwt['message'] ];
        }
    }
}