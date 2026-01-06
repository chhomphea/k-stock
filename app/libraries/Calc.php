<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calc
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}
	public function percentage($initial, $final)
	{
		return number_format((-100) * (($final - $initial) / $initial), 2) . ' %';
	}
	public function usd($price)
	{
		return number_format($price, 2);
	}
	public function khr($price)
	{
		return number_format($price, 0);
	}
	public function calc($price, $discount, $currency = '')
	{
		$amount = 0;
		$response_discount = '';
		$pos = strpos($discount, '%');
		if ($pos === false) {
			$discount = (float)$discount;
			$amount = $price - $discount;
			$response_discount = $discount;
			if ($currency) {
				$response_discount = $discount . ' ' . $currency;
			}
		} else {
			$discount = (float)$discount;
			$amount = $price - (($discount * $price) / 100);
			$response_discount = $discount . ' %';
		}
		$response = array(
			'net_price' => number_format($amount, 2, '.', ''),
			'discount' => $response_discount,
		);
		return (object)$response;
	}
	public function sizeName($product_id, $variant_id) {
		$builder = $this->ci->db->select("colors.*, GROUP_CONCAT(sizes.id) AS sizes", FALSE)
        ->from('sma_product_variants_colors colors')
        ->join('sma_product_variants_sizes sizes', 'sizes.variant_id = colors.id', 'LEFT')
        ->where('colors.product_id', $product_id)
        ->where('colors.id', $variant_id)
        ->group_by('colors.id')
        ->get();
        if ($builder->num_rows()) {
        	$row = $builder->row_array();
        	$size = strpos($row['sizes'], ',');
        	if ($size === false) {
        		return false;
        	} else {
        		return true;
        	}
	    }
	}
}
