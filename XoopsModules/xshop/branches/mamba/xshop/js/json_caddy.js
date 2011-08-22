/**
 * Function for lodging caddy with product and quanity. Purchase only (Not Bidding)
 */

function doJSON_LodgeCaddy(xoops_url, dirname, product_id, uid, md5, ip, quanity, key, purchase_id) {
	var params = new Array();
 	$.getJSON(xoops_url+"/modules/"+dirname+"/dojson_lodgecaddy.php?product_id="+product_id+"&uid="+uid+"&md5="+md5+"&ip="+ip+"&quanity="+quanity+"&key="+key+"&purchase_id="+purchase_id, params, refreshformdesc);
}

function doJSON_ChangeCaddy(xoops_url, dirname, product_id, uid, md5, ip, quanity, key, purchase_id) {
	var params = new Array();
	$.getJSON(xoops_url+"/modules/"+dirname+"/dojson_changecaddy.php?product_id="+product_id+"&uid="+uid+"&md5="+md5+"&ip="+ip+"&quanity="+quanity+"&key="+key+"&purchase_id="+purchase_id, params, refreshformdesc);
}

function doJSON_CreateOrder(xoops_url, dirname, shop_id, uid, md5, ip, key, purchase_id) {
	var params = new Array();
	$.getJSON(xoops_url+"/modules/"+dirname+"/dojson_createorder.php?shop_id="+shop_id+"&uid="+uid+"&md5="+md5+"&ip="+ip+"&key="+key+"&purchase_id="+purchase_id, params, refreshformdesc);
}