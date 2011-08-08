<?php

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}


$modversion['dirname'] 		= basename(dirname(__FILE__));
$modversion['name'] 		= ucfirst(basename(dirname(__FILE__)));
$modversion['version']     	= "1.06";
$modversion['releasedate'] 	= "2011-08-08";
$modversion['status']      	= "RC";
$modversion['description'] 	= _SHOP_MI_DESCRIPTION;
$modversion['credits']     	= _SHOP_MI_CREDITS;
$modversion['author']      	= "Wishcraft";
$modversion['help']        	= "";
$modversion['license']     	= "GPL 2.0";
$modversion['official']    	= 1;
$modversion['image']       	= "images/xshop_slogo.png";


// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Main
$modversion['hasMain'] = 1;

$i=0;
$modversion['tables'][$i++] = 'shop_addresses';
$modversion['tables'][$i++] = 'shop_category';
$modversion['tables'][$i++] = 'shop_contacts';
$modversion['tables'][$i++] = 'shop_country';
$modversion['tables'][$i++] = 'shop_currency';
$modversion['tables'][$i++] = 'shop_days';
$modversion['tables'][$i++] = 'shop_downloads';
$modversion['tables'][$i++] = 'shop_extra';
$modversion['tables'][$i++] = 'shop_field';
$modversion['tables'][$i++] = 'shop_gallery';
$modversion['tables'][$i++] = 'shop_items';
$modversion['tables'][$i++] = 'shop_items_digest';
$modversion['tables'][$i++] = 'shop_manufacturer';
$modversion['tables'][$i++] = 'shop_orders';
$modversion['tables'][$i++] = 'shop_orders_connotes';
$modversion['tables'][$i++] = 'shop_orders_digest';
$modversion['tables'][$i++] = 'shop_products';
$modversion['tables'][$i++] = 'shop_regions';
$modversion['tables'][$i++] = 'shop_shipping';
$modversion['tables'][$i++] = 'shop_shops';
$modversion['tables'][$i++] = 'shop_visibility';

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Install Script
$modversion['onInstall'] = "include/install.php";

// Update Script
//$modversion['onUpdate'] = "include/onupdate.php";

// Update Script
$modversion['onUninstall'] = "include/uninstall.php";

$i = 0;
// Config items
xoops_load('XoopsEditorHandler');
$editor_handler = XoopsEditorHandler::getInstance();
foreach ($editor_handler->getList(false) as $id => $val)
	$options[$val] = $id;
	
$i++;
$modversion['config'][$i]['name'] = 'editor';
$modversion['config'][$i]['title'] = "_SHOP_MI_EDITOR";
$modversion['config'][$i]['description'] = "_SHOP_MI_EDITOR_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'tinymce';
$modversion['config'][$i]['options'] = $options;

$options=array();
$options[_SHOP_MI_SECONDS_1DAYS] = 60*60*24*1;
$options[_SHOP_MI_SECONDS_3DAYS] = 60*60*24*3;
$options[_SHOP_MI_SECONDS_7DAYS] = 60*60*24*7;
$options[_SHOP_MI_SECONDS_14DAYS] = 60*60*24*14;
$options[_SHOP_MI_SECONDS_30DAYS] = 60*60*24*30;
$options[_SHOP_MI_SECONDS_60DAYS] = 60*60*24*60;
$options[_SHOP_MI_SECONDS_90DAYS] = 60*60*24*90;
$options[_SHOP_MI_SECONDS_180DAYS] = 60*60*24*180;
$options[_SHOP_MI_SECONDS_270DAYS] = 60*60*24*270;
$options[_SHOP_MI_SECONDS_365DAYS] = 60*60*24*365;

$i++;
$modversion['config'][$i]['name'] = 'offline';
$modversion['config'][$i]['title'] = '_SHOP_MI_OFFLINE';
$modversion['config'][$i]['description'] = '_SHOP_MI_OFFLINE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*60;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'keep';
$modversion['config'][$i]['title'] = '_SHOP_MI_KEEP';
$modversion['config'][$i]['description'] = '_SHOP_MI_KEEP_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*60;
$modversion['config'][$i]['options'] = $options;


$groups_handler =& xoops_gethandler('group');
$i++;
$modversion['config'][$i]['name'] = 'brokers';
$modversion['config'][$i]['title'] = '_SHOP_MI_BROKERS';
$modversion['config'][$i]['description'] = '_SHOP_MI_BROKERS_DESC';
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$criteria = new Criteria('group_type', _SHOP_MI_GROUP_TYPE_BROKER);
$group = $groups_handler->getObjects($criteria);
if (is_object($group[0]))
	$modversion['config'][$i]['default'] = $group[0]->getVar('groupid');

$groups_handler =& xoops_gethandler('group');
$i++;
$modversion['config'][$i]['name'] = 'sales';
$modversion['config'][$i]['title'] = '_SHOP_MI_SALES';
$modversion['config'][$i]['description'] = '_SHOP_MI_SALES_DESC';
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$criteria = new Criteria('group_type', _SHOP_MI_GROUP_TYPE_SALES);
$group = $groups_handler->getObjects($criteria);
if (is_object($group[0]))
	$modversion['config'][$i]['default'] = $group[0]->getVar('groupid');
	
$i++;
$modversion['config'][$i]['name'] = 'admins';
$modversion['config'][$i]['title'] = '_SHOP_MI_ADMINISTRATORS';
$modversion['config'][$i]['description'] = '_SHOP_MI_ADMINISTRATORS_DESC';
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = XOOPS_GROUP_ADMIN;

$options = array();
$currency_handler = xoops_getmodulehandler('currency', 'xshop');
foreach($currency_handler->getObjects(NULL, true) as $key => $value) {
	$options[$value->getVar('iso_code')] = $key;
}
$i++;
$modversion['config'][$i]['name'] = 'currency';
$modversion['config'][$i]['title'] = '_SHOP_MI_DEFAULTCURRENCY';
$modversion['config'][$i]['description'] = '_SHOP_MI_DEFAULTCURRENCY_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'payment_currency';
$modversion['config'][$i]['title'] = '_SHOP_MI_PAYMENTCURRENCY';
$modversion['config'][$i]['description'] = '_SHOP_MI_PAYMENTCURRENCY_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'check_rates';
$modversion['config'][$i]['title'] = '_SHOP_MI_CHECKRATES';
$modversion['config'][$i]['description'] = '_SHOP_MI_CHECKRATES_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*4;
$modversion['config'][$i]['options'] = array();

$options = array();
$xlanguage_handler = xoops_getmodulehandler('xlanguage_ext', 'xshop');
foreach($xlanguage_handler->getLanguages() as $key => $value) {
	$options[$value] = $key;
}
$i++;
$modversion['config'][$i]['name'] = 'language';
$modversion['config'][$i]['title'] = '_SHOP_MI_DEFAULTLANGUAGE';
$modversion['config'][$i]['description'] = '_SHOP_MI_DEFAULTLANGUAGE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'english';
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'combine';
$modversion['config'][$i]['title'] = '_SHOP_MI_COMBINESHOPS';
$modversion['config'][$i]['description'] = '_SHOP_MI_COMBINESHOPS_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'tax_rate';
$modversion['config'][$i]['title'] = '_SHOP_MI_TAX_RATE';
$modversion['config'][$i]['description'] = '_SHOP_MI_TAX_RATE_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'autotax';
$modversion['config'][$i]['title'] = '_SHOP_MI_AUTOTAX';
$modversion['config'][$i]['description'] = '_SHOP_MI_AUTOTAX_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;
$modversion['config'][$i]['options'] = array();

$options = array("AFGHANISTAN" => "AF", "ALAND ISLANDS" => "AX", "ALBANIA" => "AL", "ALGERIA" => "DZ", "AMERICAN SAMOA" => "AS", "ANDORRA" => "AD", "ANGOLA" => "AO", "ANGUILLA" => "AI", "ANTARCTICA" => "AQ", "ANTIGUA AND BARBUDA" => "AG", "ARGENTINA" => "AR", "ARMENIA" => "AM", "ARUBA" => "AW", "AUSTRALIA" => "AU", "AUSTRIA" => "AT", "AZERBAIJAN" => "AZ", "BAHAMAS" => "BS", "BAHRAIN" => "BH", "BANGLADESH" => "BD", "BARBADOS" => "BB", "BELARUS" => "BY", "BELGIUM" => "BE", "BELIZE" => "BZ", "BENIN" => "BJ", "BERMUDA" => "BM", "BHUTAN" => "BT", "BOLIVIA, PLURINATIONAL STATE OF" => "BO", "BONAIRE, SAINT EUSTATIUS AND SABA" => "BQ", "BOSNIA AND HERZEGOVINA" => "BA", "BOTSWANA" => "BW", "BOUVET ISLAND" => "BV", "BRAZIL" => "BR", "BRITISH INDIAN OCEAN TERRITORY" => "IO", "BRUNEI DARUSSALAM" => "BN", "BULGARIA" => "BG", "BURKINA FASO" => "BF", "BURUNDI" => "BI", "CAMBODIA" => "KH", "CAMEROON" => "CM", "CANADA" => "CA", "CAPE VERDE" => "CV", "CAYMAN ISLANDS" => "KY", "CENTRAL AFRICAN REPUBLIC" => "CF", "CHAD" => "TD", "CHILE" => "CL", "CHINA" => "CN", "CHRISTMAS ISLAND" => "CX", "COCOS (KEELING) ISLANDS" => "CC", "COLOMBIA" => "CO", "COMOROS" => "KM", "CONGO" => "CG", "CONGO, THE DEMOCRATIC REPUBLIC OF THE" => "CD", "COOK ISLANDS" => "CK", "COSTA RICA" => "CR", "COTE D'IVOIRE" => "CI", "CROATIA" => "HR", "CUBA" => "CU", "CURACAO" => "CW", "CYPRUS" => "CY", "CZECH REPUBLIC" => "CZ", "DENMARK" => "DK", "DJIBOUTI" => "DJ", "DOMINICA" => "DM", "DOMINICAN REPUBLIC" => "DO", "ECUADOR" => "EC", "EGYPT" => "EG", "EL SALVADOR" => "SV", "EQUATORIAL GUINEA" => "GQ", "ERITREA" => "ER", "ESTONIA" => "EE", "ETHIOPIA" => "ET", "FALKLAND ISLANDS (MALVINAS)" => "FK", "FAROE ISLANDS" => "FO", "FIJI" => "FJ", "FINLAND" => "FI", "FRANCE" => "FR", "FRENCH GUIANA" => "GF", "FRENCH POLYNESIA" => "PF", "FRENCH SOUTHERN TERRITORIES" => "TF", "GABON" => "GA", "GAMBIA" => "GM", "GEORGIA" => "GE", "GERMANY" => "DE", "GHANA" => "GH", "GIBRALTAR" => "GI", "GREECE" => "GR", "GREENLAND" => "GL", "GRENADA" => "GD", "GUADELOUPE" => "GP", "GUAM" => "GU", "GUATEMALA" => "GT", "GUERNSEY" => "GG", "GUINEA" => "GN", "GUINEA-BISSAU" => "GW", "GUYANA" => "GY", "HAITI" => "HT", "HEARD ISLAND AND MCDONALD ISLANDS" => "HM", "HOLY SEE (VATICAN CITY STATE)" => "VA", "HONDURAS" => "HN", "HONG KONG" => "HK", "HUNGARY" => "HU", "ICELAND" => "IS", "INDIA" => "IN", "INDONESIA" => "ID", "IRAN, ISLAMIC REPUBLIC OF" => "IR", "IRAQ" => "IQ", "IRELAND" => "IE", "ISLE OF MAN" => "IM", "ISRAEL" => "IL", "ITALY" => "IT", "JAMAICA" => "JM", "JAPAN" => "JP", "JERSEY" => "JE", "JORDAN" => "JO", "KAZAKHSTAN" => "KZ", "KENYA" => "KE", "KIRIBATI" => "KI", "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF" => "KP", "KOREA, REPUBLIC OF" => "KR", "KUWAIT" => "KW", "KYRGYZSTAN" => "KG", "LAO PEOPLE'S DEMOCRATIC REPUBLIC" => "LA", "LATVIA" => "LV", "LEBANON" => "LB", "LESOTHO" => "LS", "LIBERIA" => "LR", "LIBYAN ARAB JAMAHIRIYA" => "LY", "LIECHTENSTEIN" => "LI", "LITHUANIA" => "LT", "LUXEMBOURG" => "LU", "MACAO" => "MO", "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF" => "MK", "MADAGASCAR" => "MG", "MALAWI" => "MW", "MALAYSIA" => "MY", "MALDIVES" => "MV", "MALI" => "ML", "MALTA" => "MT", "MARSHALL ISLANDS" => "MH", "MARTINIQUE" => "MQ", "MAURITANIA" => "MR", "MAURITIUS" => "MU", "MAYOTTE" => "YT", "MEXICO" => "MX", "MICRONESIA, FEDERATED STATES OF" => "FM", "MOLDOVA, REPUBLIC OF" => "MD", "MONACO" => "MC", "MONGOLIA" => "MN", "MONTENEGRO" => "ME", "MONTSERRAT" => "MS", "MOROCCO" => "MA", "MOZAMBIQUE" => "MZ", "MYANMAR" => "MM", "NAMIBIA" => "NA", "NAURU" => "NR", "NEPAL" => "NP", "NETHERLANDS" => "NL", "NEW CALEDONIA" => "NC", "NEW ZEALAND" => "NZ", "NICARAGUA" => "NI", "NIGER" => "NE", "NIGERIA" => "NG", "NIUE" => "NU", "NORFOLK ISLAND" => "NF", "NORTHERN MARIANA ISLANDS" => "MP", "NORWAY" => "NO", "OMAN" => "OM", "PAKISTAN" => "PK", "PALAU" => "PW", "PALESTINIAN TERRITORY, OCCUPIED" => "PS", "PANAMA" => "PA", "PAPUA NEW GUINEA" => "PG", "PARAGUAY" => "PY", "PERU" => "PE", "PHILIPPINES" => "PH", "PITCAIRN" => "PN", "POLAND" => "PL", "PORTUGAL" => "PT", "PUERTO RICO" => "PR", "QATAR" => "QA", "REUNION" => "RE", "ROMANIA" => "RO", "RUSSIAN FEDERATION" => "RU", "RWANDA" => "RW", "SAINT BARTHELEMY" => "BL", "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA" => "SH", "SAINT KITTS AND NEVIS" => "KN", "SAINT LUCIA" => "LC", "SAINT MARTIN (FRENCH PART)" => "MF", "SAINT PIERRE AND MIQUELON" => "PM", "SAINT VINCENT AND THE GRENADINES" => "VC", "SAMOA" => "WS", "SAN MARINO" => "SM", "SAO TOME AND PRINCIPE" => "ST", "SAUDI ARABIA" => "SA", "SENEGAL" => "SN", "SERBIA" => "RS", "SEYCHELLES" => "SC", "SIERRA LEONE" => "SL", "SINGAPORE" => "SG", "SINT MAARTEN (DUTCH PART)" => "SX", "SLOVAKIA" => "SK", "SLOVENIA" => "SI", "SOLOMON ISLANDS" => "SB", "SOMALIA" => "SO", "SOUTH AFRICA" => "ZA", "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS" => "GS", "SPAIN" => "ES", "SRI LANKA" => "LK", "SUDAN" => "SD", "SURINAME" => "SR", "SVALBARD AND JAN MAYEN" => "SJ", "SWAZILAND" => "SZ", "SWEDEN" => "SE", "SWITZERLAND" => "CH", "SYRIAN ARAB REPUBLIC" => "SY", "TAIWAN, PROVINCE OF CHINA" => "TW", "TAJIKISTAN" => "TJ", "TANZANIA, UNITED REPUBLIC OF" => "TZ", "THAILAND" => "TH", "TIMOR-LESTE" => "TL", "TOGO" => "TG", "TOKELAU" => "TK", "TONGA" => "TO", "TRINIDAD AND TOBAGO" => "TT", "TUNISIA" => "TN", "TURKEY" => "TR", "TURKMENISTAN" => "TM", "TURKS AND CAICOS ISLANDS" => "TC", "TUVALU" => "TV", "UGANDA" => "UG", "UKRAINE" => "UA", "UNITED ARAB EMIRATES" => "AE", "UNITED KINGDOM" => "GB", "UNITED STATES" => "US", "UNITED STATES MINOR OUTLYING ISLANDS" => "UM", "URUGUAY" => "UY", "UZBEKISTAN" => "UZ", "VANUATU" => "VU", "VENEZUELA, BOLIVARIAN REPUBLIC OF" => "VE", "VIET NAM" => "VN", "VIRGIN ISLANDS, BRITISH" => "VG", "VIRGIN ISLANDS, U.S." => "VI", "WALLIS AND FUTUNA" => "WF", "WESTERN SAHARA" => "EH", "YEMEN" => "YE0", "ZAMBIA" => "ZM", "ZIMBABWE" => "ZW");
$i++;
$modversion['config'][$i]['name'] = 'countrycode';
$modversion['config'][$i]['title'] = '_SHOP_MI_COUNTRYCODE';
$modversion['config'][$i]['description'] = '_SHOP_MI_COUNTRYCODE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'AU';
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'district';
$modversion['config'][$i]['title'] = '_SHOP_MI_DISTRICT';
$modversion['config'][$i]['description'] = '_SHOP_MI_DISTRICT_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '2000';
$modversion['config'][$i]['options'] = array();

$i++;
$modversion['config'][$i]['name'] = 'city';
$modversion['config'][$i]['title'] = '_SHOP_MI_CITY';
$modversion['config'][$i]['description'] = '_SHOP_MI_CITY_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'Sydney';
$modversion['config'][$i]['options'] = array();

$options=array();
for($d=0;$d<100;$d++)
	$options[$d.'%'] = $d;
$i++;
$modversion['config'][$i]['name'] = 'ipdb_fraud_knockoff';
$modversion['config'][$i]['title'] = '_SHOP_MI_FRAUD_KNOCKOFF';
$modversion['config'][$i]['description'] = '_SHOP_MI_FRAUD_KNOCKOFF';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '93';
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'ipdb_fraud_kill';
$modversion['config'][$i]['title'] = '_SHOP_MI_FRAUD_KILL';
$modversion['config'][$i]['description'] = '_SHOP_MI_FRAUD_KILL_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;
$modversion['config'][$i]['options'] = array();
	
$i++;
$modversion['config'][$i]['name'] = 'htaccess';
$modversion['config'][$i]['title'] = "_SHOP_MI_HTACCESS";
$modversion['config'][$i]['description'] = "_SHOP_MI_HTACCESS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'baseurl';
$modversion['config'][$i]['title'] = "_SHOP_MI_BASEURL";
$modversion['config'][$i]['description'] = "_SHOP_MI_BASEURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'payment';

$i++;
$modversion['config'][$i]['name'] = 'endofurl';
$modversion['config'][$i]['title'] = "_SHOP_MI_ENDOFURL";
$modversion['config'][$i]['description'] = "_SHOP_MI_ENDOFURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.html';

$i++;
$modversion['config'][$i]['name'] = 'endofurl_pdf';
$modversion['config'][$i]['title'] = "_SHOP_MI_ENDOFURL_PDF";
$modversion['config'][$i]['description'] = "_SHOP_MI_ENDOFURL_PDF_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.pdf';

$i++;
$modversion['config'][$i]['name'] = 'memory_limit';
$modversion['config'][$i]['title'] = "_SHOP_MI_MEMORY_LIMIT";
$modversion['config'][$i]['description'] = "_SHOP_MI_MEMORY_LIMIT_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '128M';

$i++;
$modversion['config'][$i]['name'] = 'max_file_size';
$modversion['config'][$i]['title'] = "_SHOP_MI_MAX_FILE_SIZE";
$modversion['config'][$i]['description'] = "_SHOP_MI_MAX_FILE_SIZE_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1024*1024*3.75;

$i++;
$modversion['config'][$i]['name'] = 'image_mimetypes';
$modversion['config'][$i]['title'] = "_SHOP_MI_IMAGE_MIMETYPES";
$modversion['config'][$i]['description'] = "_SHOP_MI_IMAGE_MIMETYPES_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'textarea';
$modversion['config'][$i]['default'] = 'image/gif|image/jpeg|image/pjpeg|image/x-png';

$i++;
$modversion['config'][$i]['name'] = 'image_extensions';
$modversion['config'][$i]['title'] = "_SHOP_MI_IMAGE_EXTENSIONS";
$modversion['config'][$i]['description'] = "_SHOP_MI_IMAGE_EXTENSIONS_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'textarea';
$modversion['config'][$i]['default'] = 'gif|jpeg|pjpeg|png|jpg';

$i++;
$modversion['config'][$i]['name'] = 'thumbnail_width';
$modversion['config'][$i]['title'] = "_SHOP_MI_THUMBNAIL_WIDTH";
$modversion['config'][$i]['description'] = "_SHOP_MI_THUMBNAIL_WIDTH_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '140';

$i++;
$modversion['config'][$i]['name'] = 'thumbnail_height';
$modversion['config'][$i]['title'] = "_SHOP_MI_THUMBNAIL_HEIGHT";
$modversion['config'][$i]['description'] = "_SHOP_MI_THUMBNAIL_HEIGHT_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '140';

$i++;
$modversion['config'][$i]['name'] = 'orginal_width';
$modversion['config'][$i]['title'] = "_SHOP_MI_ORGINAL_WIDTH";
$modversion['config'][$i]['description'] = "_SHOP_MI_ORGINAL_WIDTH_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '420';

$i++;
$modversion['config'][$i]['name'] = 'download_mimetypes';
$modversion['config'][$i]['title'] = "_SHOP_MI_DOWNLOAD_MIMETYPES";
$modversion['config'][$i]['description'] = "_SHOP_MI_DOWNLOAD_MIMETYPES_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'textarea';
$modversion['config'][$i]['default'] = 'application/octet-stream|application/zip';

$i++;
$modversion['config'][$i]['name'] = 'download_extensions';
$modversion['config'][$i]['title'] = "_SHOP_MI_DOWNLOAD_EXTENSIONS";
$modversion['config'][$i]['description'] = "_SHOP_MI_DOWNLOAD_EXTENSIONS_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'textarea';
$modversion['config'][$i]['default'] = 'zip';

$i++;
$modversion['config'][$i]['name'] = 'salt';
$modversion['config'][$i]['title'] = "_SHOP_MI_SALT";
$modversion['config'][$i]['description'] = "_SHOP_MI_SALT_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = (mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'').(mt_rand(0,4)>2?chr(mt_rand(32,190)):'');

// Templates
$i = 0;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_shops_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_SHOPS_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_category_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_CATEGORY_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_products_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_PRODUCTS_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_orders_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_ORDERS_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_manufactures_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_MANUFACTURES_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_shipping_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_SHIPPING_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_discounts_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_DISCOUNTS_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_contacts_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_CONTACT_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_addresses_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_ADDRESSES_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_country_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_COUNTRY_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_region_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_REGION_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_items_digest_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_ITEM_DIGEST_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_gallery_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_GALLERY_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_autotax_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_AUTOTAX_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_downloads_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_DOWNLOADS_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_edit.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_EDIT;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cpanel_currency_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CPANEL_CURRENCY_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_categories_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CATEGORIES;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_category_item.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CATEGORY;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_manufacture_details.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_MANUFACTURE_DETAILS;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_manufactures_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_MANUFACTURES_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_manufacture_item.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_MANUFACTURE_ITEM;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_product_details.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_PRODUCT_DETAILS;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_products_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_PRODUCTS_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_product_item.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_PRODUCT_ITEM;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_shop_details.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_SHOP_DETAILS;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_shops_list.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_SHOP_LIST;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_shop_item.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_SHOP_ITEM;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_purchase_insert_small.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_PURCHASE_INSERT_SMALL;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_purchase_insert_large.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_PURCHASE_INSERT_LARGE;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_checkout.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CHECKOUT;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_orders.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_ORDERS;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_index.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_INDEX;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cart_insert_small.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CART_INSERT_SMALL;
$i++;
$modversion['templates'][$i]['file'] = 'xshop_cart.html';
$modversion['templates'][$i]['description'] = _SHOP_MI_TEMPLATE_CART;


xoops_load('xoopscache');
if (!class_exists('XoopsCache'))
	xoops_load('cache');
include_once($GLOBALS['xoops']->path('/modules/xshop/include/functions.php'));
$GLOBALS['user'] = xshop_getuser_id();
if ($ret['a'] = XoopsCache::read('xshop_cart_'.$GLOBALS['user']['uid'].'_'.$GLOBALS['user']['md5'])) {
	if ($ret['b'] = XoopsCache::read('xshop_cart_0_'.$GLOBALS['user']['md5'])){
		$caddy = array_merge($ret['a'], $ret['b']);		
	} else {
		$caddy = $ret['a'];
	}
}  else 
	$caddy = array();
$i = 0;
if (count($caddy)>0) {
	$i++;
	$modversion['sub'][$i]['name'] = _SHOP_MI_SHOPPING_CART;
	$modversion['sub'][$i]['url'] = "index.php?op=cart&fct=open";
}
$orders_handler = xoops_getmodulehandler('orders', 'xshop');
$criteria_a = new CriteriaCompo(new Criteria('user_key', $GLOBALS['user']['md5']), 'OR');
$criteria_a->add(new Criteria('uid', $GLOBALS['user']['uid']), 'OR');
$criteria = new CriteriaCompo($criteria_a, 'AND');
$criteria->add(new Criteria('`mode`', '_SHOP_MI_ORDER_OPENORDER'), "AND");
if ($orders_handler->getCount($criteria)>0) {
	$i++;
	$modversion['sub'][$i]['name'] = _SHOP_MI_ORDERS_OPEN;
	$modversion['sub'][$i]['url'] = "index.php?op=orders&fct=open";
}
$criteria = new CriteriaCompo($criteria_a, 'AND');
$criteria->add(new Criteria('`mode`', '_SHOP_MI_ORDER_CHECKEDOUT'), "AND");
if ($orders_handler->getCount($criteria)>0) {
	$i++;
	$modversion['sub'][$i]['name'] = _SHOP_MI_ORDERS_CHECKOUT;
	$modversion['sub'][$i]['url'] = "index.php?op=orders&fct=checkedout";
}
$criteria = new CriteriaCompo($criteria_a, 'AND');
$criteria->add(new Criteria('`mode`', '_SHOP_MI_ORDER_GONETOINVOICE'), "AND");
if ($orders_handler->getCount($criteria)>0) {
	$i++;
	$modversion['sub'][$i]['name'] = _SHOP_MI_ORDERS_INVOICED;
	$modversion['sub'][$i]['url'] = "index.php?op=orders&fct=invoiced";
}
$criteria = new CriteriaCompo($criteria_a, 'AND');
$criteria->add(new Criteria('`mode`', '_SHOP_MI_ORDER_CLOSEDORDER'), "AND");
if ($orders_handler->getCount($criteria)>0) {
	$i++;
	$modversion['sub'][$i]['name'] = _SHOP_MI_ORDERS_CLOSED;
	$modversion['sub'][$i]['url'] = "index.php?op=orders&fct=closed";
}



?>
