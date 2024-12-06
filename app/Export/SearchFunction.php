<?php
namespace App\Export;

use Config;
use Illuminate\Routing\Controller as BaseController;


class SearchFunction extends BaseController 
{
    public function search($search){
        /*===搜尋條件Start====*/
		$search = collect($search)->filter(function ($v, $k) {
			return $k && $v['value'] !== '';
		})->all(); //濾掉沒填值的項目
		if (count($search) > 0) {

			/*----------------------把搜尋的function寫成參數----------------------*/
			$query = function ($search_qry) use ($search) {
				$max = count($search);
				$keys = array_keys($search);
				for ($i = 0; $i < $max; $i++) {
					$key = $keys[$i];
					$type = $search[$keys[$i]]['type'];
					$value = $search[$keys[$i]]['value'];
					/*-------------------------搜尋條件-------------------------*/
					switch ($type) {
						case "text":
							$cond1 = 'IFNULL(' . $key . ', \'\') LIKE ?';
							$cond2 = '%' . $value . '%';
							if ($i == 0) $search_qry->whereRaw($cond1, $cond2);
							else $search_qry->whereRaw($cond1, $cond2);
							break;
						case "radio":
							$cond1 = 'IFNULL(' . $key . ', \'0\') = ?';
							$cond2 = $value == 't' ? 1 : 0;
							if ($i == 0) $search_qry->whereRaw($cond1, $cond2);
							else $search_qry->whereRaw($cond1, $cond2);
							break;
						case "datePicker":
							if ($i == 0) $search_qry->whereDate($key, '=', $value);
							else $search_qry->whereDate($key, '=', $value);
							break;
						case "single_select":
							if ($value != 0 && $value != -1) {
								$cond = $key . ' = ?';
								if ($i == 0) $search_qry->whereRaw($cond, $value);
								else $search_qry->whereRaw($cond, $value);
							}
							break;
						case "dateRange":
							$date = explode(',', $value);
							if ($value != ',') {
								if ($i == 0) $search_qry->where($key, '>=', $date[0])->where($key, '<', date("Y-m-d", strtotime("+1 day", strtotime($date[1]))));
								else $search_qry->where(function ($query) use ($key, $date) {
									$query->where($key, '>=', $date[0]);
									$query->where($key, '<', date("Y-m-d", strtotime("+1 day", strtotime($date[1]))));
								});
							}

							break;
						default:
							break;
					}
					/*-------------------------搜尋條件-------------------------*/
				}
			};
			/*----------------------把搜尋的function寫成參數----------------------*/

			return $query;
		}else{
            return $query = '1=1';
        }
		// dd($data->toSql());
		/*===搜尋條件End====*/
    }
}