<?php 
	
	$limit = 5;

	function getAllPageLinks($total_records, $current_page, $limit) {

		//Tong so trang
		$total_pages = ceil($total_records/$limit);
		
		$html = '';

		if ($total_pages <= 1) {
			$html .= '<li><span>&laquo;</span></li>';
	    	$html .= '<li class="active"><a onclick="viewData(1)" class="current_page">1</a></li>';
	    	$html .= '<li><span>&raquo;</span></li>';
	    	return $html;
		}
		
		//Gioi han trang
		if ($current_page > $total_pages) {
			$current_page = $total_pages;
		}

		if ($current_page < 1) {
			$current_page = 1;
		}

		$start = ($current_page -1)*$limit;

		// nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
		if ($current_page > 1 && $total_pages > 1){
	        $html .= '<li><a onclick="viewData('.($current_page-1).')">&laquo;</a></li>';
	        $html .= '<li><a onclick="viewData(1)">1</a></li>';
	    }else{
	    	$html .= '<li><span>&laquo;</span></li>';
	    	$html .= '<li class="active"><a onclick="viewData(1)" class="current_page">1</a></li>';
	    }

	    if ($current_page-2>1) {
	    	$html .= '<li><span>...</span></li>';
	    }
	    //Lap khoang giua
	    for ($i=$current_page-1; $i <= $current_page+1; $i++) { 
	    	if ($i<=1) {
	    		continue;
	    	}

	    	if ($i >= $total_pages) {
	    		break;
	    	}
	    	if ($i == $current_page) {
	    		$html .= '<li class="active"><a onclick="viewData('.($i).')" class="current_page">'.$i.'</a></li>';
	    	}else{
	    		$html .= '<li><a onclick="viewData('.($i).')">'.$i.'</a></li>';
	    	}
	    }

	    if (($total_pages - ($current_page+1))>1) {
	    	$html .= '<li><span>...</span></li>';
	    }

	    // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
	    if ($current_page < $total_pages && $total_pages > 1){
	    	$html .= '<li><a onclick="viewData('.($total_pages).')">'.$total_pages.'</a></li>';
	        $html .= '<li><a onclick="viewData('.($current_page+1).')">&raquo;</a></li>';
	    }else{
	    	$html .= '<li class="active"><a onclick="viewData('.($total_pages).')" class="current_page">'.$total_pages.'</a></li>';
	    	$html .= '<li><span>&raquo;</span></li>';
	    }

		return $html;
	}
	
?>