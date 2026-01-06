<?php defined('BASEPATH') or exit('No direct script access allowed');

class Site extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllUnits() {
        $this->db->order_by('sort', 'asc');
        $this->db->where('delete', 0);
        // $this->db->where('status', 1);
        return $this->db->get('units')->result();
    }
    public function getAllCategories() {
        $this->db->order_by('code');
        $this->db->where('display', 1);
        $q = $this->db->get('categories');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllCustomers($limit = null)
    {if ($limit > 0) {
        $q = $this->db->get('customers', $limit);
    } else {
        $q = $this->db->get('customers');
    }

        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;}

    public function getAllprinters()
    {
        $this->db->order_by('title');
        $q = $this->db->get('printers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllStores()
    {
        $q = $this->db->get('stores');

        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllTaxs()
    {
        $q = $this->db->get('stores');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllSuppliers()
    {
        $q = $this->db->get('suppliers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getSupplierByID($id)
    {
        $q = $this->db->get_where('suppliers', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getAlltablebusy()
    {
        $this->db->select('c.id,c.name,c.table_group_name');
        $this->db->from('customers c');
        $this->db->join('suspended_sales su', 'su.customer_id = c.id');
        $this->db->group_by('id');
        return $this->db->get()->result();
    }
    public function getAlltablefree()
    {
        $this->db->select('c.id,c.name,c.table_group_name');
        $this->db->from('customers c');
        $this->db->join('suspended_sales su', 'su.customer_id = c.id', 'left');
        $this->db->where('su.id is null');
        $this->db->group_by('id');
        return $this->db->get()->result();
    }

    public function getAllUsers()
    {
        $this->db->select("{$this->db->dbprefix('users')}.id as id, first_name, last_name, {$this->db->dbprefix('users')}.email, company, {$this->db->dbprefix('groups')}.name as group, active, {$this->db->dbprefix('stores')}.name as store")
            ->join('groups', 'users.group_id=groups.id', 'left')
            ->join('stores', 'users.store_id=stores.id', 'left')
            ->group_by('users.id');
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getCategoryByCode($code)
    {
        $q = $this->db->get_where('categories', ['code' => $code], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getCategoryByID($id)
    {
        $q = $this->db->get_where('categories', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getCustomerByID($id)
    {
        $q = $this->db->get_where('customers', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getGiftCard($no)
    {
        $q = $this->db->get_where('gift_cards', ['card_no' => $no], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getGiftCardByID($id)
    {
        $q = $this->db->get_where('gift_cards', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getPrinterByID($id)
    {
        $q = $this->db->get_where('printers', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getTableByid($id)
    {
        $q = $this->db->get_where('tables', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getGroupTableByid($id)
    {
        $q = $this->db->get_where('group_tables', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getPriceGroupByid($id)
    {
        $q = $this->db->get_where('price_groups', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getProductByID($id, $store_id = null)
    {
        if (! $store_id) {
            $store_id = $this->session->userdata('store_id');
        }
        $jpsq = "( SELECT product_id, quantity, price from {$this->db->dbprefix('product_store_qty')} WHERE store_id = " . ($store_id ? $store_id : "''") . ' ) AS PSQ';
        // var_dump($jpsq);die();
        $this->db->select("{$this->db->dbprefix('products')}.*, COALESCE(PSQ.quantity, 0) as quantity, COALESCE(PSQ.price, {$this->db->dbprefix('products')}.price) as store_price", false)
            ->join($jpsq, 'PSQ.product_id=products.id', 'left');
        $q = $this->db->get_where('products', ['products.id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getQtyAlerts()
    {
        if (! $this->session->userdata('store_id')) {
            return 0;
        }
        $this->db->join("( SELECT (CASE WHEN quantity IS NULL THEN 0 ELSE quantity END) as quantity, product_id from {$this->db->dbprefix('product_store_qty')} WHERE store_id = {$this->session->userdata('store_id')} ) psq", 'products.id=psq.product_id', 'left')
            ->where("psq.quantity < {$this->db->dbprefix('products')}.alert_quantity", null, false)
            ->where('products.alert_quantity >', 0);
        return $this->db->count_all_results('products');
    }

    public function getSettings()
    {
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getStoreByID($id = null)
    {
        if (! $id) {
            return false;
        }
        $q = $this->db->get_where('stores', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getUpcomingEvents()
    {
        $dt = date('Y-m-d');
        $this->db->where('date >=', $dt)->order_by('date')->limit(5);
        if ($this->Settings->restrict_calendar) {
            $q = $this->db->get_where('calendar', ['user_id' => $this->session->userdata('iser_id')]);
        } else {
            $q = $this->db->get('calendar');
        }
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getUser($id = null)
    {
        if (! $id) {
            $id = $this->session->userdata('user_id');
        }
        $q = $this->db->get_where('users', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getUserGroup($user_id = null)
    {
        if ($group_id = $this->getUserGroupID($user_id)) {
            $q = $this->db->get_where('groups', ['id' => $group_id], 1);
            if ($q->num_rows() > 0) {
                return $q->row();
            }
        }
        return false;
    }

    public function getUserGroupID($user_id = null)
    {
        if ($user = $this->getUser($user_id)) {
            return $user->group_id;
        }
        return false;
    }

    public function getUsers()
    {
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getUserSuspenedSales()
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('id, date, customer_name, hold_ref')->order_by('id desc');
        $this->db->where('store_id', $this->session->userdata('store_id'));
        $q = $this->db->get_where('suspended_sales');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function registerData($user_id)
    {
        if (! $user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $q = $this->db->get_where('registers', ['user_id' => $user_id, 'status' => 'open'], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getAll_Baseunit($id = null)
    {
        $units = $this->db->get_where("units", ["base_unit" => '', 'delete' => 0]);
        return $units->result();
    }
    public function addUnit($unit = null, $id = null)
    {
        if ($id and $unit) {
            $this->db->where('id', $id)->update("units", $unit);
            return true;
        }
        if ($unit and $id == null) {
            $this->db->insert("units", $unit);
            return true;
        }
        return false;
    }
    public function getDataID($id = null, $table = null)
    {
        return $this->db->get_where($table, ['id' => $id])->row();

    }
    public function getAllgroupoption()
    {
        $q = $this->db->get_where('group_options', ['delete' => 0]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllgrouptable()
    {
        $q = $this->db->get_where('group_tables');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllUnit()
    {
        $q = $this->db->get_where('units', ['delete' => 0]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getGroupOptionById($id)
    {
        $q = $this->db->get_where('group_options', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getOptionById($id)
    {
        $q = $this->db->get_where('options', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getUnitsByID($id)
    {
        $q = $this->db->get_where('units', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getUnitsByBUID($base_unit = null, $purchase_unit = null, $base_units = null)
    {
        // var_dump($base_unit);die;
        if ($purchase_unit) {
            $this->db->where('id', $base_unit)->or_where('id', $purchase_unit)
                ->group_by('id')->order_by('id asc');
            $q = $this->db->get("units");
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
        } else if ($base_units > 0) {
            $this->db->where('base_unit', $base_unit)->or_where('id', $base_unit)->or_where('id', $base_units)->or_where('base_unit', $base_units)
                ->group_by('id')->order_by('id asc');
            $q = $this->db->get("units");
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
        } else {
            $this->db->where('base_unit', $base_unit)->or_where('id', $base_unit)
                ->group_by('id')->order_by('id asc');
            $q = $this->db->get("units");
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
        }
        return false;
    }
    public function updaterate($data = [], $id = null)
    {
        if ($data and $id) {
            $this->db->where('id', $id)->update("currencies", $data);
            return true;
        }
    }
    public function QuntityByoperationvalue($unit = null, $purchase_unit = null)
    {
        $this->db->select('*');
        $this->db->from('units');
        $this->db->where('id', $purchase_unit);
        $this->db->where('base_unit', $unit);
        return $this->db->get()->row();
    }

    public function getBankById($id)
    {
        $this->db->select('*');
        $this->db->from('bank');
        $this->db->where('id', $id);
        $sql = $this->db->get()->row();
        return $sql;
    }
    public function getAllcurrency()
    {
        $this->db->select('*');
        $this->db->from('currency');
        $s = $this->db->get()->result();
        return $s;
    }
    public function getmodifyitem($product_id)
    {
        $this->db->select('*')
            ->from('product_modify p')
            ->join('group_options i', 'p.modify_item_id=i.id')
            ->where('p.product_id', $product_id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function bank_tran($data = [])
    {
        if ($data) {
            $bank_id = $data['bank_id'];
            $this->db->insert('bank_transactions', $data);
            $amount = $this->getTotalBYbank($bank_id);
            $this->db->where('id', $bank_id)->update("bank", ['amount' => $amount]);
            return true;
        }
        return false;
    }
    public function getTotalBYbank($bank_id)
    {
        $this->db->select('SUM(amount) as balance');
        $this->db->from('bank_transactions');
        $this->db->where('bank_id', $bank_id);
        return $this->db->get()->row()->balance;
    }
    public function getSellingPrice($product = null)
    {
        $this->db->select('IFNULL(sell.unit_price,0) as unit_price,u.id,u.name,u.operation,u.operation_value,u.base_unit');
        $this->db->from('selling_prices sell');
        $this->db->join('units u', 'u.id = sell.unit_sale');
        $this->db->where('sell.product_id', $product);
        $this->db->group_by('unit_sale');
        $units   = $this->db->get()->result();
        $selling = [];
        $i       = 0;
        foreach ($units as $key => $row) {
            $i++;
            $selling[$i]['unit_price']      = $row->unit_price;
            $selling[$i]['id']              = $row->id;
            $selling[$i]['name']            = $row->name;
            $selling[$i]['operation']       = $row->operation;
            $selling[$i]['operation_value'] = $row->operation_value;
            if (! $row->operation_value and $row->base_unit < 1) {
                $new_unit = $this->db->get_where('units', ['base_unit' => $row->id])->row();
                if ($new_unit->operation == '*') {
                    $selling[$i]['operation']       = '/';
                    $selling[$i]['operation_value'] = $new_unit->operation_value ?? 1;
                }
                if ($new_unit->operation == '/') {
                    $selling[$i]['operation']       = '*';
                    $selling[$i]['operation_value'] = $new_unit->operation_value ?? 1;
                }
                if ($new_unit->operation == '+') {
                    $selling[$i]['operation']       = '-';
                    $selling[$i]['operation_value'] = $new_unit->operation_value ?? 1;
                }
                if ($new_unit->operation == '-') {
                    $selling[$i]['operation']       = '+';
                    $selling[$i]['operation_value'] = $new_unit->operation_value ?? 1;
                }
            }
        }
        $units = (array) $selling;
        return $units;
    }
    public function getproductsellingprice($product = null)
    {
        $this->db->select('sell.unit_price,u.id,u.name');
        $this->db->from('selling_prices sell');
        $this->db->join('units u', 'u.id = sell.unit_sale');
        $this->db->where('sell.product_id', $product);
        return $this->db->get()->result();
    }
    public function sellingpriceBYunit($product_id = null, $unit_id = null)
    {
        $this->db->select('*');
        $this->db->from('selling_prices');
        $this->db->where('product_id', $product_id);
        $this->db->where('unit_sale', $unit_id);
        return $this->db->get()->row();
    }
    public function itemTran($items = [])
    {
        if ($items) {
            $this->db->insert('transactions', $items);
            return true;
        }
        return false;
    }
    public function resetStock($purchase_id = null, $sale_id = null)
    {
        if ($purchase_id) {
            $this->db->where('purchase_id', $purchase_id)->where('status', 'purchase')->delete('transactions');
            return true;
        }
        if ($sale_id) {
            $this->db->where('sale_id', $sale_id)->where('status', 'sale')->delete('transactions');
            return true;
        }
    }
    public function QuantityProduct($product_id = null)
    {
        $store_id = $this->session->userdata('store_id');
        $this->db->select('SUM(quantity) as qty');
        $this->db->from('transactions');
        $this->db->where('product_id', $product_id);
        $this->db->where('store_id', $store_id);
        return $this->db->get()->row()->qty;
    }
    public function QuantityProduct_sold($product_id = null)
    {
        $store_id = $this->session->userdata('store_id');
        $this->db->select('SUM(IF(type="debit",quantity,0)) as stock_in,SUM(quantity) as currenct_stock');
        $this->db->from('transactions');
        $this->db->where('product_id', $product_id);
        $this->db->where('store_id', $store_id);
        $item = $this->db->get()->row();
        return ($item->stock_in - $item->currenct_stock);
    }
    public function getquantitysold($sale_id = null, $product_id = null, $type = null)
    {
        $this->db->select('SUM(quantity*(-1)) as qty');
        $this->db->from('transactions');
        if ($type == 'adjust') {
            $this->db->where('adjust_id', $sale_id);
        } else {
            $this->db->where('sale_id', $sale_id);
        }
        $this->db->where('product_id', $product_id);
        return $this->db->get()->row()->qty;
    }
    public function checkstockSaleold($product_id = null, $store_id = null, $quantity = null)
    {
        if ($balance + $quantity >= 0) {
            return true;
        }
        return false;
    }
    public function checkstockSale($items = [], $sale_id = null, $type = '')
    {
        $store_id = $this->session->userdata('store_id');
        $sale_qty = [];
        foreach ($items as $key => $row) {
            if ($row['from_store'] > 0) {
                $store_id = $row['from_store'];
            }
            $item_id  = $row['product_id'];
            $item_qty = $row['quantity'];
            $sale_qty[$item_id] += $item_qty;
        }
        foreach ($sale_qty as $key => $stock) {
            if ($type == 'adjust') {
                $stock = 0 - $stock;
            }
            $product_id = $key;
            $this->db->select('IFNULL(SUM(tran.quantity),0) as stock,products.type,products.name');
            $this->db->from('transactions tran');
            $this->db->join('products', 'products.id = tran.product_id');
            $this->db->where('tran.product_id', $product_id);
            $this->db->where('tran.store_id', $store_id);
            $product_details = $this->db->get()->row();
            if ($product_details->type == 'standard') {
                if ($sale_id) {
                    $sold_quantity          = $this->site->getquantitysold($sale_id, $product_id, $type);
                    $product_details->stock = $product_details->stock + $sold_quantity;
                }
                if ($product_details->type == 'standard' and $product_details->stock < $stock) {
                    $data['balance'] = $product_details->stock;
                    $data['ordered'] = $stock;
                    $data['name']    = $product_details->name;
                    return $data;
                }
            }
        }
        return true;
    }
    public function addavg_cost($item_id = null, $amount = null, $store_id = null, $total_cost = null)
    {
        $this->db->select('total_stock_cost as avg_cost,total_selling_cost as selling_cost,product_id');
        $this->db->from('costings');
        $this->db->where('product_id', $item_id);
        $this->db->where('store_id', $store_id);
        $costing = $this->db->get()->row();
        if (isset($costing->product_id)) {
            $avg_cost           = $this->tec->formatDecimal($costing->avg_cost) + $this->tec->formatDecimal($amount);
            $total_selling_cost = $this->tec->formatDecimal($costing->selling_cost) + $this->tec->formatDecimal($total_cost);
            $this->db->where('product_id', $item_id)->where('store_id', $store_id)->update('costings', ['total_stock_cost' => $avg_cost, 'total_selling_cost' => $total_selling_cost]);
            return true;
        } else {
            if ($amount > 0) {
                $item = [
                    'product_id'         => $item_id,
                    'store_id'           => $store_id,
                    'total_stock_cost'   => $this->tec->formatDecimal($amount),
                    'total_selling_cost' => $this->tec->formatDecimal($total_cost),
                ];
                $this->db->insert('costings', $item);
                return true;
            }
        }
        return false;
    }
    public function getavg_cost($store_id = null, $product_id = null)
    {
        $balance_quantity = $this->QuantityProduct($product_id);
        $this->db->select('total_stock_cost');
        $this->db->from('costings');
        $this->db->where('product_id', $product_id);
        $this->db->where('store_id', $store_id);
        $costing  = $this->db->get()->row()->total_stock_cost;
        $avg_cost = $this->db->get_where('products', ['id' => $product_id])->row->cost;
        if ($costing and $balance_quantity > 0) {
            $avg_cost = $costing / $balance_quantity;
        }
        return $avg_cost;
    }
    public function getavg_return($store_id = null, $product_id = null)
    {
        $balance_quantity = $this->QuantityProduct_sold($product_id);
        $this->db->select('total_selling_cost');
        $this->db->from('costings');
        $this->db->where('product_id', $product_id);
        $this->db->where('store_id', $store_id);
        $costing  = $this->db->get()->row()->total_selling_cost;
        $avg_cost = $this->db->get_where('products', ['id' => $product_id])->row->cost;
        if ($costing) {
            $avg_cost = $costing / $balance_quantity;
        }
        return $avg_cost;
    }
    public function getcostingsale($sale_id = null, $product_id = null)
    {
        $this->db->select('(total_cost) as cost');
        $this->db->from('transactions');
        $this->db->where('sale_id', $sale_id);
        $this->db->where('product_id', $product_id);
        return $this->db->get()->row()->cost;
    }
    public function getreference($type) {
        if ($type == 'adjust') {
            $this->db->select('IFNULL(MAX(no),0)+1 as no');
            $this->db->from('adjustments');
            $rows        = $this->db->get()->row()->no;
            $row->number = sprintf('AJ-' . "%05s", $rows);
            $row->no     = $rows;
            return $row;
        }
        if ($type == 'deposit') {
            $this->db->select('IFNULL(MAX(no),0)+1 as no');
            $this->db->from('invoices');
            $this->db->where('type','deposit');
            $rows        = $this->db->get()->row()->no;
            $row->number = sprintf('DP-' . "%05s", $rows);
            $row->no     = $rows;
            return $row;
        }
        if ($type == 'sale') {
            $this->db->select('IFNULL(MAX(no),0)+1 as no');
            $this->db->from('sales');
            $rows = $this->db->get()->row()->no;
            $row->number = sprintf(date('ym') . "%04s", $rows);
            $row->no     = $rows;
            return $row;
        }
        if ($type == 'po') {
            $this->db->select('IFNULL(MAX(no),0)+1 as no');
            $this->db->from('purchases');
            $rows        = $this->db->get()->row()->no;
            $row->number = sprintf('PO-' . "%05s", $rows);
            $row->no     = $rows;
            return $row;
        }
        if ($type == 'return') {
            $this->db->select('IFNULL(MAX(no),0)+1 as no');
            $this->db->from('sales');
            $this->db->where('sale_status', 'return');
            $rows        = $this->db->get()->row()->no;
            $row->number = sprintf('SL-' . "%05s", $rows);
            $row->no     = $rows;
            return $row;
        }
        if ($type == 'spay') {
            $this->db->select('IFNULL(MAX(no),0)+1 as no');
            $this->db->from('statements');
            $this->db->where('customer_id >', 1);
            $rows        = $this->db->get()->row()->no;
            $row->number = sprintf('SPAY-' . "%05s", $rows);
            $row->no     = $rows;
            return $row;
        }
        if ($type == 'ppay') {
            $this->db->select('IFNULL(MAX(no),0)+1 as no');
            $this->db->from('statements');
            $this->db->where('supplier_id >', 1);
            $rows        = $this->db->get()->row()->no;
            $row->number = sprintf('PPAY-' . "%05s", $rows);
            $row->no     = $rows;
            return $row;
        }
        if ($type == 'Transfer') {
            $this->db->select('IFNULL(MAX(no),0)+1 as no');
            $this->db->from('transfers');
            $rows        = $this->db->get()->row()->no;
            $row->number = sprintf('TF-' . "%05s", $rows);
            $row->no     = $rows;
            return $row;
        }
    }
    public function syncSalePayments($sale_id = null, $grand_total = null)
    {
        $this->db->select("SUM(amount) as paid");
        $this->db->from('payments');
        $this->db->where('sale_id', $sale_id);
        $total_paid     = $this->tec->formatDecimal($this->db->get()->row()->paid) ?? 0;
        $payment_status = 'due';
        if ($total_paid > 0 and $total_paid < $grand_total) {
            $payment_status = 'partial';
        } else if ($total_paid >= $grand_total) {
            $payment_status = 'paid';
        }
        $this->db->where('id', $sale_id)->update('sales', ['paid' => $total_paid, 'status' => $payment_status]);
        return true;
        return false;
    }
    public function syncPurchasesPayments($purchase_id = null, $grand_total = null)
    {
        $this->db->select("SUM(amount) as paid");
        $this->db->from('payments');
        $this->db->where('purchase_id', $purchase_id);
        $this->db->where('purchase_id >', 0);
        $total_paid     = $this->tec->formatDecimal($this->db->get()->row()->paid) ?? 0;
        $payment_status = 'due';
        if ($total_paid > 0 and $total_paid < $grand_total) {
            $payment_status = 'partial';
        } else if ($total_paid >= $grand_total) {
            $payment_status = 'paid';
        }
        $this->db->where('id', $purchase_id)->update('purchases', ['paid' => $total_paid, 'payment_status' => $payment_status]);
        return true;
    }
    public function synbankAmount($bank_id = null)
    {
        if ($bank_id) {
            $amount = $this->getTotalBYbank($bank_id) ?? 0;
            $this->db->where('id', $bank_id)->update("bank", ['amount' => $amount]);
            return true;
        }
        return false;
    }
    public function synStatment($statment_id = null, $amount = null)
    {
        if ($statment_id and $amount != 0) {
            $grand_total = $this->getDataID($statment_id, 'statements')->amount;
            $this->db->where('id', $statment_id)->update("statements", ['amount' => ($grand_total - $amount)]);
            return true;
        }
        return false;
    }
    public function getBankBySaleID($sale_id = null)
    {
        $this->db->select('ba.name,pay.amount');
        $this->db->from('payments pay');
        $this->db->join('bank ba', 'ba.id = pay.paid_by', 'Inner');
        $this->db->group_by('pay.paid_by');
        $this->db->where('sale_id', $sale_id);
        $s = $this->db->get()->result();
        return $s;
    }
    public function getProductID($id = null)
    {
        $q = $this->db->get('products', ['id' => $id]);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getTranStore()
    {
        $q = $this->db->get('stores');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getTranTStore()
    {
        $q = $this->db->get('transfers');
        if ($q->num_rows() > 0) {
            foreach (($q->row()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getTransfer_item()
    {
        $q = $this->db->get('transfer_items');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllWarehouse()
    {
        $q = $this->db->get('stores');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllexpenseType()
    {
        $q = $this->db->get('expensetype');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getproduct($category_id)
    {
        $this->db->select('products.name,products.price,products.image,categories.name as cname');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id');
        if ($category_id) {
            $this->db->where('categories.id', $category_id);
        }
        return $this->db->get()->result();
    }
    public function getAllprinter($suspend_id = null)
    {
        $this->db->select('pro.printer');
        $this->db->from('suspended_items si');
        $this->db->join('products pro', 'si.product_id = pro.id');
        $this->db->where('si.suspend_id', $suspend_id);
        $this->db->where('si.is_print <>1');
        $this->db->group_by('pro.printer');
        return $this->db->get()->result();
    }
    public function getunitStock($product_id = null, $unit_id = null, $stock_unit = null)
    {
        $unit = $this->site->getDataID($stock_unit, 'units');
        if ($unit->operation == '*') {
            $this->db->select('v.*,u.name as stock_unit');
            $this->db->from('view_stocks v');
            $this->db->join('units u', 'u.id = v.base_unit');
            $this->db->where('v.product_id', $product_id);
            $this->db->where('v.id', $stock_unit);
            $this->db->where('v.base_unit', $unit_id);
            $row             = $this->db->get()->row();
            $row->operation  = '/';
            $row->stock_unit = $row->name;
            return $row;
        } else {
            $this->db->select('v.*,u.name as stock_unit');
            $this->db->from('view_stocks v');
            $this->db->join('units u', 'u.id = v.base_unit');
            $this->db->where('v.product_id', $product_id);
            $this->db->where('v.id', $unit_id);
            $this->db->where('v.base_unit', $stock_unit);
            return $this->db->get()->row();
        }
    }
    public function getquerNumber()
    {
        $this->db->select('*');
        $this->db->from('ordernumbers');
        $row    = $this->db->get()->row();
        $number = sprintf("%03s", ($row->no) + 1);
        if ($row->no == null or $row->no == 100) {
            $number = sprintf("%03s", +1);
        }
        return $number;
    }
    public function reSetQuer()
    {
        $this->db->where('id', 1)->delete('ordernumbers');
        return true;
    }
    public function insertQuer($ordernumber = null)
    {
        $this->db->insert('ordernumbers', ['no' => $ordernumber, 'id' => 1]);
        return true;
    }
    public function getAllSubCategories()
    {
        $q = $this->db->get('subcategory');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllCategory()
    {
        $q = $this->db->get('categories');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getAllCategoriesview()
    {
        $this->db->select('*');
        $this->db->from('vcategories');
        return $this->db->get()->result();
    }
    public function getSubByID($id)
    {
        $q = $this->db->get_where('subcategory', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function Checkpromotion()
    {
        return 0;
    }
    public function insertTable($data = [], $table = null) {
        if ($this->db->insert($table, $data)) {
            return true;
        }
        return false;
    }
    public function updateTable($id = null, $data = [], $table = null) {
        if ($this->db->where('id', $id)->update($table, $data)) {
            return true;
        }
        return false;
    }
    function getAllBranches () {
        $this->db->select('*');
        $this->db->from('branches');
        $this->db->where('delete',0);
        $this->db->where('active',1);
        $this->db->order_by('order_display');
        return $this->db->get()->result();
    }
    function getAllFloors ($branch=null) {
        $this->db->select('*');
        $this->db->from('floors');
        $this->db->where('deleted',0);
        $this->db->where('active',1);
        if ($branch) {
            $this->db->where('branch_id', $branch);
        }
        $this->db->order_by('order_display');
        return $this->db->get()->result();
    }
    function getAllProducts () {
        $this->db->select('products.id,products.name,products.code,categories.name as category,units.name as unit,products.unit_id');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id');
        $this->db->join('units', 'units.id = products.unit_id');
        return $this->db->get()->result();
    }
    function getServices () {
        $this->db->select('*');
        $this->db->from('products');
        return $this->db->get()->result();
    }
    public function getAllBanks() {
        $this->db->select('*');
        $this->db->from('banks');
        $s = $this->db->get()->result();
        return $s;
    }
}
