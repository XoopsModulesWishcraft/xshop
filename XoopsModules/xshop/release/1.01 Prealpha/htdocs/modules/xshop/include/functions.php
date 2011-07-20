<?php

	function xshop_md5calc($object) {
		if (is_object($object)&&isset($object->vars)) {
			foreach($object->vars as $key => $item) {
				if (!in_array($key, array('md5', 'created', 'updated', 'actioned')))
					$ret .= md5($item['value']);
			}
			return md5($ret);
		} else {
			return md5($object);
		}
	}
	
?>