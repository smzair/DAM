<?php

namespace App\Http\Controllers;

use App\Models\CatalogMarketplaceCredentials;
use App\Models\CatalogWrcMasterSheet;
use Illuminate\Http\Request;

class CatalogWrcMasterSheetController extends Controller
{
    //
    public function index(){

        $CatalogWrcMasterList = CatalogWrcMasterSheet::CatalogWrcMasterList();
        $wrc_skus_CountList = CatalogWrcMasterSheet::wrc_skus_CountList();
        $commercial_wise_MarketplaceCredentials_list = CatalogMarketplaceCredentials::commercial_wise_MarketplaceCredentials_list();
        return view('CatalogWrcMaster.catalog-wrc-master-sheet')->with('CatalogWrcMasterList', $CatalogWrcMasterList)->with('wrc_skus_CountList', $wrc_skus_CountList)->with('commercial_wise_MarketplaceCredentials_list', $commercial_wise_MarketplaceCredentials_list);
    }
}
