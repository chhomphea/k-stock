<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use JonnyW\PhantomJs\Client;
class ImageJs
{
	protected $ci;
	public function __construct()
	{
        $this->ci =& get_instance();
	}
	function getimage($suspend_id=null,$device_id=null,$user_id=null) {
		$client = Client::getInstance();
		$client->getEngine()->setPath(dirname(__FILE__).'/bin/phantomjs.exe');
		$printer_types  = $this->ci->site->getAllprinter($suspend_id);
		$quer_no    = $this->getquer_number();
		foreach ($printer_types as $printer_type) {
		    $request = $client->getMessageFactory()->createRequest(base_url('auth/page_order/'.$suspend_id.'/'.$printer_type->printer.'/'.$quer_no.'/'.$user_id), 'GET');
		    $request = $client->getMessageFactory()->createCaptureRequest(base_url('auth/page_order/'.$suspend_id.'/'.$printer_type->printer.'/'.$quer_no.'/'.$user_id), 'GET');
		    $request->setOutputFile('files/receipts/app_order_'.$printer_type->printer.$device_id.'.jpg');
		    $response = $client->getMessageFactory()->createResponse();
		    $client->send($request, $response);
		}
		if (sizeof($printer_types>0)) {
			 return true;
		}
	}
	function getquer_number(){
		$ordernumber = $this->ci->site->getquerNumber();
		$this->ci->site->reSetQuer();
		$this->ci->site->insertQuer($ordernumber);
        return $ordernumber;
	}
}
