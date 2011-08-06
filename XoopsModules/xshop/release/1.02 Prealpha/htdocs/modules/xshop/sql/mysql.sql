
CREATE TABLE `shop_addresses` (
  `address_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `manu_id` INT(12) UNSIGNED DEFAULT NULL,
  `shop_id` INT(12) UNSIGNED DEFAULT NULL,
  `order_id` INT(12) UNSIGNED DEFAULT NULL,
  `type` ENUM('_SHOP_MI_ADDRESS_MANUFACTURE','_SHOP_MI_ADDRESS_SHOP','_SHOP_MI_ADDRESS_POSTAL','_SHOP_MI_ADDRESS_DELIEVERY','_SHOP_MI_ADDRESS_ORDERBY','_SHOP_MI_ADDRESS_SHOW','_SHOP_MI_ADDRESS_OTHER') DEFAULT '_SHOP_MI_ADDRESS_DELIEVERY',
  `remittion` ENUM('_SHOP_MI_ADDRESS_RETURNEDGOODS','_SHOP_MI_ADDRESS_FRAUD','_SHOP_MI_ADDRESS_STOLENINMAIL','_SHOP_MI_ADDRESS_EXPRESSDELIEVERY','_SHOP_MI_ADDRESS_NONE') DEFAULT '_SHOP_MI_ADDRESS_NONE',
  `care_of` VARCHAR(128) DEFAULT NULL,
  `address_line_1` VARCHAR(128) DEFAULT NULL,
  `address_line_2` VARCHAR(128) DEFAULT NULL,
  `suburb` VARCHAR(128) DEFAULT NULL,
  `city` VARCHAR(128) DEFAULT NULL,
  `region_id` INT(12) UNSIGNED DEFAULT '0',
  `country_id` INT(12) UNSIGNED DEFAULT '0',
  `postcode` VARCHAR(15) DEFAULT NULL,
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`address_id`),
  KEY `COMMON` (`address_id`,`manu_id`,`shop_id`,`order_id`,`type`,`remittion`,`postcode`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_category` (
  `cat_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` INT(12) UNSIGNED DEFAULT '0',
  `item_id` INT(12) UNSIGNED DEFAULT '0',
  `logo_picture_id` INT(12) UNSIGNED DEFAULT '0',
  `uid` INT(12) UNSIGNED DEFAULT '0',
  `rating` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `votes` INT(10) UNSIGNED DEFAULT '0',
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  KEY `COMMON` (`cat_id`,`parent_id`,`item_id`,`uid`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_contacts` (
  `contact_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `last_sales_uid` INT(13) UNSIGNED DEFAULT '0',
  `last_broker_uid` INT(13) UNSIGNED DEFAULT '0',
  `last_cat_id` INT(12) UNSIGNED DEFAULT '0',
  `last_product_id` INT(12) UNSIGNED DEFAULT '0',
  `last_manu_id` INT(12) UNSIGNED DEFAULT '0',
  `last_shipping_id` INT(12) UNSIGNED DEFAULT '0',
  `last_order_id` INT(12) UNSIGNED DEFAULT '0',
  `type` ENUM('_SHOP_MI_CONTACTS_EMAIL','_SHOP_MI_CONTACTS_PHONE','_SHOP_MI_CONTACTS_MOBILE','_SHOP_MI_CONTACTS_FAX','_SHOP_MI_CONTACTS_PAGER','_SHOP_MI_CONTACTS_OTHER') DEFAULT '_SHOP_MI_CONTACTS_OTHER',
  `citation` VARCHAR(35) DEFAULT NULL,
  `name` VARCHAR(128) DEFAULT NULL,
  `value` VARCHAR(255) DEFAULT NULL,
  `days_id` INT(12) UNSIGNED DEFAULT '0',
  `opening` INT(10) UNSIGNED DEFAULT '25200',
  `closing` INT(10) UNSIGNED DEFAULT '68400',
  `timezone` TINYINT(4) DEFAULT '10',
  `country_code` VARCHAR(5) DEFAULT NULL,
  `area_code` VARCHAR(5) DEFAULT NULL,
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`contact_id`),
  KEY `COMMON` (`last_sales_uid`,`last_broker_uid`,`last_cat_id`,`last_product_id`,`last_manu_id`,`last_shipping_id`,`last_order_id`,`type`,`days_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_country` (
  `country_id` INT(11)  UNSIGNED NOT NULL AUTO_INCREMENT,
  `alpha2` VARCHAR(2) COLLATE utf8_unicode_ci NOT NULL,
  `alpha3` VARCHAR(3) COLLATE utf8_unicode_ci NOT NULL,
  `name` VARCHAR(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AF','AFG','Afghanistan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AL','ALB','Albania');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AQ','ATA','Antarctica');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('DZ','DZA','Algeria');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AS','ASM','American Samoa');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AD','AND','Andorra');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AO','AGO','Angola');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AG','ATG','Antigua and Barbuda');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AZ','AZE','Azerbaijan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AR','ARG','Argentina');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AU','AUS','Australia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AT','AUT','Austria');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BS','BHS','Bahamas');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BH','BHR','Bahrain');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BD','BGD','Bangladesh');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AM','ARM','Armenia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BB','BRB','Barbados');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BE','BEL','Belgium');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BM','BMU','Bermuda');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BT','BTN','Bhutan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BO','BOL','Bolivia, Plurinational State of');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BA','BIH','Bosnia and Herzegovina');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BW','BWA','Botswana');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BV','BVT','Bouvet Island');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BR','BRA','Brazil');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BZ','BLZ','Belize');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('IO','IOT','British Indian Ocean Territory');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SB','SLB','Solomon Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('VG','VGB','Virgin Islands, British');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BN','BRN','Brunei Darussalam');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BG','BGR','Bulgaria');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MM','MMR','Myanmar');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BI','BDI','Burundi');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BY','BLR','Belarus');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KH','KHM','Cambodia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CM','CMR','Cameroon');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CA','CAN','Canada');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CV','CPV','Cape Verde');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KY','CYM','Cayman Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CF','CAF','Central African Republic');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LK','LKA','Sri Lanka');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TD','TCD','Chad');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CL','CHL','Chile');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CN','CHN','China');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TW','TWN','Taiwan, Province of China');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CX','CXR','Christmas Island');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CC','CCK','Cocos (Keeling) Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CO','COL','Colombia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KM','COM','Comoros');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('YT','MYT','Mayotte');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CG','COG','Congo');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CD','COD','Congo, the Democratic Republic of the');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CK','COK','Cook Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CR','CRI','Costa Rica');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('HR','HRV','Croatia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CU','CUB','Cuba');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CY','CYP','Cyprus');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CZ','CZE','Czech Republic');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BJ','BEN','Benin');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('DK','DNK','Denmark');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('DM','DMA','Dominica');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('DO','DOM','Dominican Republic');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('EC','ECU','Ecuador');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SV','SLV','El Salvador');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GQ','GNQ','Equatorial Guinea');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ET','ETH','Ethiopia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ER','ERI','Eritrea');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('EE','EST','Estonia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('FO','FRO','Faroe Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('FK','FLK','Falkland Islands (Malvinas)');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GS','SGS','South Georgia and the South Sandwich Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('FJ','FJI','Fiji');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('FI','FIN','Finland');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AX','ALA','Åland');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('FR','FRA','France');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GF','GUF','French Guiana');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PF','PYF','French Polynesia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TF','ATF','French Southern Territories');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('DJ','DJI','Djibouti');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GA','GAB','Gabon');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GE','GEO','Georgia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GM','GMB','Gambia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PS','PSE','Palestinian Territory, Occupied');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('DE','DEU','Germany');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GH','GHA','Ghana');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GI','GIB','Gibraltar');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KI','KIR','Kiribati');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GR','GRC','Greece');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GL','GRL','Greenland');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GD','GRD','Grenada');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GP','GLP','Guadeloupe');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GU','GUM','Guam');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GT','GTM','Guatemala');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GN','GIN','Guinea');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GY','GUY','Guyana');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('HT','HTI','Haiti');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('HM','HMD','Heard Island and McDonald Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('VA','VAT','Holy See (Vatican City State)');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('HN','HND','Honduras');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('HK','HKG','Hong Kong');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('HU','HUN','Hungary');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('IS','ISL','Iceland');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('IN','IND','India');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ID','IDN','Indonesia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('IR','IRN','Iran, Islamic Republic of');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('IQ','IRQ','Iraq');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('IE','IRL','Ireland');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('IL','ISR','Israel');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('IT','ITA','Italy');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CI','CIV','Côte d\'Ivoire');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('JM','JAM','Jamaica');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('JP','JPN','Japan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KZ','KAZ','Kazakhstan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('JO','JOR','Jordan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KE','KEN','Kenya');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KP','PRK','Korea, Democratic People\'s Republic of');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KR','KOR','Korea, Republic of');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KW','KWT','Kuwait');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KG','KGZ','Kyrgyzstan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LA','LAO','Lao People\'s Democratic Republic');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LB','LBN','Lebanon');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LS','LSO','Lesotho');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LV','LVA','Latvia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LR','LBR','Liberia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LY','LBY','Libyan Arab Jamahiriya');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LI','LIE','Liechtenstein');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LT','LTU','Lithuania');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LU','LUX','Luxembourg');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MO','MAC','Macao');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MG','MDG','Madagascar');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MW','MWI','Malawi');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MY','MYS','Malaysia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MV','MDV','Maldives');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ML','MLI','Mali');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MT','MLT','Malta');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MQ','MTQ','Martinique');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MR','MRT','Mauritania');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MU','MUS','Mauritius');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MX','MEX','Mexico');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MC','MCO','Monaco');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MN','MNG','Mongolia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MD','MDA','Moldova, Republic of');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ME','MNE','Montenegro');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MS','MSR','Montserrat');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MA','MAR','Morocco');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MZ','MOZ','Mozambique');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('OM','OMN','Oman');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NA','NAM','Namibia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NR','NRU','Nauru');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NP','NPL','Nepal');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NL','NLD','Netherlands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AN','ANT','Netherlands Antilles');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AW','ABW','Aruba');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NC','NCL','New Caledonia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('VU','VUT','Vanuatu');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NZ','NZL','New Zealand');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NI','NIC','Nicaragua');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NE','NER','Niger');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NG','NGA','Nigeria');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NU','NIU','Niue');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NF','NFK','Norfolk Island');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('NO','NOR','Norway');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MP','MNP','Northern Mariana Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('UM','UMI','United States Minor Outlying Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('FM','FSM','Micronesia, Federated States of');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MH','MHL','Marshall Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PW','PLW','Palau');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PK','PAK','Pakistan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PA','PAN','Panama');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PG','PNG','Papua New Guinea');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PY','PRY','Paraguay');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PE','PER','Peru');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PH','PHL','Philippines');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PN','PCN','Pitcairn');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PL','POL','Poland');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PT','PRT','Portugal');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GW','GNB','Guinea-Bissau');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TL','TLS','Timor-Leste');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PR','PRI','Puerto Rico');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('QA','QAT','Qatar');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('RE','REU','Réunion');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('RO','ROU','Romania');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('RU','RUS','Russian Federation');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('RW','RWA','Rwanda');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BL','BLM','Saint BarthÃ©lemy');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SH','SHN','Saint Helena, Ascension and Tristan da Cunha');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('KN','KNA','Saint Kitts and Nevis');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AI','AIA','Anguilla');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('LC','LCA','Saint Lucia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MF','MAF','Saint Martin (French part)');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('PM','SPM','Saint Pierre and Miquelon');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('VC','VCT','Saint Vincent and the Grenadines');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SM','SMR','San Marino');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ST','STP','Sao Tome and Principe');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SA','SAU','Saudi Arabia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SN','SEN','Senegal');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('RS','SRB','Serbia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SC','SYC','Seychelles');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SL','SLE','Sierra Leone');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SG','SGP','Singapore');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SK','SVK','Slovakia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('VN','VNM','Viet Nam');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SI','SVN','Slovenia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SO','SOM','Somalia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ZA','ZAF','South Africa');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ZW','ZWE','Zimbabwe');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ES','ESP','Spain');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('EH','ESH','Western Sahara');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SD','SDN','Sudan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SR','SUR','Suriname');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SJ','SJM','Svalbard and Jan Mayen');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SZ','SWZ','Swaziland');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SE','SWE','Sweden');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('CH','CHE','Switzerland');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('SY','SYR','Syrian Arab Republic');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TJ','TJK','Tajikistan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TH','THA','Thailand');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TG','TGO','Togo');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TK','TKL','Tokelau');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TO','TON','Tonga');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TT','TTO','Trinidad and Tobago');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('AE','ARE','United Arab Emirates');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TN','TUN','Tunisia');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TR','TUR','Turkey');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TM','TKM','Turkmenistan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TC','TCA','Turks and Caicos Islands');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TV','TUV','Tuvalu');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('UG','UGA','Uganda');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('UA','UKR','Ukraine');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('MK','MKD','Macedonia, the former Yugoslav Republic of');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('EG','EGY','Egypt');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GB','GBR','United Kingdom');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('GG','GGY','Guernsey');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('JE','JEY','Jersey');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('IM','IMN','Isle of Man');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('TZ','TZA','Tanzania, United Republic of');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('US','USA','United States');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('VI','VIR','Virgin Islands, U.S.');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('BF','BFA','Burkina Faso');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('UY','URY','Uruguay');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('UZ','UZB','Uzbekistan');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('VE','VEN','Venezuela, Bolivarian Republic of');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('WF','WLF','Wallis and Futuna');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('WS','WSM','Samoa');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('YE','YEM','Yemen');
INSERT  INTO `shop_country` (`alpha2`,`alpha3`,`name`) VALUES ('ZM','ZMB','Zambia');

CREATE TABLE `shop_currency` (
  `currency_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` INT(12) UNSIGNED DEFAULT '0',
  `symbol_left` VARCHAR(3) DEFAULT '$',
  `symbol_right` VARCHAR(3) DEFAULT NULL,
  `decimal_places` INT(2) UNSIGNED DEFAULT '0',
  `thousand_seperator` VARCHAR(2) DEFAULT ',',
  `iso_code` VARCHAR(3) DEFAULT 'AUD',
  `default` TINYINT(4) UNSIGNED DEFAULT '0',
  `rate` DECIMAL(10,7) UNSIGNED DEFAULT '1.0000000',
  `exchange_currency_id` INT(12) UNSIGNED DEFAULT '0',
  `exchange_comparison_rate` DECIMAL(10,7) UNSIGNED DEFAULT '1.0000000',
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`currency_id`),
  KEY `COMMON` (`currency_id`,`item_id`,`iso_code`,`default`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT  INTO `shop_currency` (`currency_id`,`item_id`,`symbol_left`,`symbol_right`,`decimal_places`,`thousand_seperator`,`iso_code`,`default`,`rate`,`exchange_currency_id`,`exchange_comparison_rate`,`md5`,`created`,`updated`) VALUES (1,0,'$',NULL,2,',','AUD',1,'1.0000000',0,'1.0000000',NULL,0,0);

CREATE TABLE `shop_days` (
  `days_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` INT(12) UNSIGNED DEFAULT NULL,
  `monday` ENUM('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `tuesday` ENUM('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `wednesday` ENUM('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `thursday` ENUM('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `friday` ENUM('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `saturday` ENUM('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `sunday` ENUM('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER') DEFAULT '_SHOP_MI_DAYS_CLOSED',
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  `actioned` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`days_id`),
  KEY `COMMON` (`item_id`,`monday`,`tuesday`,`wednesday`,`thursday`,`friday`,`saturday`,`sunday`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_discounts` (
  `discount_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` ENUM('_SHOP_MI_DISCOUNT_QUITSTOCK','_SHOP_MI_DISCOUNT_GENERAL','_SHOP_MI_DISCOUNT_WHOLESALE','_SHOP_MI_DISCOUNT_NOREORDER','_SHOP_MI_DISCOUNT_QUANITY','_SHOP_MI_DISCOUNT_OTHER') DEFAULT '_SHOP_MI_DISCOUNT_GENERAL',
  `item_id` INT(12) UNSIGNED DEFAULT '0',
  `percentage` DECIMAL(10,5) UNSIGNED DEFAULT '0.00000',
  `min_quanity` DECIMAL(10,4) UNSIGNED DEFAULT '0.0000',
  `shipping_id` INT(12) UNSIGNED DEFAULT '0',
  `timed` TINYINT(4) DEFAULT '0',
  `start` INT(12) UNSIGNED DEFAULT '0',
  `end` INT(12) UNSIGNED DEFAULT '0',
  `opening` INT(12) UNSIGNED DEFAULT '32400',
  `closing` INT(12) UNSIGNED DEFAULT '68400',
  `days_id` INT(12) UNSIGNED DEFAULT '0',
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  `actioned` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`discount_id`),
  KEY `COMMON` (`type`,`shipping_id`,`timed`,`days_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_downloads` (
  `download_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` INT(12) UNSIGNED DEFAULT '0',
  `path` VARCHAR(255) DEFAULT NULL,
  `filename` VARCHAR(255) DEFAULT NULL,
  `mimetype` VARCHAR(128) DEFAULT NULL,
  `hits` INT(12) UNSIGNED DEFAULT '0',
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`download_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_extra` (
  `product_id` INT(12) UNSIGNED NOT NULL,
  `language` VARCHAR(64) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_field` (
  `field_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `manu_ids` VARCHAR(1000) DEFAULT NULL,
  `shop_ids` VARCHAR(1000) DEFAULT NULL,
  `cat_ids` VARCHAR(1000) DEFAULT NULL,
  `field_type` VARCHAR(30) NOT NULL DEFAULT '',
  `field_valuetype` TINYINT(2) UNSIGNED NOT NULL DEFAULT '0',
  `field_name` VARCHAR(255) NOT NULL DEFAULT '',
  `field_title` VARCHAR(255) NOT NULL DEFAULT '',
  `field_description` TEXT,
  `field_required` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `field_maxlength` SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0',
  `field_weight` SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0',
  `field_default` TEXT,
  `field_notnull` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `field_edit` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `field_show` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `field_config` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `field_options` TEXT,
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `field_name` (`field_name`),
  KEY `step` (`field_weight`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_gallery` (
  `picture_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` ENUM('_SHOP_MI_GALLERY_CAT_LOGO','_SHOP_MI_GALLERY_MANU_LOGO','_SHOP_MI_GALLERY_PRODUCT','_SHOP_MI_GALLERY_SHOP_LOGO','_SHOP_MI_GALLERY_SHIPPING_LOGO','_SHOP_MI_GALLERY_DISCOUNT_LOGO','_SHOP_MI_GALLERY_ORDER_LOGO','_SHOP_MI_GALLERY_WATERMARK') DEFAULT '_SHOP_MI_GALLERY_PRODUCT',
  `shipping_id` INT(12) UNSIGNED DEFAULT '0',
  `product_id` INT(12) UNSIGNED DEFAULT '0',
  `cat_id` INT(12) UNSIGNED DEFAULT '0',
  `manu_id` INT(12) UNSIGNED DEFAULT '0',
  `shop_id` INT(12) UNSIGNED DEFAULT '0',
  `item_id` INT(12) UNSIGNED DEFAULT '0',
  `weight` TINYINT(6) UNSIGNED DEFAULT '1',
  `path` VARCHAR(255) DEFAULT '/uploads/xshop/large',
  `thumbnail_path` VARCHAR(255) DEFAULT '/uploads/xshop/thumbnail',
  `filename` VARCHAR(255) DEFAULT NULL,
  `width` INT(10) UNSIGNED DEFAULT '0',
  `height` INT(10) UNSIGNED DEFAULT '0',
  `extension` VARCHAR(5) DEFAULT 'jpg',
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`picture_id`),
  KEY `COMMON` (`type`,`product_id`,`cat_id`,`manu_id`,`shop_id`,`weight`,`md5`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_items` (
  `item_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `languages` VARCHAR(1000) DEFAULT NULL,
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `COMMON` (`languages`(255))
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT  INTO `shop_items` (`item_id`,`languages`,`created`,`updated`) VALUES (1,'english',111111,11111);

CREATE TABLE `shop_items_digest` (
  `lang_item_id` INT(24) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` INT(12) UNSIGNED DEFAULT '0',
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `product_id` INT(12) UNSIGNED DEFAULT '0',
  `manu_id` INT(12) UNSIGNED DEFAULT '0',
  `cat_id` INT(12) UNSIGNED DEFAULT '0',
  `discount_id` INT(12) UNSIGNED DEFAULT '0',
  `shipping_id` INT(12) UNSIGNED DEFAULT '0',
  `days_id` INT(12) UNSIGNED DEFAULT '0',
  `picture_id` INT(12) UNSIGNED DEFAULT '0',
  `order_id` INT(12) UNSIGNED DEFAULT '0',
  `currency_id` INT(12) UNSIGNED DEFAULT '0',
  `shop_id` INT(12) UNSIGNED DEFAULT '0',
  `md5` VARCHAR(32) DEFAULT NULL,
  `type` ENUM('_SHOP_MI_ITEMS_MENUITEMS','_SHOP_MI_ITEMS_LONGITEMS','_SHOP_MI_ITEMS_BOTHITEMS','_SHOP_MI_ITEMS_RSSITEM','_SHOP_MI_ITEMS_RSSANDLONGITEM','_SHOP_MI_ITEMS_ALLITEMS') DEFAULT '_SHOP_MI_ITEMS_BOTHITEMS',
  `language` VARCHAR(64) DEFAULT 'english',
  `menu_title` VARCHAR(128) DEFAULT NULL,
  `long_title` VARCHAR(255) DEFAULT NULL,
  `rss_title` VARCHAR(255) DEFAULT NULL,
  `menu_subtitle` VARCHAR(128) DEFAULT NULL,
  `long_subtitle` VARCHAR(255) DEFAULT NULL,
  `menu_description` VARCHAR(255) DEFAULT NULL,
  `long_description` MEDIUMTEXT,
  `rss_description` MEDIUMTEXT,
  `meta_description` VARCHAR(255) DEFAULT NULL,
  `meta_keywords` VARCHAR(255) DEFAULT NULL,
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  `actioned` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`lang_item_id`),
  KEY `SEARCH` (`language`,`menu_title`(35),`long_title`(35),`menu_subtitle`(35),`long_subtitle`(35),`menu_description`(35),`meta_description`(20),`meta_keywords`(20)),
  KEY `COMMON` (`type`,`item_id`,`lang_item_id`,`product_id`,`manu_id`,`cat_id`,`discount_id`,`shipping_id`,`days_id`,`picture_id`,`order_id`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT  INTO `shop_items_digest` (`lang_item_id`,`uid`,`product_id`,`manu_id`,`cat_id`,`discount_id`,`shipping_id`,`days_id`,`picture_id`,`order_id`,`currency_id`,`shop_id`,`md5`,`type`,`item_id`,`language`,`menu_title`,`long_title`,`rss_title`,`menu_subtitle`,`long_subtitle`,`menu_description`,`long_description`,`rss_description`,`meta_description`,`meta_keywords`,`created`,`updated`,`actioned`) VALUES (1,0,0,0,0,0,0,0,0,0,0,0,NULL,'_SHOP_MI_ITEMS_MENUITEMS',1,'english','Australian Dollar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Australian dollar','Australian, dollar',NULL,NULL,0);

CREATE TABLE `shop_manufacturer` (
  `manu_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ordering` ENUM('_SHOP_MI_MANU_PLACESTOCKORDER','_SHOP_MI_MANU_DONTPLACESTOCKORDER','_SHOP_MI_MANU_MANUALORDER','_SHOP_MI_MANU_RAISETOPURCHASEOFFICER','_SHOP_MI_MANU_APIORDERING') DEFAULT '_SHOP_MI_MANU_PLACESTOCKORDER',
  `type` ENUM('_SHOP_MI_MANU_LOCAL','_SHOP_MI_MANU_INTERSTATE','_SHOP_MI_MANU_OVERSEAS','_SHOP_MI_MANU_INTERNAL','_SHOP_MI_MANU_UNKNOWN') DEFAULT '_SHOP_MI_MANU_UNKNOWN',
  `broker_uid` INT(13) DEFAULT '0',
  `item_id` INT(12) UNSIGNED DEFAULT '0',
  `address_id` INT(12) UNSIGNED DEFAULT '0',
  `contact_id` INT(12) UNSIGNED DEFAULT '0',
  `mobile_id` INT(12) UNSIGNED DEFAULT '0',
  `email_id` INT(12) UNSIGNED DEFAULT '0',
  `last_order_id` INT(12) UNSIGNED DEFAULT '0',
  `logo_picture_id` INT(12) UNSIGNED DEFAULT '0',
  `rating` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `votes` INT(10) UNSIGNED DEFAULT '0',
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  `actioned` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`manu_id`),
  KEY `COMMON` (`ordering`,`type`,`item_id`,`address_id`,`contact_id`,`mobile_id`,`email_id`,`last_order_id`,`logo_picture_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_orders` (
  `order_id` INT(15) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mode` ENUM('_SHOP_MI_ORDER_OPENORDER','_SHOP_MI_ORDER_CLOSEDORDER','_SHOP_MI_ORDER_CHECKEDOUT','_SHOP_MI_ORDER_GONETOINVOICING','_SHOP_MI_ORDER_OTHER') DEFAULT '_SHOP_MI_ORDER_OPENORDER',
  `remittion` ENUM('_SHOP_MI_ORDER_PAID','_SHOP_MI_ORDER_UNPAID','_SHOP_MI_ORDER_CANCELLED','_SHOP_MI_ORDER_FRAUDPAID','_SHOP_MI_ORDER_FRAUDUNPAID','_SHOP_MI_ORDER_FRAUDCANCELLED') DEFAULT '_SHOP_MI_ORDER_UNPAID',
  `key` VARCHAR(64) DEFAULT '00000-00000-00000-00000-00000-00000',
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `broker_uids` VARCHAR(1000) DEFAULT NULL,
  `sales_uids` VARCHAR(1000) DEFAULT NULL,
  `cat_ids` VARCHAR(1000) DEFAULT NULL,
  `manu_ids` VARCHAR(1000) DEFAULT NULL,
  `shop_ids` VARCHAR(1000) DEFAULT NULL,
  `product_ids` VARCHAR(1000) DEFAULT NULL,
  `shipping_id` INT(12) UNSIGNED DEFAULT '0',
  `currency_id` INT(12) UNSIGNED DEFAULT '0',
  `total` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `tax` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `shipping` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `handling` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `billing_address_id` INT(12) UNSIGNED DEFAULT '0',
  `shipping_address_id` INT(12) UNSIGNED DEFAULT '0',
  `billing_email_id` INT(12) UNSIGNED DEFAULT '0',
  `shipping_email_id` INT(12) UNSIGNED DEFAULT '0',
  `billing_contact_id` INT(12) UNSIGNED DEFAULT '0',
  `shipping_contact_id` INT(12) UNSIGNED DEFAULT '0',
  `billing_mobile_id` INT(12) UNSIGNED DEFAULT '0',
  `shipping_mobile_id` INT(12) UNSIGNED DEFAULT '0',
  `billing_fax_id` INT(12) UNSIGNED DEFAULT '0',
  `shipping_fax_id` INT(12) UNSIGNED DEFAULT '0',
  `discount_ids` VARCHAR(500) DEFAULT NULL,
  `discount_avg_percentile` DECIMAL(6,2) UNSIGNED DEFAULT '0.00',
  `discount_amount` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `started` INT(12) UNSIGNED DEFAULT '0',
  `paid` INT(12) UNSIGNED DEFAULT '0',
  `shipped` INT(12) UNSIGNED DEFAULT '0',
  `ended` INT(12) UNSIGNED DEFAULT '0',
  `offline` INT(12) UNSIGNED DEFAULT '0',
  `ip` VARCHAR(128) DEFAULT NULL,
  `netbios` VARCHAR(255) DEFAULT NULL,
  `iid` INT(30) DEFAULT '0',
  `invoice_url` VARCHAR(255) DEFAULT NULL,
  `pdf_url` VARCHAR(255) DEFAULT NULL,
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  `actioned` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`order_id`),
  KEY `COMMON` (`remittion`,`key`,`uid`,`billing_address_id`,`shipping_address_id`,`billing_email_id`,`shipping_email_id`,`billing_contact_id`,`shipping_contact_id`,`billing_mobile_id`,`shipping_mobile_id`,`billing_fax_id`,`shipping_fax_id`,`ip`,`netbios`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_orders_connotes` (
  `con_note_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `assigned_uid` INT(13) UNSIGNED DEFAULT '0',
  `type` ENUM('_SHOP_MI_CONNOTE_EXPRESS','_SHOP_MI_CONNOTE_STANDARD','_SHOP_MI_CONNOTE_RETURNED','_SHOP_MI_CONNOTE_BYSEA','_SHOP_MI_CONNOTE_BYROAD','_SHOP_MI_CONNOTE_BYPLANE','_SHOP_MI_CONNOTE_BYTRAIN') DEFAULT '_SHOP_MI_CONNOTE_STANDARD',
  `shipping_id` INT(12) UNSIGNED DEFAULT '0',
  `address_id` INT(12) UNSIGNED DEFAULT '0',
  `contact_id` INT(12) DEFAULT '0',
  `dispatched` INT(13) UNSIGNED DEFAULT '0',
  `returned` INT(13) UNSIGNED DEFAULT '0',
  `number` VARCHAR(128) DEFAULT NULL,
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  `actioned` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`con_note_id`),
  KEY `COMMON` (`assigned_uid`,`type`,`shipping_id`,`address_id`,`contact_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_orders_digest` (
  `product_order_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT(12) UNSIGNED DEFAULT '0',
  `con_note_id` INT(12) UNSIGNED DEFAULT '0',
  `shipping_id` INT(12) UNSIGNED DEFAULT '0',
  `shop_id` INT(12) UNSIGNED DEFAULT '0',
  `cat_id` INT(12) UNSIGNED DEFAULT '0',
  `manu_id` INT(12) UNSIGNED DEFAULT '0',
  `product_id` INT(12) UNSIGNED DEFAULT '0',
  `quanity` DECIMAL(10,4) UNSIGNED DEFAULT '0.0000',
  `price` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `shipping` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `handling` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `tax` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `weight` DECIMAL(15,6) DEFAULT '0.000000',
  `weight_measurement` ENUM('_SHOP_MI_WEIGHT_KILOS','_SHOP_MI_WEIGHT_POUNDS','_SHOP_MI_WEIGHT_OTHER') DEFAULT '_SHOP_MI_WEIGHT_KILOS',
  `discount_given` TINYINT(4) UNSIGNED DEFAULT '0',
  `discount_id` INT(12) UNSIGNED DEFAULT '0',
  `discount_percentile` DECIMAL(6,4) UNSIGNED DEFAULT '0.0000',
  `discount_amount` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `md5` VARCHAR(32) DEFAULT NULL,
  PRIMARY KEY (`product_order_id`),
  KEY `COMMON` (`order_id`,`con_note_id`,`shipping_id`,`shop_id`,`cat_id`,`manu_id`,`product_id`,`discount_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_products` (
  `product_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock` ENUM('_SHOP_MI_PRODUCTS_INSTOCK','_SHOP_MI_PRODUCTS_OUTSTOCK','_SHOP_MI_PRODUCTS_NOREORDER','_SHOP_MI_PRODUCTS_QUITSTOCK','_SHOP_MI_PRODUCTS_SUPLUSSTOCK') DEFAULT '_SHOP_MI_PRODUCTS_INSTOCK',
  `type` ENUM('_SHOP_MI_PRODUCTS_SERVICE','_SHOP_MI_PRODUCTS_TANGIABLEITEM','_SHOP_MI_PRODUCTS_SERVICEANDITEM') DEFAULT '_SHOP_MI_PRODUCTS_TANGIABLEITEM',
  `uid` INT(14) DEFAULT '0',
  `sales_uid` INT(13) UNSIGNED DEFAULT '0',
  `broker_uid` INT(13) UNSIGNED DEFAULT '0',
  `shop_id` INT(12) UNSIGNED DEFAULT '0',
  `cat_id` INT(12) UNSIGNED DEFAULT '0',
  `manu_id` INT(12) UNSIGNED DEFAULT '0',
  `item_id` INT(12) UNSIGNED DEFAULT '0',
  `currency_id` INT(12) DEFAULT '0',
  `shipping_id` INT(12) DEFAULT '0',
  `feature_picture_id` INT(12) DEFAULT '0',
  `discount_id` INT(12) DEFAULT '0',
  `wholesale_discount_id` INT(12) DEFAULT '0',
  `cat_number` VARCHAR(25) DEFAULT NULL,
  `sub_model` VARCHAR(35) DEFAULT NULL,
  `cat_prefix` VARCHAR(3) DEFAULT NULL,
  `cat_subfix` VARCHAR(3) DEFAULT NULL,
  `unit_price` DECIMAL(15,4) DEFAULT '0.0000',
  `unit_wholesale_price` DECIMAL(14,4) DEFAULT '0.0000',
  `weight_per_unit` DECIMAL(15,6) DEFAULT '0.000000',
  `weight_measurement` ENUM('_SHOP_MI_WEIGHT_KILOS','_SHOP_MI_WEIGHT_POUNDS','_SHOP_MI_WEIGHT_OTHER') DEFAULT '_SHOP_MI_WEIGHT_KILOS',
  `quanity_in_unit` DECIMAL(15,4) DEFAULT '0.0000',
  `quanity_for_wholesale` DECIMAL(15,4) DEFAULT '0.0000',
  `quanity_measured` VARCHAR(10) DEFAULT NULL,
  `quanity_in_warehouse` INT(10) DEFAULT '0',
  `quanity_to_order` INT(10) DEFAULT '0',
  `tag` VARCHAR(255) DEFAULT NULL,
  `rating` DECIMAL(15,4) DEFAULT '0.0000',
  `votes` INT(12) DEFAULT '0',
  `last_ordered` INT(12) DEFAULT '0',
  `shippment_arrived` INT(12) DEFAULT '0',
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(12) DEFAULT '0',
  `updated` INT(12) DEFAULT '0',
  `actioned` INT(12) DEFAULT '0',
  PRIMARY KEY (`product_id`),
  KEY `COMMON` (`stock`,`type`,`uid`,`cat_id`,`manu_id`,`item_id`,`currency_id`,`shipping_id`,`feature_picture_id`,`discount_id`,`wholesale_discount_id`),
  KEY `SEARCH` (`cat_number`,`sub_model`,`cat_prefix`,`cat_subfix`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_regions` (
  `region_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) DEFAULT NULL,
  `longitude` DECIMAL(15,10) DEFAULT NULL,
  `latitude` DECIMAL(15,10) DEFAULT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_shipping` (
  `shipping_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` ENUM('_SHOP_MI_SHIPPING_LOCAL','_SHOP_MI_SHIPPING_INTERSTATE','_SHOP_MI_SHIPPING_OVERSEAS','_SHOP_MI_SHIPPING_INTERNAL','_SHOP_MI_SHIPPING_BYSEA','_SHOP_MI_SHIPPING_BYROAD','_SHOP_MI_SHIPPING_BYTRAIN','_SHOP_MI_SHIPPING_BYPLANE','_SHOP_MI_SHIPPING_EXPRESS','_SHOP_MI_SHIPPING_UNKNOWN') DEFAULT '_SHOP_MI_SHIPPING_UNKNOWN',
  `method` ENUM('_SHOP_MI_SHIPPING_MANUALPHONECALL','_SHOP_MI_SHIPPING_EMAIL','_SHOP_MI_SHIPPING_APICALL','_SHOP_MI_SHIPPING_FAX','_SHOP_MI_SHIPPING_OTHER') DEFAULT '_SHOP_MI_SHIPPING_MANUALPHONECALL',
  `uid` INT(12) UNSIGNED DEFAULT '0',
  `broker_uids` VARCHAR(500) DEFAULT NULL,
  `item_id` INT(12) UNSIGNED DEFAULT '0',
  `address_id` INT(12) UNSIGNED DEFAULT '0',
  `contact_id` INT(12) UNSIGNED DEFAULT '0',
  `mobile_id` INT(12) UNSIGNED DEFAULT '0',
  `email_id` INT(12) UNSIGNED DEFAULT '0',
  `logo_picture_id` INT(12) UNSIGNED DEFAULT '0',
  `price_per_kilo` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `price_per_pound` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `price_per_other` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `country_ids` VARCHAR(1500) DEFAULT NULL,
  `handling_per_unit` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `region_ids` VARCHAR(1500) DEFAULT NULL,
  `opening` INT(10) UNSIGNED DEFAULT '25200',
  `closing` INT(10) UNSIGNED DEFAULT '68400',
  `days_id` INT(12) UNSIGNED DEFAULT '0',
  `rating` DECIMAL(15,4) DEFAULT '0.0000',
  `votes` INT(10) UNSIGNED DEFAULT '0',
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  `actioned` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`shipping_id`),
  KEY `COMMON` (`type`,`method`,`uid`,`item_id`,`address_id`,`contact_id`,`mobile_id`,`email_id`,`logo_picture_id`,`days_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_shops` (
  `shop_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` ENUM('_SHOP_MI_SHOPS_PHYSICALSTORE','_SHOP_MI_SHOPS_DELIVERYRUN','_SHOP_MI_SHOPS_SERVICECENTER','_SHOP_MI_SHOPS_SERVICEWAREHOUSE','_SHOP_MI_SHOPS_SERVICE','_SHOP_MI_SHOPS_OTHER') DEFAULT '_SHOP_MI_SHOPS_PHYSICALSTORE',
  `uid` INT(12) UNSIGNED DEFAULT '0',
  `admin_uids` VARCHAR(500) DEFAULT NULL,
  `broker_uids` VARCHAR(500) DEFAULT NULL,
  `sales_uids` VARCHAR(500) DEFAULT NULL,
  `email_id` INT(12) UNSIGNED DEFAULT '0',
  `address_id` INT(12) UNSIGNED DEFAULT '0',
  `phone_id` INT(12) UNSIGNED DEFAULT '0',
  `mobile_id` INT(12) UNSIGNED DEFAULT '0',
  `fax_id` INT(12) UNSIGNED DEFAULT '0',
  `item_id` INT(12) UNSIGNED DEFAULT '0',
  `logo_picture_id` INT(12) UNSIGNED DEFAULT '0',
  `delievery_id` INT(12) UNSIGNED DEFAULT '0',
  `express_id` INT(12) UNSIGNED DEFAULT '0',
  `sms_id` INT(12) UNSIGNED DEFAULT '0',
  `serviced_id` INT(12) UNSIGNED DEFAULT '0',
  `days_id` INT(12) UNSIGNED DEFAULT '0',
  `timed` TINYINT(4) DEFAULT '0',
  `start` INT(12) DEFAULT '0',
  `end` INT(12) DEFAULT '0',
  `opening` INT(10) UNSIGNED DEFAULT '32400',
  `closed` INT(10) UNSIGNED DEFAULT '68400',
  `sales_in_store` TINYINT(4) UNSIGNED DEFAULT '1',
  `sales_online` TINYINT(4) UNSIGNED DEFAULT '1',
  `sales_with_warehouse` TINYINT(4) UNSIGNED DEFAULT '1',
  `max_discount` DECIMAL(6,2) UNSIGNED DEFAULT '5.00',
  `special_product_id` INT(12) UNSIGNED DEFAULT '0',
  `special_cat_id` INT(12) UNSIGNED DEFAULT '0',
  `special_manu_id` INT(12) UNSIGNED DEFAULT '0',
  `24hour_online` TINYINT(4) UNSIGNED DEFAULT '0',
  `24hour_ordering` TINYINT(4) DEFAULT '0',
  `rating` DECIMAL(15,4) UNSIGNED DEFAULT '0.0000',
  `votes` INT(10) UNSIGNED DEFAULT '0',
  `md5` VARCHAR(32) DEFAULT NULL,
  `created` INT(12) UNSIGNED DEFAULT '0',
  `updated` INT(12) UNSIGNED DEFAULT '0',
  `actioned` INT(12) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`shop_id`),
  KEY `COMMON` (`type`,`sales_uids`(64),`broker_uids`(64),`admin_uids`(64),`address_id`,`phone_id`,`mobile_id`,`fax_id`,`item_id`,`logo_picture_id`,`delievery_id`,`express_id`,`sms_id`,`serviced_id`,`days_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `shop_visibility` (
  `field_id` INT(12) UNSIGNED NOT NULL DEFAULT '0',
  `user_group` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
  `profile_group` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`field_id`,`user_group`,`profile_group`),
  KEY `visible` (`user_group`,`profile_group`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;