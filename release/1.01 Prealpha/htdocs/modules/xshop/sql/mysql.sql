
CREATE TABLE `shop_addresses` (
  `address_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `manu_id` int(12) unsigned DEFAULT NULL,
  `shop_id` int(12) unsigned DEFAULT NULL,
  `order_id` int(12) unsigned DEFAULT NULL,
  `type` enum('_SHOP_MI_ADDRESS_MANUFACTURE','_SHOP_MI_ADDRESS_SHOP','_SHOP_MI_ADDRESS_POSTAL','_SHOP_MI_ADDRESS_DELIEVERY','_SHOP_MI_ADDRESS_ORDERBY','_SHOP_MI_ADDRESS_SHOW','_SHOP_MI_ADDRESS_OTHER') DEFAULT '_SHOP_MI_ADDRESS_DELIEVERY',
  `remittion` enum('_SHOP_MI_ADDRESS_RETURNEDGOODS','_SHOP_MI_ADDRESS_FRAUD','_SHOP_MI_ADDRESS_STOLENINMAIL','_SHOP_MI_ADDRESS_EXPRESSDELIEVERY','_SHOP_MI_ADDRESS_NONE') DEFAULT '_SHOP_MI_ADDRESS_NONE',
  `care_of` varchar(128) DEFAULT NULL,
  `address_line_1` varchar(128) DEFAULT NULL,
  `address_line_2` varchar(128) DEFAULT NULL,
  `suburb` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `region_id` int(12) unsigned DEFAULT '0',
  `country_id` int(12) unsigned DEFAULT '0',
  `postcode` varchar(15) DEFAULT NULL,
  `md5` varchar(32) DEFAULT NULL,
  `created` int(13) unsigned DEFAULT '0',
  `updated` int(13) unsigned DEFAULT '0',
  `actioned` int(13) unsigned DEFAULT '0',
  PRIMARY KEY (`address_id`),
  KEY `COMMON` (`address_id`,`manu_id`,`shop_id`,`order_id`,`type`,`remittion`,`postcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_category` (
  `cat_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(12) unsigned DEFAULT '0',
  `item_id` int(12) unsigned DEFAULT '0',
  `logo_picture_id` int(12) unsigned DEFAULT '0',
  `uid` int(12) unsigned DEFAULT '0',
  `rating` decimal(15,4) unsigned DEFAULT '0.0000',
  `votes` int(10) unsigned DEFAULT '0',
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  KEY `COMMON` (`cat_id`,`parent_id`,`item_id`,`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_contacts` (
  `contact_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `last_sales_uid` int(13) unsigned DEFAULT '0',
  `last_broker_uid` int(13) unsigned DEFAULT '0',
  `last_cat_id` int(12) unsigned DEFAULT '0',
  `last_product_id` int(12) unsigned DEFAULT '0',
  `last_manu_id` int(12) unsigned DEFAULT '0',
  `last_shipping_id` int(12) unsigned DEFAULT '0',
  `last_order_id` int(12) unsigned DEFAULT '0',
  `type` enum('_SHOP_MI_CONTACTS_EMAIL','_SHOP_MI_CONTACTS_PHONE','_SHOP_MI_CONTACTS_MOBILE','_SHOP_MI_CONTACTS_FAX','_SHOP_MI_CONTACTS_PAGER','_SHOP_MI_CONTACTS_OTHER') DEFAULT '_SHOP_MI_CONTACTS_OTHER',
  `citation` varchar(35) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `days_id` int(12) unsigned DEFAULT '0',
  `opening` int(10) unsigned DEFAULT '25200',
  `closing` int(10) unsigned DEFAULT '68400',
  `timezone` tinyint(4) DEFAULT '10',
  `country_code` varchar(5) DEFAULT NULL,
  `area_code` varchar(5) DEFAULT NULL,
  `md5` varchar(32) DEFAULT NULL,
  `created` int(13) unsigned DEFAULT '0',
  `updated` int(13) unsigned DEFAULT '0',
  `actioned` int(13) unsigned DEFAULT '0',
  PRIMARY KEY (`contact_id`),
  KEY `COMMON` (`last_sales_uid`,`last_broker_uid`,`last_cat_id`,`last_product_id`,`last_manu_id`,`last_shipping_id`,`last_order_id`,`type`,`days_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_country` (
  `country_id` int(11) NOT NULL,
  `alpha2` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `alpha3` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AF','AFG','Afghanistan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AL','ALB','Albania');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AQ','ATA','Antarctica');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('DZ','DZA','Algeria');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AS','ASM','American Samoa');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AD','AND','Andorra');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AO','AGO','Angola');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AG','ATG','Antigua and Barbuda');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AZ','AZE','Azerbaijan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AR','ARG','Argentina');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AU','AUS','Australia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AT','AUT','Austria');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BS','BHS','Bahamas');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BH','BHR','Bahrain');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BD','BGD','Bangladesh');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AM','ARM','Armenia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BB','BRB','Barbados');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BE','BEL','Belgium');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BM','BMU','Bermuda');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BT','BTN','Bhutan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BO','BOL','Bolivia, Plurinational State of');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BA','BIH','Bosnia and Herzegovina');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BW','BWA','Botswana');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BV','BVT','Bouvet Island');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BR','BRA','Brazil');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BZ','BLZ','Belize');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('IO','IOT','British Indian Ocean Territory');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SB','SLB','Solomon Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('VG','VGB','Virgin Islands, British');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BN','BRN','Brunei Darussalam');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BG','BGR','Bulgaria');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MM','MMR','Myanmar');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BI','BDI','Burundi');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BY','BLR','Belarus');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KH','KHM','Cambodia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CM','CMR','Cameroon');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CA','CAN','Canada');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CV','CPV','Cape Verde');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KY','CYM','Cayman Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CF','CAF','Central African Republic');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LK','LKA','Sri Lanka');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TD','TCD','Chad');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CL','CHL','Chile');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CN','CHN','China');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TW','TWN','Taiwan, Province of China');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CX','CXR','Christmas Island');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CC','CCK','Cocos (Keeling) Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CO','COL','Colombia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KM','COM','Comoros');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('YT','MYT','Mayotte');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CG','COG','Congo');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CD','COD','Congo, the Democratic Republic of the');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CK','COK','Cook Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CR','CRI','Costa Rica');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('HR','HRV','Croatia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CU','CUB','Cuba');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CY','CYP','Cyprus');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CZ','CZE','Czech Republic');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BJ','BEN','Benin');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('DK','DNK','Denmark');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('DM','DMA','Dominica');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('DO','DOM','Dominican Republic');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('EC','ECU','Ecuador');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SV','SLV','El Salvador');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GQ','GNQ','Equatorial Guinea');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ET','ETH','Ethiopia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ER','ERI','Eritrea');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('EE','EST','Estonia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('FO','FRO','Faroe Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('FK','FLK','Falkland Islands (Malvinas)');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GS','SGS','South Georgia and the South Sandwich Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('FJ','FJI','Fiji');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('FI','FIN','Finland');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AX','ALA','Åland');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('FR','FRA','France');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GF','GUF','French Guiana');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PF','PYF','French Polynesia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TF','ATF','French Southern Territories');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('DJ','DJI','Djibouti');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GA','GAB','Gabon');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GE','GEO','Georgia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GM','GMB','Gambia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PS','PSE','Palestinian Territory, Occupied');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('DE','DEU','Germany');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GH','GHA','Ghana');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GI','GIB','Gibraltar');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KI','KIR','Kiribati');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GR','GRC','Greece');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GL','GRL','Greenland');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GD','GRD','Grenada');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GP','GLP','Guadeloupe');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GU','GUM','Guam');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GT','GTM','Guatemala');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GN','GIN','Guinea');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GY','GUY','Guyana');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('HT','HTI','Haiti');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('HM','HMD','Heard Island and McDonald Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('VA','VAT','Holy See (Vatican City State)');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('HN','HND','Honduras');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('HK','HKG','Hong Kong');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('HU','HUN','Hungary');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('IS','ISL','Iceland');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('IN','IND','India');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ID','IDN','Indonesia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('IR','IRN','Iran, Islamic Republic of');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('IQ','IRQ','Iraq');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('IE','IRL','Ireland');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('IL','ISR','Israel');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('IT','ITA','Italy');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CI','CIV','Côte d\'Ivoire');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('JM','JAM','Jamaica');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('JP','JPN','Japan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KZ','KAZ','Kazakhstan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('JO','JOR','Jordan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KE','KEN','Kenya');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KP','PRK','Korea, Democratic People\'s Republic of');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KR','KOR','Korea, Republic of');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KW','KWT','Kuwait');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KG','KGZ','Kyrgyzstan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LA','LAO','Lao People\'s Democratic Republic');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LB','LBN','Lebanon');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LS','LSO','Lesotho');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LV','LVA','Latvia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LR','LBR','Liberia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LY','LBY','Libyan Arab Jamahiriya');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LI','LIE','Liechtenstein');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LT','LTU','Lithuania');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LU','LUX','Luxembourg');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MO','MAC','Macao');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MG','MDG','Madagascar');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MW','MWI','Malawi');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MY','MYS','Malaysia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MV','MDV','Maldives');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ML','MLI','Mali');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MT','MLT','Malta');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MQ','MTQ','Martinique');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MR','MRT','Mauritania');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MU','MUS','Mauritius');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MX','MEX','Mexico');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MC','MCO','Monaco');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MN','MNG','Mongolia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MD','MDA','Moldova, Republic of');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ME','MNE','Montenegro');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MS','MSR','Montserrat');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MA','MAR','Morocco');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MZ','MOZ','Mozambique');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('OM','OMN','Oman');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NA','NAM','Namibia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NR','NRU','Nauru');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NP','NPL','Nepal');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NL','NLD','Netherlands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AN','ANT','Netherlands Antilles');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AW','ABW','Aruba');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NC','NCL','New Caledonia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('VU','VUT','Vanuatu');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NZ','NZL','New Zealand');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NI','NIC','Nicaragua');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NE','NER','Niger');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NG','NGA','Nigeria');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NU','NIU','Niue');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NF','NFK','Norfolk Island');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('NO','NOR','Norway');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MP','MNP','Northern Mariana Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('UM','UMI','United States Minor Outlying Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('FM','FSM','Micronesia, Federated States of');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MH','MHL','Marshall Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PW','PLW','Palau');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PK','PAK','Pakistan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PA','PAN','Panama');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PG','PNG','Papua New Guinea');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PY','PRY','Paraguay');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PE','PER','Peru');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PH','PHL','Philippines');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PN','PCN','Pitcairn');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PL','POL','Poland');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PT','PRT','Portugal');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GW','GNB','Guinea-Bissau');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TL','TLS','Timor-Leste');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PR','PRI','Puerto Rico');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('QA','QAT','Qatar');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('RE','REU','Réunion');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('RO','ROU','Romania');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('RU','RUS','Russian Federation');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('RW','RWA','Rwanda');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BL','BLM','Saint BarthÃ©lemy');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SH','SHN','Saint Helena, Ascension and Tristan da Cunha');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('KN','KNA','Saint Kitts and Nevis');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AI','AIA','Anguilla');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('LC','LCA','Saint Lucia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MF','MAF','Saint Martin (French part)');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('PM','SPM','Saint Pierre and Miquelon');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('VC','VCT','Saint Vincent and the Grenadines');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SM','SMR','San Marino');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ST','STP','Sao Tome and Principe');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SA','SAU','Saudi Arabia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SN','SEN','Senegal');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('RS','SRB','Serbia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SC','SYC','Seychelles');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SL','SLE','Sierra Leone');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SG','SGP','Singapore');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SK','SVK','Slovakia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('VN','VNM','Viet Nam');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SI','SVN','Slovenia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SO','SOM','Somalia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ZA','ZAF','South Africa');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ZW','ZWE','Zimbabwe');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ES','ESP','Spain');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('EH','ESH','Western Sahara');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SD','SDN','Sudan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SR','SUR','Suriname');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SJ','SJM','Svalbard and Jan Mayen');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SZ','SWZ','Swaziland');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SE','SWE','Sweden');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('CH','CHE','Switzerland');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('SY','SYR','Syrian Arab Republic');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TJ','TJK','Tajikistan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TH','THA','Thailand');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TG','TGO','Togo');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TK','TKL','Tokelau');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TO','TON','Tonga');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TT','TTO','Trinidad and Tobago');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('AE','ARE','United Arab Emirates');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TN','TUN','Tunisia');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TR','TUR','Turkey');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TM','TKM','Turkmenistan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TC','TCA','Turks and Caicos Islands');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TV','TUV','Tuvalu');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('UG','UGA','Uganda');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('UA','UKR','Ukraine');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('MK','MKD','Macedonia, the former Yugoslav Republic of');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('EG','EGY','Egypt');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GB','GBR','United Kingdom');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('GG','GGY','Guernsey');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('JE','JEY','Jersey');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('IM','IMN','Isle of Man');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('TZ','TZA','Tanzania, United Republic of');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('US','USA','United States');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('VI','VIR','Virgin Islands, U.S.');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('BF','BFA','Burkina Faso');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('UY','URY','Uruguay');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('UZ','UZB','Uzbekistan');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('VE','VEN','Venezuela, Bolivarian Republic of');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('WF','WLF','Wallis and Futuna');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('WS','WSM','Samoa');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('YE','YEM','Yemen');
insert  into `shop_country` (`alpha2`,`alpha3`,`name`) values ('ZM','ZMB','Zambia');

CREATE TABLE `shop_currency` (
  `currency_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(12) unsigned DEFAULT '0',
  `symbol_left` varchar(3) DEFAULT '$',
  `symbol_right` varchar(3) DEFAULT NULL,
  `decimal_places` int(2) unsigned DEFAULT '0',
  `thousand_seperator` varchar(2) DEFAULT ',',
  `iso_code` varchar(3) DEFAULT 'AUD',
  `default` tinyint(4) unsigned DEFAULT '0',
  `rate` decimal(10,7) unsigned DEFAULT '1.0000000',
  `exchange_currency_id` int(12) unsigned DEFAULT '0',
  `exchange_comparison_rate` decimal(10,7) unsigned DEFAULT '1.0000000',
  `md5` varchar(32) DEFAULT NULL,
  `created` int(13) unsigned DEFAULT '0',
  `updated` int(13) unsigned DEFAULT '0',
  PRIMARY KEY (`currency_id`),
  KEY `COMMON` (`currency_id`,`item_id`,`iso_code`,`default`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert  into `shop_currency` (`currency_id`,`item_id`,`symbol_left`,`symbol_right`,`decimal_places`,`thousand_seperator`,`iso_code`,`default`,`rate`,`exchange_currency_id`,`exchange_comparison_rate`,`md5`,`created`,`updated`) values (1,0,'$',NULL,2,',','AUD',1,'1.0000000',0,'1.0000000',NULL,0,0);

CREATE TABLE `shop_days` (
  `days_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(12) unsigned DEFAULT NULL,
  `monday` enum('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `tuesday` enum('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `wednesday` enum('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `thursday` enum('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `friday` enum('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `saturday` enum('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `sunday` enum('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `md5` varchar(32) DEFAULT NULL,
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  `actioned` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`days_id`),
  KEY `COMMON` (`item_id`,`monday`,`tuesday`,`wednesday`,`thursday`,`friday`,`saturday`,`sunday`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_discounts` (
  `discount_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('_SHOP_MI_DISCOUNT_QUITSTOCK','_SHOP_MI_DISCOUNT_GENERAL','_SHOP_MI_DISCOUNT_WHOLESALE','_SHOP_MI_DISCOUNT_NOREORDER','_SHOP_MI_DISCOUNT_QUANITY','_SHOP_MI_DISCOUNT_OTHER') DEFAULT '_SHOP_MI_DISCOUNT_GENERAL',
  `item_id` int(12) unsigned DEFAULT '0',
  `percentage` decimal(10,5) unsigned DEFAULT '0.00000',
  `min_quanity` decimal(10,4) unsigned DEFAULT '0.0000',
  `shipping_id` int(12) unsigned DEFAULT '0',
  `timed` tinyint(4) DEFAULT '0',
  `start` int(12) unsigned DEFAULT '0',
  `end` int(12) unsigned DEFAULT '0',
  `opening` int(12) unsigned DEFAULT '32400',
  `closing` int(12) unsigned DEFAULT '68400',
  `days_id` int(12) unsigned DEFAULT '0',
  `md5` varchar(32) DEFAULT NULL,
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  `actioned` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`discount_id`),
  KEY `COMMON` (`type`,`shipping_id`,`timed`,`days_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_downloads` (
  `download_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(12) unsigned DEFAULT '0',
  `path` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `mimetype` varchar(128) DEFAULT NULL,
  `hits` int(12) unsigned DEFAULT '0',
  `md5` varchar(32) DEFAULT NULL,
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_extra` (
  `product_id` int(12) unsigned NOT NULL,
  `language` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_field` (
  `field_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `manu_ids` varchar(1000) DEFAULT NULL,
  `shop_ids` varchar(1000) DEFAULT NULL,
  `cat_ids` varchar(1000) DEFAULT NULL,
  `field_type` varchar(30) NOT NULL DEFAULT '',
  `field_valuetype` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `field_name` varchar(255) NOT NULL DEFAULT '',
  `field_title` varchar(255) NOT NULL DEFAULT '',
  `field_description` text,
  `field_required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_maxlength` smallint(6) unsigned NOT NULL DEFAULT '0',
  `field_weight` smallint(6) unsigned NOT NULL DEFAULT '0',
  `field_default` text,
  `field_notnull` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_edit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_show` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_config` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_options` text,
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `field_name` (`field_name`),
  KEY `step` (`field_weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_gallery` (
  `picture_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('_SHOP_MI_GALLERY_CAT_LOGO','_SHOP_MI_GALLERY_MANU_LOGO','_SHOP_MI_GALLERY_PRODUCT','_SHOP_MI_GALLERY_SHOP_LOGO','_SHOP_MI_GALLERY_SHIPPING_LOGO','_SHOP_MI_GALLERY_DISCOUNT_LOGO','_SHOP_MI_GALLERY_ORDER_LOGO','_SHOP_MI_GALLERY_WATERMARK') DEFAULT '_SHOP_MI_GALLERY_PRODUCT',
  `shipping_id` int(12) unsigned DEFAULT '0',
  `product_id` int(12) unsigned DEFAULT '0',
  `cat_id` int(12) unsigned DEFAULT '0',
  `manu_id` int(12) unsigned DEFAULT '0',
  `shop_id` int(12) unsigned DEFAULT '0',
  `item_id` int(12) unsigned DEFAULT '0',
  `weight` tinyint(6) unsigned DEFAULT '1',
  `path` varchar(255) DEFAULT '/uploads/shop',
  `filename` varchar(255) DEFAULT NULL,
  `width` int(10) unsigned DEFAULT '0',
  `height` int(10) unsigned DEFAULT '0',
  `extension` varchar(5) DEFAULT 'jpg',
  `md5` varchar(32) DEFAULT NULL,
  `created` int(13) unsigned DEFAULT '0',
  `updated` int(13) unsigned DEFAULT '0',
  `actioned` int(13) unsigned DEFAULT '0',
  PRIMARY KEY (`picture_id`),
  KEY `COMMON` (`type`,`product_id`,`cat_id`,`manu_id`,`shop_id`,`weight`,`md5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_items` (
  `item_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `languages` varchar(1000) DEFAULT NULL,
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `COMMON` (`languages`(255))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert  into `shop_items` (`item_id`,`languages`,`created`,`updated`) values (1,'english',111111,11111);

CREATE TABLE `shop_items_digest` (
  `lang_item_id` int(24) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(12) unsigned DEFAULT '0',
  `uid` int(13) unsigned DEFAULT '0',
  `product_id` int(12) unsigned DEFAULT '0',
  `manu_id` int(12) unsigned DEFAULT '0',
  `cat_id` int(12) unsigned DEFAULT '0',
  `discount_id` int(12) unsigned DEFAULT '0',
  `shipping_id` int(12) unsigned DEFAULT '0',
  `days_id` int(12) unsigned DEFAULT '0',
  `picture_id` int(12) unsigned DEFAULT '0',
  `order_id` int(12) unsigned DEFAULT '0',
  `currency_id` int(12) unsigned DEFAULT '0',
  `shop_id` int(12) unsigned DEFAULT '0',
  `md5` varchar(32) DEFAULT NULL,
  `type` enum('_SHOP_MI_ITEMS_MENUITEMS','_SHOP_MI_ITEMS_LONGITEMS','_SHOP_MI_ITEMS_BOTHITEMS','_SHOP_MI_ITEMS_RSSITEM','_SHOP_MI_ITEMS_RSSANDLONGITEM','_SHOP_MI_ITEMS_ALLITEMS') DEFAULT '_SHOP_MI_ITEMS_BOTHITEMS',
  `language` varchar(64) DEFAULT 'english',
  `menu_title` varchar(128) DEFAULT NULL,
  `long_title` varchar(255) DEFAULT NULL,
  `rss_title` varchar(255) DEFAULT NULL,
  `menu_subtitle` varchar(128) DEFAULT NULL,
  `long_subtitle` varchar(255) DEFAULT NULL,
  `menu_description` varchar(255) DEFAULT NULL,
  `long_description` mediumtext,
  `rss_description` mediumtext,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  `actioned` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`lang_item_id`),
  KEY `SEARCH` (`language`,`menu_title`(35),`long_title`(35),`menu_subtitle`(35),`long_subtitle`(35),`menu_description`(35),`meta_description`(20),`meta_keywords`(20)),
  KEY `COMMON` (`type`,`item_id`,`lang_item_id`,`product_id`,`manu_id`,`cat_id`,`discount_id`,`shipping_id`,`days_id`,`picture_id`,`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert  into `shop_items_digest` (`lang_item_id`,`uid`,`product_id`,`manu_id`,`cat_id`,`discount_id`,`shipping_id`,`days_id`,`picture_id`,`order_id`,`currency_id`,`shop_id`,`md5`,`type`,`item_id`,`language`,`menu_title`,`long_title`,`rss_title`,`menu_subtitle`,`long_subtitle`,`menu_description`,`long_description`,`rss_description`,`meta_description`,`meta_keywords`,`created`,`updated`,`actioned`) values (1,0,0,0,0,0,0,0,0,0,0,0,NULL,'_SHOP_MI_ITEMS_MENUITEMS',1,'english','Australian Dollar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Australian dollar','Australian, dollar',NULL,NULL,0);

CREATE TABLE `shop_manufacturer` (
  `manu_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `ordering` enum('_SHOP_MI_MANU_PLACESTOCKORDER','_SHOP_MI_MANU_DONTPLACESTOCKORDER','_SHOP_MI_MANU_MANUALORDER','_SHOP_MI_MANU_RAISETOPURCHASEOFFICER','_SHOP_MI_MANU_APIORDERING') DEFAULT '_SHOP_MI_MANU_PLACESTOCKORDER',
  `type` enum('_SHOP_MI_MANU_LOCAL','_SHOP_MI_MANU_INTERSTATE','_SHOP_MI_MANU_OVERSEAS','_SHOP_MI_MANU_INTERNAL','_SHOP_MI_MANU_UNKNOWN') DEFAULT '_SHOP_MI_MANU_UNKNOWN',
  `broker_uid` int(13) DEFAULT '0',
  `item_id` int(12) unsigned DEFAULT '0',
  `address_id` int(12) unsigned DEFAULT '0',
  `contact_id` int(12) unsigned DEFAULT '0',
  `mobile_id` int(12) unsigned DEFAULT '0',
  `email_id` int(12) unsigned DEFAULT '0',
  `last_order_id` int(12) unsigned DEFAULT '0',
  `logo_picture_id` int(12) unsigned DEFAULT '0',
  `rating` decimal(15,4) unsigned DEFAULT '0.0000',
  `votes` int(10) unsigned DEFAULT '0',
  `md5` varchar(32) DEFAULT NULL,
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  `actioned` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`manu_id`),
  KEY `COMMON` (`ordering`,`type`,`item_id`,`address_id`,`contact_id`,`mobile_id`,`email_id`,`last_order_id`,`logo_picture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_orders` (
  `order_id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `mode` enum('_SHOP_MI_ORDER_OPENORDER','_SHOP_MI_ORDER_CLOSEDORDER','_SHOP_MI_ORDER_CHECKEDOUT','_SHOP_MI_ORDER_GONETOINVOICING','_SHOP_MI_ORDER_OTHER') DEFAULT '_SHOP_MI_ORDER_OPENORDER',
  `remittion` enum('_SHOP_MI_ORDER_PAID','_SHOP_MI_ORDER_UNPAID','_SHOP_MI_ORDER_CANCELLED','_SHOP_MI_ORDER_FRAUDPAID','_SHOP_MI_ORDER_FRAUDUNPAID','_SHOP_MI_ORDER_FRAUDCANCELLED') DEFAULT '_SHOP_MI_ORDER_UNPAID',
  `key` varchar(64) DEFAULT '00000-00000-00000-00000-00000-00000',
  `uid` int(13) unsigned DEFAULT '0',
  `broker_uids` varchar(1000) DEFAULT NULL,
  `sales_uids` varchar(1000) DEFAULT NULL,
  `cat_ids` varchar(1000) DEFAULT NULL,
  `manu_ids` varchar(1000) DEFAULT NULL,
  `shop_ids` varchar(1000) DEFAULT NULL,
  `product_ids` varchar(1000) DEFAULT NULL,
  `shipping_id` int(12) unsigned DEFAULT '0',
  `currency_id` int(12) unsigned DEFAULT '0',
  `total` decimal(15,4) unsigned DEFAULT '0.0000',
  `tax` decimal(15,4) unsigned DEFAULT '0.0000',
  `shipping` decimal(15,4) unsigned DEFAULT '0.0000',
  `handling` decimal(15,4) unsigned DEFAULT '0.0000',
  `billing_address_id` int(12) unsigned DEFAULT '0',
  `shipping_address_id` int(12) unsigned DEFAULT '0',
  `billing_email_id` int(12) unsigned DEFAULT '0',
  `shipping_email_id` int(12) unsigned DEFAULT '0',
  `billing_contact_id` int(12) unsigned DEFAULT '0',
  `shipping_contact_id` int(12) unsigned DEFAULT '0',
  `billing_mobile_id` int(12) unsigned DEFAULT '0',
  `shipping_mobile_id` int(12) unsigned DEFAULT '0',
  `billing_fax_id` int(12) unsigned DEFAULT '0',
  `shipping_fax_id` int(12) unsigned DEFAULT '0',
  `discount_ids` varchar(500) DEFAULT NULL,
  `discount_avg_percentile` decimal(6,2) unsigned DEFAULT '0.00',
  `discount_amount` decimal(15,4) unsigned DEFAULT '0.0000',
  `started` int(12) unsigned DEFAULT '0',
  `paid` int(12) unsigned DEFAULT '0',
  `shipped` int(12) unsigned DEFAULT '0',
  `ended` int(12) unsigned DEFAULT '0',
  `offline` int(12) unsigned DEFAULT '0',
  `ip` varchar(128) DEFAULT NULL,
  `netbios` varchar(255) DEFAULT NULL,
  `iid` int(30) DEFAULT '0',
  `invoice_url` varchar(255) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `md5` varchar(32) DEFAULT NULL,
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  `actioned` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`order_id`),
  KEY `COMMON` (`remittion`,`key`,`uid`,`billing_address_id`,`shipping_address_id`,`billing_email_id`,`shipping_email_id`,`billing_contact_id`,`shipping_contact_id`,`billing_mobile_id`,`shipping_mobile_id`,`billing_fax_id`,`shipping_fax_id`,`ip`,`netbios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_orders_connotes` (
  `con_note_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `assigned_uid` int(13) unsigned DEFAULT '0',
  `type` enum('_SHOP_MI_CONNOTE_EXPRESS','_SHOP_MI_CONNOTE_STANDARD','_SHOP_MI_CONNOTE_RETURNED','_SHOP_MI_CONNOTE_BYSEA','_SHOP_MI_CONNOTE_BYROAD','_SHOP_MI_CONNOTE_BYPLANE','_SHOP_MI_CONNOTE_BYTRAIN') DEFAULT '_SHOP_MI_CONNOTE_STANDARD',
  `shipping_id` int(12) unsigned DEFAULT '0',
  `address_id` int(12) unsigned DEFAULT '0',
  `contact_id` int(12) DEFAULT '0',
  `dispatched` int(13) unsigned DEFAULT '0',
  `returned` int(13) unsigned DEFAULT '0',
  `number` varchar(128) DEFAULT NULL,
  `md5` varchar(32) DEFAULT NULL,
  `created` int(13) unsigned DEFAULT '0',
  `updated` int(13) unsigned DEFAULT '0',
  `actioned` int(13) unsigned DEFAULT '0',
  PRIMARY KEY (`con_note_id`),
  KEY `COMMON` (`assigned_uid`,`type`,`shipping_id`,`address_id`,`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_orders_digest` (
  `product_order_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(12) unsigned DEFAULT '0',
  `con_note_id` int(12) unsigned DEFAULT '0',
  `shipping_id` int(12) unsigned DEFAULT '0',
  `shop_id` int(12) unsigned DEFAULT '0',
  `cat_id` int(12) unsigned DEFAULT '0',
  `manu_id` int(12) unsigned DEFAULT '0',
  `product_id` int(12) unsigned DEFAULT '0',
  `quanity` decimal(10,4) unsigned DEFAULT '0.0000',
  `price` decimal(15,4) unsigned DEFAULT '0.0000',
  `shipping` decimal(15,4) unsigned DEFAULT '0.0000',
  `handling` decimal(15,4) unsigned DEFAULT '0.0000',
  `tax` decimal(15,4) unsigned DEFAULT '0.0000',
  `weight` decimal(15,6) DEFAULT '0.000000',
  `weight_measurement` enum('_SHOP_MI_WEIGHT_KILOS','_SHOP_MI_WEIGHT_POUNDS','_SHOP_MI_WEIGHT_OTHER') DEFAULT '_SHOP_MI_WEIGHT_KILOS',
  `discount_given` tinyint(4) unsigned DEFAULT '0',
  `discount_id` int(12) unsigned DEFAULT '0',
  `discount_percentile` decimal(6,4) unsigned DEFAULT '0.0000',
  `discount_amount` decimal(15,4) unsigned DEFAULT '0.0000',
  `md5` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`product_order_id`),
  KEY `COMMON` (`order_id`,`con_note_id`,`shipping_id`,`shop_id`,`cat_id`,`manu_id`,`product_id`,`discount_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_products` (
  `product_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `stock` enum('_SHOP_MI_PRODUCTS_INSTOCK','_SHOP_MI_PRODUCTS_OUTSTOCK','_SHOP_MI_PRODUCTS_NOREORDER','_SHOP_MI_PRODUCTS_QUITSTOCK','_SHOP_MI_PRODUCTS_SUPLUSSTOCK') DEFAULT '_SHOP_MI_PRODUCTS_INSTOCK',
  `type` enum('_SHOP_MI_PRODUCTS_SERVICE','_SHOP_MI_PRODUCTS_TANGIABLEITEM','_SHOP_MI_PRODUCTS_SERVICEANDITEM') DEFAULT '_SHOP_MI_PRODUCTS_TANGIABLEITEM',
  `uid` int(14) DEFAULT '0',
  `sales_uid` int(13) unsigned DEFAULT '0',
  `broker_uid` int(13) unsigned DEFAULT '0',
  `shop_id` int(12) unsigned DEFAULT '0',
  `cat_id` int(12) unsigned DEFAULT '0',
  `manu_id` int(12) unsigned DEFAULT '0',
  `item_id` int(12) unsigned DEFAULT '0',
  `currency_id` int(12) DEFAULT '0',
  `shipping_id` int(12) DEFAULT '0',
  `feature_picture_id` int(12) DEFAULT '0',
  `discount_id` int(12) DEFAULT '0',
  `wholesale_discount_id` int(12) DEFAULT '0',
  `cat_number` varchar(25) DEFAULT NULL,
  `sub_model` varchar(35) DEFAULT NULL,
  `cat_prefix` varchar(3) DEFAULT NULL,
  `cat_subfix` varchar(3) DEFAULT NULL,
  `unit_price` decimal(15,4) DEFAULT '0.0000',
  `unit_wholesale_price` decimal(14,4) DEFAULT '0.0000',
  `weight_per_unit` decimal(15,6) DEFAULT '0.000000',
  `weight_measurement` enum('_SHOP_MI_WEIGHT_KILOS','_SHOP_MI_WEIGHT_POUNDS','_SHOP_MI_WEIGHT_OTHER') DEFAULT '_SHOP_MI_WEIGHT_KILOS',
  `quanity_in_unit` decimal(15,4) DEFAULT '0.0000',
  `quanity_for_wholesale` decimal(15,4) DEFAULT '0.0000',
  `quanity_measured` varchar(10) DEFAULT NULL,
  `quanity_in_warehouse` int(10) DEFAULT '0',
  `quanity_to_order` int(10) DEFAULT '0',
  `tag` varchar(255) DEFAULT NULL,
  `rating` decimal(15,4) DEFAULT '0.0000',
  `votes` int(12) DEFAULT '0',
  `last_ordered` int(12) DEFAULT '0',
  `shippment_arrived` int(12) DEFAULT '0',
  `md5` varchar(32) DEFAULT NULL,
  `created` int(12) DEFAULT '0',
  `updated` int(12) DEFAULT '0',
  `actioned` int(12) DEFAULT '0',
  PRIMARY KEY (`product_id`),
  KEY `COMMON` (`stock`,`type`,`uid`,`cat_id`,`manu_id`,`item_id`,`currency_id`,`shipping_id`,`feature_picture_id`,`discount_id`,`wholesale_discount_id`),
  KEY `SEARCH` (`cat_number`,`sub_model`,`cat_prefix`,`cat_subfix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_regions` (
  `region_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `longitude` decimal(15,10) DEFAULT NULL,
  `latitude` decimal(15,10) DEFAULT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_shipping` (
  `shipping_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('_SHOP_MI_SHIPPING_LOCAL','_SHOP_MI_SHIPPING_INTERSTATE','_SHOP_MI_SHIPPING_OVERSEAS','_SHOP_MI_SHIPPING_INTERNAL','_SHOP_MI_SHIPPING_BYSEA','_SHOP_MI_SHIPPING_BYROAD','_SHOP_MI_SHIPPING_BYTRAIN','_SHOP_MI_SHIPPING_BYPLANE','_SHOP_MI_SHIPPING_EXPRESS','_SHOP_MI_SHIPPING_UNKNOWN') DEFAULT '_SHOP_MI_SHIPPING_UNKNOWN',
  `method` enum('_SHOP_MI_SHIPPING_MANUALPHONECALL','_SHOP_MI_SHIPPING_EMAIL','_SHOP_MI_SHIPPING_APICALL','_SHOP_MI_SHIPPING_FAX','_SHOP_MI_SHIPPING_OTHER') DEFAULT '_SHOP_MI_SHIPPING_MANUALPHONECALL',
  `uid` int(12) unsigned DEFAULT '0',
  `broker_uids` varchar(500) DEFAULT NULL,
  `item_id` int(12) unsigned DEFAULT '0',
  `address_id` int(12) unsigned DEFAULT '0',
  `contact_id` int(12) unsigned DEFAULT '0',
  `mobile_id` int(12) unsigned DEFAULT '0',
  `email_id` int(12) unsigned DEFAULT '0',
  `logo_picture_id` int(12) unsigned DEFAULT '0',
  `price_per_kilo` decimal(15,4) unsigned DEFAULT '0.0000',
  `price_per_pound` decimal(15,4) unsigned DEFAULT '0.0000',
  `price_per_other` decimal(15,4) unsigned DEFAULT '0.0000',
  `country_ids` varchar(1500) DEFAULT NULL,
  `handling_per_unit` decimal(15,4) unsigned DEFAULT '0.0000',
  `region_ids` varchar(1500) DEFAULT NULL,
  `opening` int(10) unsigned DEFAULT '25200',
  `closing` int(10) unsigned DEFAULT '68400',
  `days_id` int(12) unsigned DEFAULT '0',
  `rating` decimal(15,4) DEFAULT '0.0000',
  `votes` int(10) unsigned DEFAULT '0',
  `md5` varchar(32) DEFAULT NULL,
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  `actioned` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`shipping_id`),
  KEY `COMMON` (`type`,`method`,`uid`,`item_id`,`address_id`,`contact_id`,`mobile_id`,`email_id`,`logo_picture_id`,`days_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_shops` (
  `shop_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('_SHOP_MI_SHOPS_PHYSICALSTORE','_SHOP_MI_SHOPS_DELIVERYRUN','_SHOP_MI_SHOPS_SERVICECENTER','_SHOP_MI_SHOPS_SERVICEWAREHOUSE','_SHOP_MI_SHOPS_SERVICE','_SHOP_MI_SHOPS_OTHER') DEFAULT '_SHOP_MI_SHOPS_PHYSICALSTORE',
  `owner_uid` int(12) unsigned DEFAULT '0',
  `admin_uids` varchar(500) DEFAULT NULL,
  `broker_uids` varchar(500) DEFAULT NULL,
  `sales_uid` varchar(500) DEFAULT NULL,
  `shop_email_id` int(12) unsigned DEFAULT '0',
  `address_id` int(12) unsigned DEFAULT '0',
  `phone_id` int(12) unsigned DEFAULT '0',
  `mobile_id` int(12) unsigned DEFAULT '0',
  `fax_id` int(12) unsigned DEFAULT '0',
  `item_id` int(12) unsigned DEFAULT '0',
  `logo_picture_id` int(12) unsigned DEFAULT '0',
  `delievery_id` int(12) unsigned DEFAULT '0',
  `express_id` int(12) unsigned DEFAULT '0',
  `sms_id` int(12) unsigned DEFAULT '0',
  `serviced_id` int(12) unsigned DEFAULT '0',
  `days_id` int(12) unsigned DEFAULT '0',
  `start` int(12) DEFAULT '0',
  `end` int(12) DEFAULT '0',
  `opening` int(10) unsigned DEFAULT '32400',
  `closed` int(10) unsigned DEFAULT '68400',
  `sales_in_store` tinyint(4) unsigned DEFAULT '1',
  `sales_online` tinyint(4) unsigned DEFAULT '1',
  `sales_with_warehouse` tinyint(4) unsigned DEFAULT '1',
  `max_discount` decimal(6,2) unsigned DEFAULT '5.00',
  `special_product_id` int(12) unsigned DEFAULT '0',
  `special_cat_id` int(12) unsigned DEFAULT '0',
  `special_manu_id` int(12) unsigned DEFAULT '0',
  `timed` tinyint(4) unsigned DEFAULT '0',
  `24hour_online` tinyint(4) unsigned DEFAULT '0',
  `24hour_ordering` tinyint(4) DEFAULT '0',
  `rating` decimal(15,4) unsigned DEFAULT '0.0000',
  `votes` int(10) unsigned DEFAULT '0',
  `md5` varchar(32) DEFAULT NULL,
  `created` int(12) unsigned DEFAULT '0',
  `updated` int(12) unsigned DEFAULT '0',
  `actioned` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`shop_id`),
  KEY `COMMON` (`type`,`sales_uid`(255),`shop_email_id`,`address_id`,`phone_id`,`mobile_id`,`fax_id`,`item_id`,`logo_picture_id`,`delievery_id`,`express_id`,`sms_id`,`serviced_id`,`days_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_visibility` (
  `field_id` int(12) unsigned NOT NULL DEFAULT '0',
  `user_group` smallint(5) unsigned NOT NULL DEFAULT '0',
  `profile_group` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`field_id`,`user_group`,`profile_group`),
  KEY `visible` (`user_group`,`profile_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;