<?php

class DatatableController extends Controller
{
    private function initDataAction($model)
    {
    	
    }


	public function getKendaraanAction($model)
	{
		$columns = array(
			0 => 'nopol',
			1 => 'jns_kendaraan',
			2 => 'nm_pemilik',
			3 => 'alamat_pemilik'
		);

		$totalData = Kendaraan::count();
		$limit = $_POST['length'];
		$start = $_POST['start'];
		$order =  $columns[$_POST['order'][0]['column']];
		$dir = $_POST['order'][0]['dir'];
		
		if(empty($_POST['search']['value'])){
			$posts = Kendaraan::offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();
			$totalFiltered = Kendaraan::count();
		}else{
			$search = $_POST['search']['value'];
			$posts = Kendaraan::where('nopol', 'like', "%{$search}%")
							->orWhere('jns_kendaraan','like',"%{$search}%")
							->orWhere('nm_pemilik','like',"%{$search}%")
							->orWhere('alamat_pemilik','like',"%{$search}%")
							->offset($start)
							->limit($limit)
							->orderBy($order, $dir)
							->get();
			$totalFiltered = Kendaraan::where('nopol', 'like', "%{$search}%")
							->orWhere('jns_kendaraan','like',"%{$search}%")
							->orWhere('nm_pemilik','like',"%{$search}%")
							->orWhere('alamat_pemilik','like',"%{$search}%")
							->count();
		}		
					
		
		$data = array();
		
		if($posts){
			foreach($posts as $r){
				$sub_array = array();
				foreach ($columns as $col) {
					$sub_array[] = '<div contenteditable class="update" data-id="'.$r->id.'" data-column_name="'.$col.'">'.$r->$col.'</div>';
				}
				$data[] = $sub_array;
			}
		}
		
		$json_data = array(
			"draw"			=> intval($_POST['draw']),
			"recordsTotal"	=> intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"			=> $data
		);
		
		echo json_encode($json_data);
	}
}
