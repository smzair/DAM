<?php
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\S3\MultipartUploader;
use App\Models\Skus;
use App\Models\Wrc;
use App\Models\Lots;
use Illuminate\Support\Facades\DB;
use App\Models\CatalogMarketplaceCredentials;
use App\Models\Marketplace;
use App\Models\NotificationModel\ClientNotification;

if (!function_exists('s3object')) {

    function s3object() {
        $s3 = S3Client::factory(
            array(
                'credentials' => array(
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY')
                ),
                'version' => 'latest',
                'region' => env('AWS_DEFAULT_REGION')
            )
        );
        return $s3;
    }

}

if (!function_exists('commercial_wise_MarketplaceCredentials_list')) {

    function commercial_wise_MarketplaceCredentials_list()
    {
        $data = CatalogMarketplaceCredentials::leftJoin('marketplaces', 'marketplaces.id', 'catalog_marketplace_credentials.marketplace_id')->select(
                'catalog_marketplace_credentials.id',
                'catalog_marketplace_credentials.commercial_id',
                'catalog_marketplace_credentials.link',
                'catalog_marketplace_credentials.username',
                'catalog_marketplace_credentials.password',
                'catalog_marketplace_credentials.marketplace_id',
                'marketplaces.marketPlace_name'
            )->get()->toArray();
        return $data;
    }
}


if (!function_exists('s3postObject')) {

    function s3postObject($key, $sourceFile) {
        $s3 = s3object();
        $result = $s3->putObject(array(
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $key,
            'SourceFile' => $sourceFile,
            'Metadata' => array(
            )
        ));
        return $result;
    }

}

if (!function_exists('s3getObject')) {

    function s3getObject($key, $saveAs) {
        $s3 = s3object();
        $result = $s3->getObject(array(
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $key,
            'SaveAs' => $saveAs
        ));
        return $result;
    }

}

if (!function_exists('pr')) {

	function pr($data, $die = 0) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";

		if($die == 1){
			die;
		}
		return;
	}

}
if (!function_exists('genderList')) {

	function genderList() {
		return array('Male', 'Female', 'Mix');
	}

}

if (!function_exists('dateFormat')) {

	function dateFormat($time) {
		return date('d-M-Y', strtotime($time));
	}

}

if (!function_exists('timeFormat')) {

	function timeFormat($time) {
		return date('h:i:s A', strtotime($time));
	}

}

if (!function_exists('getTypeOfShootList')) {

	function getTypeOfShootList($id = '') {
		$typeOfShootList = 
		array('Apparel model with ghost shots' => 'Apparel model with ghost shots',
		    'Apparel model' => 'Apparel Model',
		       'Model Shoot' => 'Model Shoot',
			'Product Shoot' => 'Product Shoot',
			'Table-Top shoot'=>'Table-Top Shoot',
			'Apparel mannequin'=> 'Apparel mannequin',
			'Flat lay shoot'=> 'Flat lay shoot',
			'Flat Lay shoot Large Size Apparels'=> 'Flat Lay shoot Large Size Apparels',
			'Ghost Mannequin Shoot'=> 'Ghost Mannequin Shoot',
			'Hanger_Table Top_Flat Lay Shoot'=> 'Hanger_Table Top_Flat Lay Shoot',
			'Apparel Model_Flat Lay Shoot'=> 'Apparel Model_Flat Lay Shoot',
			'Creative Shoot'=> 'Creative Shoot',
			'Editing'=>'Editing',
			
			'Product Shoot with Model'=>'Product Shoot with Model',
			'Hanger Shoot'=>'Hanger Shoot',
			'Extra Mood Shot'=>'Extra Mood Shot',
			'Lifestyle Non-Model Shoot for Products'=>'Lifestyle Non-Model Shoot for Products',
			'Catalog Videos'=>'Catalog Videos',
			'360 Videos'=>'360 Videos',
			'360 Degree'=>'360 Degree',
			'360 Videos without model'=>'360 Videos without model',
			'Stylized Videos'=>'Stylized Videos',
			'Banner Shoot'=>'Banner Shoot',
				'Texture Shot'=>'Texture Shot',
				'Catalog videos + Catalog shoot'=>'Catalog videos + Catalog shoot',
				'Detail Angles' =>'Detail Angles',
				'Utility Shot'=>'Utility Shot',
				'Catalog shoot'=>'Catalog shoot',
				'Filling shot'=>'Filling shot',
				'Group shot'=>'Group shot',
				'High Resolution Images'=>'High Resolution Images'
			);



		if (!empty($id) && isset($typeOfShootList[$id])) {
			$typeOfShootList = $typeOfShootList[$id];
		}
		return $typeOfShootList;
	}

}




if (!function_exists('getAdaptationsList')) {

	function getAdaptationsList($id = '') {
		$adaptationsList = 
		array('Brand-Site'=>'Brand-Site',
		'Noon'=>'Noon',
		'Noon-Athletiq'=>'Noon-Athletiq',
		    'Noon-DRIP' => 'Noon-DRIP',
		    'Noon-QUWA' => 'Noon-QUWA',
		    'Noon-OFFROAD' => 'Noon-OFFROAD',
		    'Noon-AILA' => 'Noon-AILA',
		    'Noon-NEON' => 'Noon-NEON',
		    'Noon-SHIVCRAFT' => 'Noon-SHIVCRAFT',
		    'Noon-ZARAFA' => 'Noon-ZARAFA',
		    'Tata Cliq'=>'Tata Cliq',
		    'Tata cliq luxury'=>'Tata cliq luxury',
			'Flipkart'=>'Flipkart',
			'Snapdeal'=>'Snapdeal',
			'Amazon' => 'Amazon',
			'Myntra'=>'Myntra',
			'Myntra_premium'=>'Myntra Premium',
			'Ajio'=>'Ajio',
			'Nykaa'=>'Nykaa',
		    'Nykaa Fashion'=>'Nykaa Fashion',
			'First Cry'=>'First Cry',
			'Meesho'=>'Meesho',
			'NA' => 'NA',
			'STATE 8'=>'STATE 8',
			'High Resolution'=>'High Resolution',
			'Low White'=>'Low White',
			'Low Grey'=>'Low Grey',
		    'Myntra OMNI'=>'Myntra OMNI',
		    'Purple'=>'Purple',
		    'Netmeds'=>'Netmeds',
		    'Lime road'=>'Lime road',
			 'Namashi'=>'Namashi'
			
		);


		if (!empty($id) && isset($adaptationsList[$id])) {
			$adaptationsList = $adaptationsList[$id];
		}
		return $adaptationsList;
	}

}


if (!function_exists('modeOfDelivary')) {
    function modeOfDelivary()
    {
        $modeOfDelivary = array(
            '1' => 'Uploading',
            '2' => 'Excel Sheet',
            '3' => 'Drive Link',
            '4' => 'Doc',
            '5' => 'Zip',
        );
        return $modeOfDelivary;
    }
}

// Copy writer
if (!function_exists('getcopyWriter')) {

    function getcopyWriter()
    {
        $users = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['roles.name', '=', 'CW']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short'])->toArray();
        return $users;
    }
}

// Cataloguer
if(!function_exists('getCataloguer')){
    
    function getCataloguer(){
        $users = DB::table('users')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->where([['roles.name', '=', 'Cataloguer']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short'])->toArray();
        return $users;   
    }
}

// Editors
if (!function_exists('getEditors')) {

    function getEditors()
    {
        $users = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['roles.name', '=', 'Editors']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short'])->toArray();
        return $users;
    }
}

if (!function_exists('getProductList')) {

	function getProductList($id = '') {
		$productList = 
		array('Athleisure' => 'Athleisure',
			'Bags/Wallets/Facemask/Socks & Other Accessories' => 'Bags/Wallets/Face Mask/Socks & Other Accessories',
			'Bags/Wallets/Other Accessories'=>'Bags/Wallets/Other Accessories',
			'Bags/Wallets/Other Accessories(Facemasks)'=> 'Bags/Wallets/Other Accessories (Face Masks)',
			'Bags/Wallets/Other Accessories (Socks)'=>'Bags/Wallets/Other Accessories (Socks)',
			'Briefs (Lingerie/ Innerwear)'=>'Briefs (Lingerie/ Innerwear)',
			'Dupattas'=>'Dupattas',
			'Food Products'=>'Food Products',
			'Footwear'=>'Footwear',
			'kidswear'=>'Kidswear',
			'Kidswear (Hanger Shoot)'=>'Kidswear ( Hanger Shoot)',
			'Kidswear Mask / Mask on Mannequin'=>'Kidswear Mask / Mask on Mannequin',
			'Food Products'=>'Food Products',
			'Footwear'=>'Footwear',
			'Gift Sets'=>'Gift Sets',
			'Gym Equipments'=>'Gym Equipments',
			'Home/Personal Care Products'=>'Home/Personal Care Products',
			'Infographics'=>'Infographics',
			'Men Casual'=>'Men Casual',
			'Men Suits'=>'Men Suits',
			'Mens Undergarments (briefs and trunks)'=>'Mens Undergarments (briefs and trunks)',
			'Mens Undergarments'=>'Mens Undergarments',
			'Other Accessories - Stoles & Scarves'=>'Other Accessories - Stoles & Scarves',
			'Sarees/Lehangas'=>'Sarees/Lehangas',
			'Sets'=>'Sets',
			'Sports Equipments'=>'Sports Equipments',
			'Stylised Video'=>'Stylised Video',
			'Unisex Casual / Formal'=>'Unisex Casual / Formal',
			'Watches/Jewellery (non reflective)'=>'Watches/Jewellery (non reflective)',
			'Watches/Jewellery (reflective)'=>'Watches/Jewellery (reflective)',
			'Stylised Video'=>'Stylised Video',
			'Combo Sets'=>'Combo Sets',
			'Electronics'=>'Electronics',
			'Extra Mood Shot'=>'Extra Mood Shot',
			'Flat Lay Creative Shoot'=>'Flat Lay Creative Shoot',
			'Kidswear Sets'=>'Kidswear Sets',
			'Kids Toys'=>'Kids Toys',
			'Kidswear Singles'=>'Kidswear Singles', 
			'Lingerie/Innerwear - Singles'=>'Lingerie/Innerwear - Singles',
			'Lingerie/Innerwear - Sets'=>'Lingerie/Innerwear - Sets',
			'Loungewear/Nightwear'=>'Loungewear/Nightwear',
			'Men Accessories - Bracelets, Cufflinks, Pocket Squares,Ties'=>'Men Accessories - Bracelets, Cufflinks, Pocket Squares,Ties',
			'Men Casual - Table top'=>'Men Casual - Table top',
			'Men Casual - Product Functionality'=>'Men Casual - Product Functionality',
			'Men Casual Model shoot'=>'Men Casual Model shoot',
			'Men Formal'=>'Men Formal',
			'Women Casual / Kurtis - Premium Shoot'=>'Women Casual / Kurtis - Premium Shoot',
			'Watches / Jewellery - reflective'=>'Watches / Jewellery - reflective',
			'Women Casual / Kurtis'=>'Women Casual / Kurtis',
			'Women Formal'=>'Women Formal',
			'Mens Western Wear'=>'Mens Western Wear',
            'Women Western Wear'=>'Women Western Wear',
            'Mens Ethnic Wear'=>'Mens Ethnic Wear',
            'Women Ethnic Wear'=>'Women Ethnic Wear',
            'Footwear & Lifestyle Accessories'=>'Footwear & Lifestyle Accessories',
            'Handbags-Backpacks'=>'Handbags-Backpacks',
            'Jewellery, Watches, Personal Care & Other Metal/Glass Accessories (Non-Reflective)
'=>'Jewellery, Watches, Personal Care & Other Metal/Glass Accessories (Non-Reflective)
',
            'Jewellery, Watches, Personal Care & Other Metal/Glass Accessories (Reflective)'=>'Jewellery, Watches, Personal Care & Other Metal/Glass Accessories (Reflective)',
            '7-Stripe Doormat 40*60 cm'=>'7-Stripe Doormat 40*60 cm',
'7-Stripe Doormat 45*90 cm'=>'7-Stripe Doormat 45*90 cm',
'PVC S-mat 90*60 cm' =>'PVC S-mat 90*60 cm',
'PVC S-mat 90*90 cm'=>'PVC S-mat 90*90 cm',
'7-Stripe Doormat 60*120 cm'=>'7-Stripe Doormat 60*120 cm',
'PVC S-mat 90*150 cm' =>'PVC S-mat 90*150 cm',
'Grab bar 30/50/60 cm'=>'Grab bar 30/50/60 cm',
'Grab bar flip-up'=>'Grab bar flip-up',
'7-stripe 45x75'=>'7stripe 45x75',
'Home Decor'=>'Home Decor',
'Home Essentials'=>'Home Essentials',
'Bed Sheets'=>'Bed Sheets');

		if (!empty($id) && isset($productList[$id])) {
			$productList = $productList[$id];
		}
		return $productList;
	}

}



if (!function_exists('getStatus')) {

	function getStatus($id = '') {
		$statusList = 
		array('inwarding' => 'Inwarding', 'ready_for_shoot' => 'Ready For Shoot', 'ready_for_shoot' => 'Ready For Shoot','ready_for_editing' => 'Ready For Editing','ready_for_qc' => 'Ready For QC','1st_preview' => '1st Preview','submited'=>'Submited');
		
		if (!empty($id) && isset($statusList[$id])) {
			$statusList = $statusList[$id];
		}
		return $statusList;
	}

}


if (!function_exists('getLotServiceList')) {

	function getLotServiceList($id = '') {
		$lotServiceList = 
		array('ES' => 'E-commerce Shoots','CCP' => 'Creative Content Production', 'CA' => 'Cataloging','MC' => 'Marketing Creatives', 'ODNV' => 'ODN Verse');


		if (!empty($id) && isset($lotServiceList[$id])) {
			$lotServiceList = $lotServiceList[$id];
		}
		return $lotServiceList;
	}
	

}




if(!function_exists('getLotNo')){
    function getLotNo($c_short = "c_short" , $short_name = "short_name" ,$s_type_name = "s_type"){
        $s_type ="";
        $serviceType_array = explode(" ", $s_type_name);
        foreach($serviceType_array  as $key => $val){
            $s_type .= $val[0];
        }
        return $lot_number = strtoupper('ODN'.date('dmY')."-".$c_short.$short_name.$s_type);
    }

}

// date formet functions YYYY-MM-DD
if(!function_exists('dateFormet_ymd')){
    function dateFormet_ymd($date){
        return date('Y-m-d' , strtotime($date));
    }
}

// date formet functions DD-MM-YYYY
if (!function_exists('dateFormet_dmy')) {
    function dateFormet_dmy($date)
    {
        return date('d-m-Y', strtotime($date));
    }
}

// date formet functions MM-DD-YYYY
if (!function_exists('dateFormet_mdy')) {
    function dateFormet_mdy($date)
    {
        return date('m/d/Y', strtotime($date));
    }
}

if (!function_exists('projectType')) {
    function projectType()
    {
        $projectType  = (object) array(
            array(
                'id' => "1",
                'value' => 'Enhanced Content',
            ),
            array(
                'id' => "2",
                'value' => 'Creative Graphics'
            ),
            array(
                'id' => "3",
                'value' => 'Social Media'
            ),
            array(
                'id' => "4",
                'value' => 'Web/DM/MPM'
            )
        );
        return   $projectType;
    }
}

// kind of Work
if (!function_exists('kindOfWork')) {
    function kindOfWork()
    {
        $kindOfWork  = (object) array(
            array(
                'id' => "1",
                'value' => 'Website',
            ), array(
                'id' => "20",
                'value' => 'Static posts',
            ), array(
                'id' => "21",
                'value' => 'Stories',
            ),
            array(
                'id' => "2",
                'value' => 'Videos'
            ),
             array(
                'id' => "22",
                'value' => 'A+ Content'
            ),
              array(
                'id' => "23",
                'value' => 'Product Title & Description'
            ),
             array(
                'id' => "24",
                'value' => 'Infographics'
            ),
            array(
                'id' => "25",
                'value' => 'Image Enhancement'
            ),
            array(
                'id' => "26",
                'value' => 'Adapts'
            ),
            array(
                'id' => "3",
                'value' => 'Social Media'
            ),
            array(
                'id' => "4",
                'value' => 'Stock Images'
            ),
            array(
                'id' => "5",
                'value' => 'Social Media Content'
            ),
            array(
                'id' => "6",
                'value' => 'Presentation'
            ),
            array(
                'id' => "7",
                'value' => 'Pages Design'
            ),
            array(
                'id' => "8",
                'value' => 'Mailers'
            ),
            array(
                'id' => "9",
                'value' => 'HTML/Banner'
            ),
            array(
                'id' => "10",
                'value' => 'GIF'
            ),
            array(
                'id' => "11",
                'value' => 'Engagement'
            ),
            array(
                'id' => "12",
                'value' => 'Gamification'
            ),
            array(
                'id' => "13",
                'value' => 'Copy'
            ),
            array(
                'id' => "14",
                'value' => 'Concept'
            ),
            array(
                'id' => "15",
                'value' => 'Campaign'
            ),
            array(
                'id' => "16",
                'value' => 'Branding'
            ),
            array(
                'id' => "17",
                'value' => 'Brand Audit'
            ),
            array(
                'id' => "18",
                'value' => 'Banners'
            ),
            array(
                'id' => "19",
                'value' => '3D Render'
            ),
              array(
                'id' => "27",
                'value' => 'Homepage banner creatives'
            ),
              array(
                'id' => "27",
                'value' => 'CLP Hero banner creatives'
            ),
             array(
                'id' => "28",
                'value' => 'Banners'
            ),
             array(
                'id' => "29",
                'value' => 'Collection'
            ),
             array(
                'id' => "30",
                'value' => 'Launch'
            ),
             array(
                'id' => "30",
                'value' => 'Contest'
            ),
             array(
                'id' => "31",
                'value' => 'NSO'
            ),
             array(
                'id' => "32",
                'value' => 'Announcements'
            ),
             array(
                'id' => "33",
                'value' => 'Announcements'
            ),
             array(
                'id' => "34",
                'value' => 'Season Facelift'
            ),
             array(
                'id' => "35",
                'value' => 'Festive/Occasion Facelift'
            ),
             array(
                'id' => "36",
                'value' => 'Sales Facelift'
            ),
             array(
                'id' => "37",
                'value' => 'HTML'
            ),
             array(
                'id' => "38",
                'value' => 'JSS'
            ),
             array(
                'id' => "39",
                'value' => 'Link banners'
            ),
             array(
                'id' => "40",
                'value' => 'Homepage Banners + Copies'
            ),
             array(
                'id' => "41",
                'value' => 'Category Page Banners + Copies'
            ),
             array(
                'id' => "42",
                'value' => 'Editorial Banners & Copies'
            ),
             array(
                'id' => "423",
                'value' => 'Home Page Concept + Makeover'
            ),
             array(
                'id' => "44",
                'value' => 'Engagement/ Gamification'
            ),
             array(
                'id' => "45",
                'value' => 'Mailers'
            ),
             array(
                'id' => "46",
                'value' => 'Website Management of Creatives'
            ),
             array(
                'id' => "47",
                'value' => 'RPD'
            ),
             array(
                'id' => "48",
                'value' => 'PMC-Set'
            ),
             array(
                'id' => "49",
                'value' => 'PMC-Adapt'
            ),
             array(
                'id' => "50",
                'value' => 'PMC-Master'
            ),
             array(
                'id' => "51",
                'value' => 'WIN-Set'
            ),
             array(
                'id' => "52",
                'value' => 'WIN-ExplainerChange'
            ),
             array(
                'id' => "53",
                'value' => 'Superimposition'
            ),
             array(
                'id' => "54",
                'value' => 'Brand Store'
            ),
             array(
                'id' => "55",
                'value' => 'Title Desciption & Keypoints'
            ),
             array(
                'id' => "56",
                'value' => 'A+ Content'
            ),
             array(
                'id' => "57",
                'value' => 'A+ Adapt'
            ),
             array(
                'id' => "58",
                'value' => 'Master Creatives'
            ),
             array(
                'id' => "59",
                'value' => 'Animated Video'
            ),
             array(
                'id' => "60",
                'value' => 'Video Adapts'
            ),
             array(
                'id' => "61",
                'value' => 'Video Adapts'
            ),
             array(
                'id' => "62",
                'value' => 'Template Based: Only Copy Change Job'
            ),
             array(
                'id' => "63",
                'value' => 'Template Based: Only Image Change Job'
            ),
             array(
                'id' => "64",
                'value' => 'Template Based: Only Copy + Images Change with Shadow Job'
            ),
             array(
                'id' => "65",
                'value' => 'Template Based: Only Copy + Images + Colour Change with Shadow Job'
            ),
             array(
                'id' => "66",
                'value' => 'New Template Creation'
            ),
             array(
                'id' => "67",
                'value' => 'Super Impose Creative'
            ),
             array(
                'id' => "68",
                'value' => 'Large Banner (500px and onwards in height or width)'
            ),
             array(
                'id' => "69",
                'value' => 'Large Banner with copy'
            ),
             array(
                'id' => "70",
                'value' => 'Small Banner (Under 500px)'
            ),
             array(
                'id' => "71",
                'value' => 'Fashion Full Store (45-65 creatives)'
            ),
             array(
                'id' => "72",
                'value' => 'Category Landing Page (Includes UI/UX inputs & Copy)'
            ),
             array(
                'id' => "73",
                'value' => 'Half Landing Page (30-45 creatives)'
            ),
             array(
                'id' => "74",
                'value' => 'GIF (Motion Graphic 6-10 seconds)'
            ),
             array(
                'id' => "75",
                'value' => 'GIF Edits(Motion Graphics 6-10 seconds)'
            ),
             array(
                'id' => "76",
                'value' => 'Stop Motion (With Music 12-35 seconds)'
            ),
             array(
                'id' => "77",
                'value' => 'Stop Motion Produced Videos (With Music 45 sec-60secs)'
            ),
             array(
                'id' => "78",
                'value' => 'Sale Videos (With Music 7-12 seconds)'
            ),
             array(
                'id' => "79",
                'value' => 'Video Dimension Edits only'
            )
        );
        return   $kindOfWork;
    }
}
// Marketplace
if (!function_exists('getMarketPlace')) {

    function getMarketPlace() {

        $getMarketPlace = Marketplace::get(['id', 'marketPlace_name', 'link', 'username', 'password'])->toArray();
        return $getMarketPlace;
    }
}

// Type of Service
if (!function_exists('getTypeOfService')) {

    function getTypeOfService()
    {
        $getTypeOfService = array(
            'Fossil Master Sheet' => 'Fossil Master Sheet',
            'Creative Descriptions' => 'Creative Descriptions',
            'GHC Content + Descriptions + Images Scraping' => 'GHC Content + Descriptions + Images Scraping',
            'Content Sheet Creation' => 'Content Sheet Creation',
            'Content Sheet Creation & Uploading' => 'Content Sheet Creation & Uploading',
            'Uploading' => 'Uploading',
                'latching' => 'latching',
            'Image Scraping' => 'Image Scraping',
            'Fossil Carryover SKUs' => 'Fossil Carryover SKUs'
        );
        return $getTypeOfService;
    }
}

// pre 
if (!function_exists('pre')){
    function pre($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
        return ;
    }
}

// user/compny data
if(!function_exists('getUserCompanyData')){

    function getUserCompanyData(){
        $users = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

         return $users;   
    }
}

if(!function_exists('get_date_time')){
    function get_date_time($time_in_second){
        $second = $time_in_second % 60;
        if (($second <= 9)) {
            $second = '0' . $second;
        }
        
        $minutes = floor(($time_in_second / 60) % 60);
        if (($minutes <= 9)) {
            $minutes = '0' . $minutes;
        }

        $hours = floor(($time_in_second /  (60*60)) % 24);
        
        if (($hours <= 9)) {
            $hours = '0' . $hours;
        }
        return $mainDuration =  $hours . 'h ' . $minutes . 'min ' . $second.'sec';
    }
}

if (!function_exists('getUsersRole')) {

    function getUsersRole($id)
    {
        $users = DB::table('model_has_roles')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->where([['model_has_roles.model_id', '=', $id]])->get(['roles.name as role_name' , 'model_has_roles.role_id'])->first();
        return $users;
    }
}

// all unseen client's notification list 
if(!function_exists('getNotificationList')){
    function getNotificationList($user_data){
        $is_seen= 0;
        $clientNotificationList = ClientNotification::clientNotificationList($user_data , $is_seen);
        return $clientNotificationList;
    }
}

// timeBefore
if(!function_exists('timeBefore')){
    function timeBefore($created_at){

        $create_date_is = date('Y-m-d H:i:s',strtotime($created_at));										
        $cur_date = date("Y-m-d H:i:s");
        $date1=date_create($create_date_is);
        $date2=date_create($cur_date);
        $diff=date_diff($date1,$date2);
        $day_ago = $diff->format("%m month %a days %H hour %i min %s sec ago \n");
        $created_at_new = ", At ".date('d-M-Y h:i A',strtotime($created_at));

        if ($diff->format("%Y") != 0) {
            $day_ago = $diff->format("%Y Year ago").$created_at_new;										 	
        }else  if ($diff->format("%m") > 0) {
            $day_ago = $diff->format("%m Month ago").$created_at_new;
        }else  if ($diff->format("%a") != 0) {
            $day_ago = $diff->format("%a day ago").", At ".date('h:i A',strtotime($created_at));
        }else  if ($diff->format("%H") != 0) {
            $day_ago = $diff->format("%H hour ago").", At ".date('h:i A',strtotime($created_at));
        }else{
            $day_ago = $diff->format("%i minute %s second ago");
        }
        return $day_ago;        
    }
}

if(!function_exists('creative_and_cataloging_lot_statusArr')){
    function creative_and_cataloging_lot_statusArr(){
        $creative_and_cataloging_lot_statusArr = ['Inverd', 'WRC Generated', 'Task Assigned', 'Editing & QC Done', 'Submission Done'];
        return $creative_and_cataloging_lot_statusArr;        
    }
}

if(!function_exists('shoot_lot_statusArr')){
    function shoot_lot_statusArr(){
        $shoot_lot_statusArr = ['Inverd', 'WRC Generated', 'Shoot started', 'Editing & QC Done', 'Submission Done'];
        return $shoot_lot_statusArr;        
    }
}

