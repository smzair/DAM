<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\lotsController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\CreativeAllocationController;
use App\Http\Controllers\Notifications;
use App\Http\Controllers\CreativeSubmissionController;
use App\Http\Controllers\CatalogAllocationController;
use App\Http\Controllers\CatalogClientARController;
use App\Http\Controllers\CatalogSubmissionController;
use App\Http\Controllers\CatalogUploadedMarketplaceCountController;
use App\Http\Controllers\CatalogWrcBatchController;
use App\Http\Controllers\CatalogWrcController;
use App\Http\Controllers\CatlaogQcController;
use App\Http\Controllers\CatalogInvoiceController;
use App\Http\Controllers\CatalogWrcMasterSheetController;
use App\Http\Controllers\clientFileManager;
use App\Http\Controllers\ClientsControllers\ClientDashboardController;
use App\Http\Controllers\ClientUserManagementController;
use App\Http\Controllers\ConsolidatedLotController;
use App\Http\Controllers\CreativeQcController;
use App\Http\Controllers\creativeWrc;
use App\Http\Controllers\EditingAllocationController;
use App\Http\Controllers\EditingClientARController;
use App\Http\Controllers\EditingSubmissionController;
use App\Http\Controllers\EditingUploadLinkController;
use App\Http\Controllers\EditingWrcController;
use App\Http\Controllers\editorLotController;
use App\Http\Controllers\EditorsCommercialController;
use App\Http\Controllers\NewCommercial;
use App\Http\Controllers\UserAssetsController;
use App\Http\Controllers\WrcInvoiceNumber;
use Illuminate\Support\Facades\Auth;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pm', 'ReportController@PublicSheet');
Route::get('/Pm-sheet', 'ReportController@PublicMSheet');
Route::get('/first-angle-downlaod/{wrc_id?}', 'guest@firstAngleDownload');
Route::get('/full-angle-downlaod/{wrc_id?}', 'guest@fullAngleDownload');
Route::get('/test', 'guest@Test');

Route::get('/Master-Sheet', 'ReportController@MasterSheet')->name('mastersheet');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('user', 'UserController');
    Route::resource('permission', 'PermissionsController');
    Route::resource('role', 'RolesController');
    Route::get('/manage', [App\Http\Controllers\UserController::class, 'manage'])->name('user.manage');
    Route::get('/ac-user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/edit-user', [App\Http\Controllers\UserController::class, 'editE']);
    Route::get('/edit-client', [App\Http\Controllers\UserController::class, 'editC']);
    Route::post('/save-user', [App\Http\Controllers\UserController::class, 'saveUser']);
    Route::post('/create', [App\Http\Controllers\UserController::class, 'create']);
    Route::get('/client-validation', [App\Http\Controllers\UserController::class, 'clientValid']);
    Route::get('/user-validation', [App\Http\Controllers\UserController::class, 'userValid']);

    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
    Route::post('/updateuserimage', [App\Http\Controllers\UserController::class, 'profileimage'])->name('updateuserimage');
    Route::post('/profile', [App\Http\Controllers\UserController::class, 'postProfile'])->name('user.postProfile');
    Route::get('/password/change', [App\Http\Controllers\UserController::class, 'getPassword'])->name('userGetpassword');
    Route::post('/password/change', [App\Http\Controllers\UserController::class, 'postPassword'])->name('userPostPassword');
});
Route::get('verify/{email}/{verifyToken}', [App\Http\Controllers\UserController::class, 'sendEmailDone'])->name('sendEmailDone');
Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/master/masterSheet-connectStudio', function (App\Services\GoogleSheet $googleSheet) {
   $googleSheet->readGoogleSheet();
   $googleSheet->saveDataToSheet();
})->name('connectStudio.masterSheet');
////////////axios request
Route::get('/commercials', [App\Http\Controllers\ComController::class, 'create'])->name('commercial.create');
Route::get('/getAllPermission', 'PermissionsController@getAllPermissions');
Route::post('/postRole', "RolesController@store");
Route::get('/getAllRoles', "RolesController@getAll");
Route::get('/getAllUsers', "UserController@getAll");
Route::get('/get-All-Am', "UserController@getAllAm");
Route::get('/getAllPermissions', "PermissionsController@getAll");
Route::get('/get-all-brands', "BrandsController@All");
Route::get('/get', "UserController@getbrands");
//////axios create user
Route::put('/account/Cupdate', 'UserController@updateClient');
Route::put('/account/update', 'UserController@update');
Route::delete('/delete/user/{id}', 'UserController@delete');
Route::get('/delete/permissions/{id}', 'PermissionsController@delete');
Route::get('/restore/{id}', 'UserController@restore')->name('user.restore');
Route::get('/search/user', 'UserController@search');
Route::get('/edit/{id}', 'PermissionsController@edit')->name('permissions.edit');
///INWARDING///////
Route::get('/createlots/{id?}', 'lotsController@createlots')->name('Lots.create');
Route::get('/edit-com/{id?}', 'ComController@editcom');
Route::get('/savebrands', 'BrandsController@create')->name('brands.add');
Route::post('/savebrands', 'BrandsController@store')->name('brands.add');
Route::get('/getAllbrands', "BrandsController@getAll")->name('brands.index');
Route::get('/userview', "lotsController@createlots");
Route::get('/brandview', "lotsController@cfindBrands");
Route::get('/delete/brand/{id}', 'BrandsController@delete');
Route::get('/create/wrc', 'wrcController@index')->name('Wrc.createwrc');
Route::get('/view-wrc', 'wrcController@View')->name('Wrc.viewwrc');
Route::get('/upload-view-sku', 'skusController@index')->name('upload.view.sku');
Route::get('/create', 'UserController@create');
Route::get('/Lotview', 'lotsController@view')->name('Lots.index');
Route::get('/Skus', 'lotsController@getskus');
Route::post('/getbrands', 'lotsController@findBrands')->name('getbrands');
Route::get('/get-user', 'lotsController@getusers')->name('get-user');
Route::get('/get-service', 'lotsController@getServices')->name('get-service');
Route::post('/save-lots', 'lotsController@store')->name('savelots');
Route::get('/getlots', 'lotsController@getlInfo')->name('getlots');
Route::get('/get-brand', 'ComController@getbrand')->name('get-brand');
Route::post('/save-com', 'ComController@saveCom')->name('savecom');
Route::get('/view-com', 'ComController@getCom')->name('viewcom');
Route::get('/get-wrc-lots', 'wrcController@getlots')->name('get-wrc-lots');
Route::get('/get-wrc-com', 'wrcController@getCom')->name('get-wrc-com');
Route::post('/save-wrc', 'wrcController@saveWrc')->name('savewrc');
Route::get('/get-wrc-details', 'wrcController@getWrcDetails')->name('get-wrc-details');
Route::get('/get-wrc-Csku', 'wrcController@getComsku');
Route::get('/getA', 'lotsController@getarray')->name('get-wrc-com');
Route::get('/upload-sku', 'skusController@upload')->name('Uploadsku.create');
Route::get('/get-company/{id}', 'skusController@getCompany')->name('get-company');
Route::get('/get-sku-lots', 'skusController@getLot')->name('get-sku-lots');
Route::get('/get-wrc', 'skusController@getwrc')->name('get-wrc');
Route::post('/upload-sku', 'skusController@uploadsku');
Route::get('/view-everything', 'adminController@index')->name('admin.index');
Route::get('/getAllskus', 'skusController@viewAllSkus')->name('getskus');
Route::get('/get-wrc-list', 'adminController@getWrc')->name('getwrclist');
Route::get('/get-sku-list', 'adminController@getSku')->name('getskulist');
Route::get('/planshoot', 'adminController@plan')->name('planshoot');
Route::get('/shoottable', 'adminController@table')->name('shoottable');
Route::get('/delete/bay/{id}', 'adminController@delete');
Route::get('/bay', 'adminController@Bay')->name('admin.bay');
Route::post('/save-day', 'adminController@savDay');
Route::get('/uplaod-raw', 'RawController@getview')->name('raw');
Route::get('/raw-Upload-view', 'RawController@rawUploadview')->name('viewraw');
Route::get('/plan-shoot-ajax', 'adminController@planShoot');
Route::post('/save-shoot-plan', 'adminController@planSave');
Route::get('/sku-list-content', 'RawController@skuListContent');
Route::get('/allocation', 'allocationController@Index')->name('allocation');
Route::get('/editors', 'editingController@Index')->name('editors');
Route::post('/raw-imgupload', 'RawController@imgUpload');
Route::get('/set-values/', 'RawController@setSkuValues');
Route::post('/update-comment1', 'RawController@rejectComment');
Route::get('/get-image-count', 'RawController@getImageCount');
Route::get('/get-plan-schl', 'RawController@getPlanSchl');
Route::get('/allocation-ajax', 'allocationController@getRequest');
Route::post('/save-allo', 'allocationController@saveAllo');
Route::get('/lotDone', 'editingController@lotDone');
Route::get('/find-wrc', 'editingController@findWrc');
Route::get('/find-com', 'editingController@findCom');
Route::get('/raw-img-download/', 'editingController@editedImgUpload');
Route::post('/edited-imgupload', 'editingController@imgUpload');
Route::get('/detail-allo', 'allocationController@Allodetails')->name("allodetail");
Route::get('/Dynamic-submission', 'SubmissionController@dynamicSub');
Route::get('/submission', 'SubmissionController@Submission')->name('submission');
Route::get('/first-angle-downlaod', 'SubmissionController@firstAngleDownload');
Route::get('/all-angle-download', 'SubmissionController@allAngleDownload');
Route::get('/logs', 'logActivity@Index')->name('Logs');
Route::get('/Qc', 'SubmissionController@Qc')->name('Qc');
Route::get('/status-qc', 'SubmissionController@statusQc');
Route::get('/plancount', 'sideBarController@planCount');
Route::get('/allocationcount', 'sideBarController@allocationCount');
Route::post('/bulk-image-uplaod', 'RawController@BulkimgUplaod');
Route::get('/daily-usage-report', 'ReportController@Report')->name('Daily-u-reports');
Route::get('/assesment', 'TestController@file');
Route::get('/get-selected-values', 'TestController@textData');
Route::post('/assesment-file', 'TestController@fileUplaod');
Route::get('/wrc-status', 'adminController@wrcStatus');
Route::get('/send-report', 'ReportController@sendReport');
Route::get('/send-wrc-report', 'ReportController@sendWrcs');
Route::get('/datefilter', 'ReportController@datefilter');
Route::get('/Lot-details', 'ReportController@Lotdetails');
Route::post('/plan-sku-sheet', 'adminController@skuPlanUplaod');
Route::get('/status-detail', 'adminController@statusInfo');
Route::post('/save-edit-com', 'ComController@dataeditCom');
Route::get('/client-AR', 'wrcController@clientAR')->name('Wrc.clientAR');
Route::get('/client-invoice', 'wrcController@invoiceNo')->name('Wrc.invoiceNo');
Route::get('/get-client-rejection', 'wrcController@getRejection');
Route::post('/update-comment', 'wrcController@Rejectcomment');
Route::post('/client-approval', 'wrcController@Clientapproval');
Route::get('/get-client-invoice', 'wrcController@Clientinvoice');
Route::post('/invoiceno-entry', 'wrcController@ClientinvoiceSave');
Route::get('/upload-imgs', 'flipkart@index')->name('flipkart.upload');
Route::get('/Downloads', 'flipkart@download')->name('flipkart.download');
Route::get('/profile-edit', 'flipkart@profile')->name('flipkart.profile');
Route::get('/track/{id?}', 'flipkart@track')->name('flipkart.track');
Route::post('/upload-Zip', 'flipkart@uploadZip');
Route::get('/get-files', 'editingController@getFiles');
Route::post('/imagecount-validation', 'editingController@imagecount');
Route::get('/imagecount', 'editingController@image');
Route::get('/wrc-file', 'editingController@getwrcFile');
Route::get('/files-download', 'editingController@DownloadFile');
Route::get('/wrc-Done', 'editingController@wrcDone');
Route::get('/wrc-flip-comment', 'flipkart@wrcComment');
Route::post('/save-wrc-flip-comment', 'flipkart@wrcsaveComment');
Route::get('/efiles-download', 'flipkart@fileEDownload');
Route::get('/editing-started', 'editingController@EditingStarted');
Route::get('/edit/{id}', 'adminController@edit');
Route::get('/flipkartUpload-editors', 'editingController@flipkartUpload')->name('flipkart.editors.upload');
Route::get('/get-Wrcs', 'editingController@getWrcs');
Route::get('/flipkartTable-editors', 'editingController@flipkartTable')->name('flipkart.editors.table');
Route::get('/wrcAllo', 'allocationController@wrcAllocation');
Route::get('/equipments-panel', 'equipmentsController@index');
Route::post('/save-equip', 'equipmentsController@save');
Route::post('/full-submitted', 'SubmissionController@fullsave');
Route::post('/first-submitted', 'SubmissionController@firstsave');
Route::get('/submitted-wrcs', 'SubmissionController@Submit')->name('submitted');
Route::get('/Dynamic-submit', 'SubmissionController@dynamicSubmit');
Route::get('/pending-counts', 'ReportController@pending');
Route::get('/tat-report', 'ReportController@tatReport');

Route::get('/ac-report', 'ReportController@accountDetials');
Route::get('/repLot/{date}', 'ReportController@repLot');
Route::get('/repWrc/{date}', 'ReportController@repWrc');
Route::get('/plannedSku/{date}', 'ReportController@plannedSku');
Route::get('/planpendingSku/{date}', 'ReportController@PlanpendingSku');
Route::get('/uploadrawpending/{date}', 'ReportController@uploadraw');
Route::get('/shootdone/{date}', 'ReportController@shoot');
Route::get('/pendingallo/{date}', 'ReportController@pendingAllo');
Route::get('/editingcomplete/{date}', 'ReportController@editingComplete');
Route::get('/compareqcpending/{date}', 'ReportController@compareQc');
Route::get('/comparesubmission/{date}', 'ReportController@CompareSub');

Route::get('/data-dash','StatusController@Report');
Route::get('/reload-data','StatusController@RealtimeData');
Route::post('/raw-img-bulkupload','RawController@bulkImage');
Route::get('/Qc-done', 'SubmissionController@qcDone')->name('qcDone');
Route::post('/save-edit-com', 'ComController@dataeditCom');
Route::post('/sheet', 'wrcController@uSku');
Route::get('/reject-editor', 'editingController@wrcReject');
Route::get('/notify-uploads','Notifications@realTime');
Route::get('/notify-qcuploads','Notifications@realTimeqc');

Route::get('/raise-Feed','feedbackController@indexShoot')->name('feedBack');
Route::get('/brand-data','feedbackController@getfeedbrand');
Route::get('/form/{id}','feedbackController@feedForm');
Route::get('/feedback-start/{id}','feedbackController@feedStart');
Route::post('/save-feed','feedbackController@savefeed');
Route::post('/save-c-feed','feedbackController@saveCfeed');
Route::get('/thankyou','feedbackController@thankYou')->name('thankYou');
Route::get('/feedbackSheet','feedbackController@feedbackView');
Route::get('/form-reject/{id}','feedbackController@feedbackReject');
Route::get('/notify-tatReport','ReportController@tatReport');
/////////Csvdummuyfilesdownload//////////////
Route::get('/download', function () {
    $file = "dist/files/Sample_sheet.xlsx";
    $headers = array(
        'Content-Type:application/xlsx',
    );

    return Response::download($file, "Sample_sheet.xlsx", $headers);
})->name('downloadfile');

Route::get('/download-plan', function () {
    $file ="dist/files/sku-template-for-planning.csv";
    $headers = array(
        'Content-Type:application/csv',
    );

    return Response::download($file, "sku-template-for-planning.csv", $headers);
})->name('downloadfileplan');
////////////////////////////////////////////////////////////////////////////////


Route::get('/Creative-createComs', 'creativeCommercials@index')->name('CREATECOM');
Route::post('/Creative-createComs', 'creativeCommercials@create')->name('SAVECOMS'); // for save Commercial
Route::get('/Creative_commercialView', 'creativeCommercials@view')->name('viewCOM'); // for view Commercial
Route::get('/Creative-createComs/{id}', 'creativeCommercials@edit')->name('EDITCOMS'); // for save Commercial
Route::post('/Creative-updateComs', 'creativeCommercials@update')->name('UPDATECOMS'); // for save Commercial


Route::get('/Creative-createCatalog', 'catalogCommercials@index')->name('CREATECATALOG'); // for Commercials Create Catalog  Form
Route::post('/Creative-createCatalog', 'catalogCommercials@create')->name('SAVECATALOG'); // For save Commercials Catalog  Log
Route::get('/Creative-CatalogView', 'catalogCommercials@view')->name('viewCommercial'); // for Commercials Create Catalog  Form
Route::get('/Creative-createCatalog/{id}', 'catalogCommercials@edit')->name('EDITCATALOG'); // for Commercials Create Catalog  Form
Route::post('/Creative-updateCatalog', 'catalogCommercials@update')->name('UPDATECATALOG'); // For Update Commercials Catalog  Log



/****************  Creative-createLots  **************/
Route::get('/Creative-createLots','creativeLot@index')->name('CREATELOT');
Route::post('/Creative-createLots', 'creativeLot@store')->name('STORELOTS');
Route::get('/Creative-viewLots','creativeLot@view')->name('viewLOT');
Route::get('/Creative-editLots/{id}','creativeLot@edit');
Route::post('/Creative-updateLots','creativeLot@update')->name('UPDATELOT');

/****************  Catalog- create Lots  **************/

Route::get('/Creative-createLotCatalog', 'CatalogLotsController@index')->name('CREATELOTCATALOG');
Route::post('/Creative-createLotCatalog', 'CatalogLotsController@create')->name('SAVELOTSCATALOG'); // For save Lots Catalog  Log
Route::get('/Creative-lotsCatalogView', 'CatalogLotsController@view')->name('VIEWLOTCATALOG'); // for Listing Lots Catalog
Route::get('/Creative-createLotCatalog/{id}', 'CatalogLotsController@edit')->name('EDITLOTCATALOG'); // for Lots Catalog edit Form
Route::post('/Creative-UpdateLotCatalog', 'CatalogLotsController@update')->name('UPDATELOTSCATALOG'); // For save Lots Catalog  Log

// --rajesh routing creative and editing panel---start
/****************  Creative-createWrc  **************/
Route::get('/Creative-createWrcs','creativeWrc@index')->name('CREATEWRC');
Route::post('/Creative-createWrcs', 'creativeWrc@store')->name('STOREWRC');
Route::get('/Creative-createWrcs/{id}','creativeWrc@edit');
Route::post('/Creative-viewWrcs','creativeWrc@update')->name('UPDATEWRC');
Route::get('/Creative-viewWrcs','creativeWrc@view')->name('viewWRC');

/****************  Creative-createWrc-Batch-Panel  **************/
Route::get('/Creative-viewWrcsBatchPanel','creativeWrc@viewBatchPanel')->name('viewWRCBatchPanel');
Route::post('/Creative-viewWrcsBatchPanel','creativeWrc@storeNewBatch')->name('INVERD_NEW_BATCH');

/****************  Creative-Allocation  **************/
Route::get('/Creative-allocation-create' , [CreativeAllocationController::class , 'index'])->name('CREATIVE_ALLOCATION_CREATE');//creative allocation create
Route::get('/Creative-Reallocation-create' , [CreativeAllocationController::class , 'indexForReAllocation'])->name('CREATIVE_REALLOCATION_CREATE');//creative reallocation create
Route::get('/Creative-allocation-get' , [CreativeAllocationController::class , 'CreativeAllocationGet'])->name('CREATIVE_ALLOCATION_GET');//creative allocation get
Route::get('/Creative-allocation-get' , [CreativeAllocationController::class , 'CreativeAllocationGet'])->name('CREATIVE_ALLOCATION_GET');
Route::post('/Creative-allocation-create', 'CreativeAllocationController@store')->name('CREATIVE_ALLOCATION_STORE');// store creative allocation

/****************  Creative-Uploading (Tasking)  **************/
Route::get('/Upload-Creative' , [CreativeAllocationController::class , 'uploadCreative'])->name('UPLOAD_CREATIVE_PANEL');//creative allocation get
Route::post('/set-creative-allocation-start' , [CreativeAllocationController::class , 'setCreativeAllocationStart']);//update start time
Route::post('/Upload-Creative', 'CreativeAllocationController@storeUploaddata')->name('CREATIVE_ALLOCATION_UPLOAD_STORE');// store creative allocation upload data

/****************  Creative-Qc Panel  **************/
Route::get('/Creative-Qc', [CreativeQcController::class , 'getDataForQcList'])->name('CREATIVE_QC_GET');// creative qc get
Route::post('/get-user-for-rework','CreativeQcController@getUserListForRework');// get user list for rework in qc approval create// ajax api
Route::post('/Creative-Qc','CreativeQcController@storeUserDataForRework')->name('CREATIVE_REWORK_STORE');//creative rework store
Route::post('/check_completed_wrc','CreativeQcController@checkCompletedWrc');//check_completed_wrc
Route::post('/cw_check_completed_wrc','CreativeQcController@cwCheckCompletedWrc');//cw_check_completed_wrc
Route::post('/get-sku-list' , [CreativeAllocationController::class , 'getSkuList']);//get sku based on wrc id and batch no

/****************creative Submission **************/
Route::get('/Creative-Submission' , [CreativeSubmissionController::class , 'getCreativeSubmission'])->name('CREATIVE_SUBMISSION_GET');//get sku based on wrc id and batch no
Route::post('/Creative-Submission' , [CreativeSubmissionController::class , 'addCreativeSubmission'])->name('add_ready_for_submission');//Add Ready For Submission

/****************creative Submission done**************/
Route::get('/Creative-Submission-Done' , [CreativeSubmissionController::class , 'getDataForCreativeSubmissionDone'])->name('CREATIVE_SUBMISSION_DONE');// get wrc list for submission done
Route::post('/Creative-Submission-Done' , [CreativeSubmissionController::class , 'addCreativeSubmissionDone'])->name('add_submission_done');//Add  Submission Done


/****************creative Client-Approval-Rejection**************/
Route::get('/Creative-WRC-Client-Approval-Rejection' , [CreativeSubmissionController::class , 'creativeWrcClientApprovalRejection'])->name('CREATIVE_WRC_CLIENT_APPROVAL_REJECTION');//CREATIVE_WRC_CLIENT_APPROVAL_REJECTION
Route::post('/Creative-WRC-Client-Approval-Rejection' , [CreativeSubmissionController::class , 'creativeWrcApprove'])->name('creative_wrc_approve');// approve action for wrc
Route::post('/Creative-WRC-Client-Rejection' , [CreativeSubmissionController::class , 'creativeWrcReject'])->name('creative_wrc_reject');// reject action for wrc
Route::get('/set-creative-allocation-pause' , [CreativeAllocationController::class , 'setCreativeAllocationPause']);//cron api for update pause time when task is start
Route::get('/Creative-Wrc-Detail-Master-Sheet' , [CreativeSubmissionController::class , 'getCreativeWrcDetail'])->name('get_creative_wrc_detail');//get creative wrc detail ( master sheet)
Route::get('/Creative-wrcs-status-view' , [creativeWrc::class , 'wrcStatusView'])->name('creative_wrc_status_view');//creative wrc status view listing


/****************consolidated lot panel**************/
Route::get('/Consolidated-Lot' , [ConsolidatedLotController::class , 'view'])->name('consolidated_lot_panel');//consolidated lot panel
Route::post('/Consolidated-Lot' , [ConsolidatedLotController::class , 'create'])->name('create_consolidated_lot');//create consolidated lot
Route::get('/Consolidated-Lot/{id}' , [ConsolidatedLotController::class , 'continueTask']);//continue task on  consolidated lot
Route::get('/Consolidated-Lot-List' , [ConsolidatedLotController::class , 'list'])->name('consolidated_lot_view');//view consolidated lot
Route::post('/Consolidated-Lot-Shoot' , [ConsolidatedLotController::class , 'createConsolidatedShoot'])->name('create_consolidated_shoot');//create  consolidated shoot
Route::post('/Consolidated-Lot-Creative-Graphics' , [ConsolidatedLotController::class , 'createConsolidatedCreativeGraphics'])->name('create_consolidated_creative_graphics');// create consolidated Creative
Route::post('/Consolidated-Lot-Catlog' , [ConsolidatedLotController::class , 'createConsolidatedCatlog'])->name('create_consolidated_catlog');// create consolidated catlog
Route::post('/Consolidated-Lot-Editor' , [ConsolidatedLotController::class , 'createConsolidatedEditorLot'])->name('create_consolidated_editor_lot');// create create_consolidated_editor_lot



Route::get('/Creative-Update-Invoice-Number' , [WrcInvoiceNumber::class , 'index'])->name('update_invoice_number_panel');// Update Invoice Number Panel
Route::post('/Creative-Update-Invoice-Number' , [WrcInvoiceNumber::class , 'updateWrcInvoice'])->name('update_wrc_invoice_no');// update Wrc Invoice No

/****************Editor Panel**************/

Route::get('/Editor-Create-Lot' , [editorLotController::class , 'index'])->name('editor_create_lot');// Editor Create Lot
Route::post('/Editor-Create-Lot', [editorLotController::class , 'store'])->name('store_editor_lot');
Route::get('/Editor-Lot-View', [editorLotController::class , 'getEditorLotData'])->name('get_editor_lot_data');// editor lot listing
Route::get('/Editor-editLots/{id}',[editorLotController::class, 'edit']);// editor lot edit
Route::post('/Editor-Lot-View',[editorLotController::class, 'update'])->name('editor_update_lot');// editor lot update
// --rajesh routing creative and editing panel---end

// rajesh wrc route start

/****************catalog-wrc-create **************/
Route::get('/Catalog-Wrc-Create', [CatalogWrcController::class, 'index'])->name('CREATECATLOGWRC');
Route::post('/Catalog-Wrc-marketplace-Credentials-list', [CatalogWrcController::class, 'marketplace_Credentials_List'])->name('M-P-C-List');
Route::post('/save-wrc-Credentials', [CatalogWrcController::class, 'save_wrc_Credentials'])->name('S-W-Credentials');

// Route::get( '/Catalog-marketplace-list', [CatalogWrcController::class, 'catalog_marketplace_Credentials_List'])->name('MarketPlace');
Route::get('/Catalog-marketplace-list', [CatalogWrcController::class, 'MarketPlace'])->name('MarketPlace');
Route::post('/get-marketplace_c_list', [CatalogWrcController::class, 'marketplace_Credentials_details']); // marketplace_Credentials_details list based on company and brand

Route::get('/Catalog-viewWrcs', [CatalogWrcController::class, 'view'])->name('viewCatalogWRC');
Route::post('/Catalog-Wrc-Create', [CatalogWrcController::class, 'store'])->name('STORECATLOGWRC');
Route::get('/Catalog-Wrc-Create/{id}', [CatalogWrcController::class, 'edit'])->name('EDITCATLOGWRC');
Route::post('/Catlog-updateWrc', [CatalogWrcController::class, 'update'])->name('UPDATECATLOGWRC');

Route::get('/Catalog-wrc-batch', [CatalogWrcBatchController::class, 'index'])->name('CatalogWrcBatch'); // Catalog Wrc's Batch Panel 
Route::post('/Catlog-wrc-inverd-new-batch', [CatalogWrcBatchController::class, 'storeNewBatch'])->name('WRC_INVERD_NEW_BATCH');

#ajax
Route::post('/get-catlog-brand', [CatalogWrcController::class, 'getBrand']);
Route::post('/get-catlog-lot-number', [CatalogWrcController::class, 'getLotNumber']);

/********** Ajax calling /{id} ********/
Route::post('/get-brand', 'AjaxController@getBrand');
Route::post('/get-lot-number', 'creativeWrc@getLotNumber');


/****** Allocation Route  set-catalog-allocation  set-catalog-allocation-start *********/
Route::get('catalog-allocation', [CatalogAllocationController::class, 'index'])->name('CATALOG_ALLOCT'); // 
Route::get('catalog-re-allocation', [CatalogAllocationController::class, 'catalog_re_allocation'])->name('CATALOG_RE_ALLOCT'); // 
Route::get('catalog-allocated-details', [CatalogAllocationController::class, 'details'])->name('CATALOG_ALLOCTED_DETAILS'); // 
Route::get('catalog-upload', [CatalogAllocationController::class, 'upload'])->name('CATALOG_UPLOAD'); //

Route::post('set-catalog-allocation', [CatalogAllocationController::class, 'save']); // for save catalog allocation
Route::post('catalog-allocated-sku-count', [CatalogAllocationController::class, 'alocated_sku_count']); // for list of allocated catalog WRC sku count ajax
Route::post('set-catalog-allocation-start', [CatalogAllocationController::class, 'set_task_start']); // for start catalog allocation Wrc
Route::post('set-catalog-allocation-pause', [CatalogAllocationController::class, 'set_task_pause']); // for Pause catalog allocation Wrc

Route::post('catalog-upload-link', [CatalogAllocationController::class, 'upload_catalog_link']); // for upload catalog WRC link 
Route::post('get-catalog_upload_links', [CatalogAllocationController::class, 'get_catalog_link']); // for get-catalog_upload_links 

Route::post('get-uploaded_Marketplace_count', [CatalogUploadedMarketplaceCountController::class, 'get_uploaded_Marketplace_count']); // for get-uploaded_Marketplace_count   
Route::post('save-Marketplace-approved-Count', [CatalogUploadedMarketplaceCountController::class, 'save_Marketplace_approved_Count']); // for get-uploaded_Marketplace_count   

Route::POST('get-Sub-Marketplace-count', [CatalogUploadedMarketplaceCountController::class, 'get_sub_Marketplace_count']); // for get-uploaded_Marketplace_count   
// QC route  get-catalog-users_list qc-rework completed-qc-wrc  

Route::get('catalog-qc', [CatlaogQcController::class, 'index'])->name('QcList'); // Qc List 
Route::post('get-catalog-users_list', [CatlaogQcController::class, 'userlist'])->name('userlist'); // Qc List 
Route::post('qc-rework', [CatlaogQcController::class, 'set_qc_rework'])->name('QCREWORK'); // Qc List 
Route::post('set-wrc-qc-completed', [CatlaogQcController::class, 'completed_qc_wrc'])->name('QCCOMPWRC'); // completed-qc-wrc
Route::post('set-wrc-qc-pending', [CatlaogQcController::class, 'set_wrc_qc_pending'])->name('QCWRCPending'); // completed-qc-wrc

// Submission Route comp-submission catalog-submission-details CATA_CLIENT_AR
Route::get('catalog-ready-for-submission', [CatalogSubmissionController::class, 'index'])->name('C_READYFORSUB'); // Qc List 
Route::post('comp-submission', [CatalogSubmissionController::class, 'comp_submission'])->name('Comp-submission'); // completed-qc-wrc
Route::get('catalog-submission-done', [CatalogSubmissionController::class, 'catalog_submission_done'])->name('C_SUB_DONE'); // Qc List 
Route::post('catalog-submission-details', [CatalogSubmissionController::class, 'comp_submission_details'])->name('Submission-details'); // completed-qc-wrc

// client approval rejection Route 
Route::get('catalog-client-ar', [CatalogClientARController::class, 'index'])->name('CATA_CLIENT_AR'); // Qc List 
Route::post('client-catalog-wrc-reject', [CatalogClientARController::class, 'wrc_reject_approve_wrc'])->name('wrc_reject_approve_wrc'); // reject-wrc

// catalog - wrc - master - sheet . blade
Route::get('catalog-wrc-master-sheet', [CatalogWrcMasterSheetController::class, 'index'])->name('CatalogWrcMasterSheet');

// New Panel for WRCs Status
Route::get('catalog-wrc-status', [CatalogWrcController::class, 'CatalogWrcStatus'])->name('CatalogWrcStatus');

// NewCommercial Routing 
Route::get('/newCommercial', [NewCommercial::class, 'index'])->name('NewCommercial'); // NewCommercial Form 
Route::POST('/newCommercial', [NewCommercial::class, 'create'])->name('SaveNewCommercial'); // Save NewCommercial And genrating data
Route::get('/newCommercialList', [NewCommercial::class, 'view'])->name('ViewNewCommercial'); // Listing For NewCommercial
Route::get('/newCommercial/{id}', [NewCommercial::class, 'Edit'])->name('EditNewCommercial'); // Edit   

Route::POST('/UpdateNewCommercial', [NewCommercial::class, 'update'])->name('UpdateNewCommercial'); // Save NewCommercial And genrating data
Route::POST('/saveShootCommercial', [NewCommercial::class, 'saveShootCommercial'])->name('saveShootCommercial'); // Save SaveShootCommercial And genrating data
Route::POST('/saveCreativeCommercial', [NewCommercial::class, 'SaveCreativeCommercial'])->name('SaveCreativeCommercial'); // Save SaveCreativeCommercial And genrating data
Route::POST('/saveCatalogingCommercial', [NewCommercial::class, 'SaveCatalogingCommercial'])->name('SaveCatalogingCommercial'); // Save SaveCatalogingCommercial And genrating data
Route::POST('/saveEditorCommercial', [NewCommercial::class, 'SaveEditorCommercial'])->name('SaveEditorCommercial'); // Save SaveCatalogingCommercial And genrating data

Route::get('/catalog-Invoice', [CatalogInvoiceController::class, 'index'])->name('CatalogInvoice'); // Listing For NewCommercial
Route::POST('/save-Catalog-invoice-number', [CatalogInvoiceController::class, 'SaveCatalogInvoiceNumber'])->name('SaveCatalogInvoiceNumber'); // Save SaveCatalogingCommercial And genrating data
Route::POST('/catalog-Invoice', [CatalogInvoiceController::class, 'SaveCataLogBulkInvoice'])->name('SaveCataLogBulkInvoice'); // Save SaveCatalogingCommercial And genrating data
// SaveCataLogInvoice

// 
Route::get('/Commercial-Editor', [EditorsCommercialController::class, 'create'])->name('CommercialEditor'); // Create Commercial-Editor
Route::POST('/Commercial-Editor', [EditorsCommercialController::class, 'store'])->name('SaveCommercialEditor'); // Save Commercial-Editor
Route::get('/Commercial-Editor-List', [EditorsCommercialController::class, 'index'])->name('ViewCommercialEditor'); // View Commercial-Editor
Route::get('/Commercial-Editor/{id}', [EditorsCommercialController::class, 'edit'])->name('EditCommercialEditor'); // Create Commercial-Editor
Route::POST('/Update-Commercial-Editor', [EditorsCommercialController::class, 'update'])->name('UpdateCommercialEditor'); // Save Commercial-Editor

// Editing WRC Routeing SRS
Route::get('/Editing-Wrc-Create', [EditingWrcController::class, 'create'])->name('EditingWrcCreate'); // For create New Wrc for Editing
Route::post('/get-Editing-lot-number', [EditingWrcController::class, 'getLotNumber']);
Route::POST('/Editing-Wrc-Create', [EditingWrcController::class, 'store'])->name('SaveEditingWrcCreate'); // Save Wrc for Editing
Route::get('/Editing-Wrc-List', [EditingWrcController::class, 'index'])->name('EditingWrcView'); 
Route::get('/Editing-Wrc-Create/{id}', [EditingWrcController::class, 'edit'])->name('EditingWrcEdit'); 
Route::POST('/Update-Editing-Wrc-Create', [EditingWrcController::class, 'update'])->name('UpdateEditingWrcCreate'); // Update Wrc for Editing
// Route::post('/Catalog-Wrc-marketplace-Credentials-list', [CatalogWrcController::class, 'marketplace_Credentials_List'])->name('M-P-C-List');
// Route::post('/save-wrc-Credentials', [CatalogWrcController::class, 'save_wrc_Credentials'])->name('S-W-Credentials');

/* ---------- Editing Panel Allocation -------------*/
Route::get('Editing-allocation', [EditingAllocationController::class, 'index'])->name( 'Editing_Allocation'); // 
Route::get('Editing-Re-Allocation', [EditingAllocationController::class, 'Editing_Re_Allocation'])->name('Editing_Re_Allocation'); // 

Route::post('set-Editing-allocation', [EditingAllocationController::class, 'save']); // for save Editing allocation
Route::get('Editing-Allocation-details', [EditingAllocationController::class, 'Editing_Allocation_Details'])->name('Editing_Allocation_Details'); // 

// Editing Panel Upload/Tasking
Route::get('editing-upload', [EditingUploadLinkController::class, 'upload'])->name('Editing_Upload'); //
Route::post('Editing-upload-link', [EditingUploadLinkController::class, 'Editing_upload_link']); // for upload Editing WRC link 
Route::post('get-editing_upload_links', [EditingUploadLinkController::class, 'get_Editing_Uploaded_link']); // for get Editing uploaded link 

// Editing Submission And Client Approval Routing
Route::get('Editing-ready-for-submission', [EditingSubmissionController::class, 'index'])->name('Editing_Submission'); //Editing WRC list Which Is ready for Submmition
Route::post('Editing-comp-submission', [EditingSubmissionController::class, 'comp_Editing_Submission'])->name('comp_Editing_Submission'); // completed-qc-wrc
Route::get('Editing-submission-done', [EditingSubmissionController::class, 'Editing_Submission_Done'])->name('Editing_Submission_Done'); //Editing WRC Submmition Done List
Route::get('Editing-Wrc-client-ar', [EditingClientARController::class, 'index'])->name('EditingClientARList'); // Editing Wrc List for client Approval & Rejection
Route::post('Editing-client-wrc-AR', [EditingClientARController::class, 'Editing_reject_approve_wrc'])->name('Editing_reject_approve_wrc'); // Editing Wrc client Approval or Rejection

Route::group(['middleware' => ['auth']], function () {
    // *** New routes  *** //
    Route::post('manage-client-dam', [UserController::class, 'manage_client_dam'])->name('manage_client_dam'); // manage client dam

    // dam (Digital Asset Management) Routing
    Route::get('/client-user', [UserController::class, 'clientIndex'])->name('clientuser.index');

    // client User Your assets Routes
    Route::get('/client-user-shoot-lots', [UserAssetsController::class, 'clientUserShootLots'])->name('clientUserShootLots');
    Route::get('/client-user-Creative-lots', [UserAssetsController::class, 'clientUserCreativeLots'])->name('clientUserCreativeLots');
    Route::get('/client-user-Cataloging-lots', [UserAssetsController::class, 'clientUserCatalogingLots'])->name('clientUserCatalogingLots');
    Route::get('/client-user-Editing-lots', [UserAssetsController::class, 'clientUserEditingLots'])->name('clientUserEditingLots');

    /******File Manager routing*******/
    Route::get('/client-raw-images-mgmt', [clientFileManager::class, 'clientRawImagesYear'])->name('clientRawImagesMgmt');// client raw images mgmt ( images)
    Route::get('/months/lots/{id}', [clientFileManager::class, 'clientRawImages'])->name('clientRawImages');// client raw images lots ( images)
    // get wrc based on lot
    Route::get('/months/lots/wrc/{id}', [clientFileManager::class, 'getWrcForClientRawImages'])->name('client-raw-images-mgmt');
    // get skus based on wrc id
    Route::get('/months/lots/wrc/skus/{id}', [clientFileManager::class, 'getSkusForClientRawImages'])->name('client-raw-images-skus');
    // get all images based on sku id
    Route::get('/months/lots/wrc/skus/skusimages/{id}', [clientFileManager::class, 'getClientUploadRawImages'])->name('client-all-images');
    // get client raw images months based on year
    Route::get('/months/{id}', [clientFileManager::class, 'getAllMonthsForClientRawImages'])->name('months');
    

    // Client User Management Routing
    Route::get('/client-user-management', [ClientUserManagementController::class, 'Index'])->name('ClientUserManagement');
    Route::get('/user-management', [ClientUserManagementController::class, 'create'])->name('addClientUser');
    Route::get('/client-user-validation', [ClientUserManagementController::class, 'clientUserValid']);
    Route::post('/save-client-users', [ClientUserManagementController::class, 'saveUserClient']);
    Route::get('/user-management/{id}', [ClientUserManagementController::class, 'edit'])->name('editClientUser');
});
// route for global search in file manager system
Route::post('/commonsearch', [clientFileManager::class, 'commonSearch']);
Route::get('/commonsearch', [clientFileManager::class, 'clientRawImagesYear']);// client raw images mgmt when hit common search
Route::get('/downloadlot/{id}', [clientFileManager::class, 'downloadLotData'])->name('downloadLotData');//download lot
Route::get('/downloadyeardata/{id}', [clientFileManager::class, 'downloadYearData'])->name('downloadDataBasedOnYear');//download year data based 
Route::get('/downloaddatabasedonmonth/{id}', [clientFileManager::class, 'downloadDataBasedOnMonth'])->name('downloadDataBasedOnMonth');//download month data based 
Route::get('/downloaddatabasedonwrc/{id}', [clientFileManager::class, 'downloadDataBasedOnWrc'])->name('downloadDataBasedOnWrc');//download wrc data based 
Route::get('/downloaddatabasedonsku/{id}', [clientFileManager::class, 'downloadDataBasedOnSku'])->name('downloadDataBasedOnSku');//download sku data based 

/******File Manager routing for editing images*******/
Route::post('/editorcommonsearch', [EditingClientFileManagerController::class, 'editorCommonSearch']);
Route::get('/editorcommonsearch', [EditingClientFileManagerController::class, 'clientEditorImagesYear']);// client editor images mgmt when hit common search
Route::get('/client-editor-images-years', [EditingClientFileManagerController::class, 'clientEditorImagesYear'])->name('clientEditorImagesYear'); // get editor images years
Route::get('/editormonths/{id}', [EditingClientFileManagerController::class, 'getAllMonthsForClientEditorImages'])->name('editormonths');// get client editor images months based on year
Route::get('/editormonths/lots/{id}', [EditingClientFileManagerController::class, 'clientEditorImagesLots'])->name('clientEditorImagesLots');// client editor images lots 
Route::get('/editormonths/lots/wrc/{id}', [EditingClientFileManagerController::class, 'getWrcForClientEditorImages'])->name('clientEditorImagesWrcs');// get wrc based on lot


// get adaption based on wrc id
Route::get('/editormonths/lots/wrc/skus/{id}', [EditingClientFileManagerController::class, 'getSkusAdaptionForClientEditorImages'])->name('client-editor-images-skus');

// get skus based on adaption
Route::get('/editormonths/lots/wrc/skus/adaptation/{id}', [EditingClientFileManagerController::class, 'getSkusForClientEditorImages'])->name('getSkusForClientEditorImages');

// get all images based on sku id
Route::get('/editormonths/lots/wrc/skus/adaptation/skusimages/{id}', [EditingClientFileManagerController::class, 'getClientUploadEditorImages'])->name('client-all-images');

/******File Manager routing for editing images zip download*******/
Route::get('/editordownloadyeardata/{id}', [EditingClientFileManagerController::class, 'editorDownloadYearData'])->name('editorDownloadYearData');//download year data based on year
Route::get('/editordownloaddatabasedonmonth/{id}', [EditingClientFileManagerController::class, 'editorDownloadDataBasedOnMonth'])->name('editorDownloadDataBasedOnMonth');//download year data based on month
Route::get('/editordownloadlot/{id}', [EditingClientFileManagerController::class, 'editorDownloadLotData'])->name('editorDownloadLotData');//download lot
Route::get('/editordownloaddatabasedonwrc/{id}', [EditingClientFileManagerController::class, 'editorDownloadDataBasedOnWrc'])->name('editorDownloadDataBasedOnWrc');//download wrc data based on year
Route::get('/downloadadaptationdata/{id}', [EditingClientFileManagerController::class, 'downloadAdaptationdata'])->name('downloadAdaptationData');//download adaption data based 
Route::get('/editordownloaddatabasedonsku/{id}', [EditingClientFileManagerController::class, 'editorDownloadDataBasedOnSku'])->name('editorDownloadDataBasedOnSku');//download sku data based 