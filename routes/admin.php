<?php
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\assignmentController;
use App\Http\Controllers\boundary_validationController;
use App\Http\Controllers\consultantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\divisionController;
use App\Http\Controllers\escalation_frequencyController;
use App\Http\Controllers\faqController;
use App\Http\Controllers\flag_colorController;
use App\Http\Controllers\industryController;
use App\Http\Controllers\invoiceController;
use App\Http\Controllers\leaving_detailController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\menuController;
use App\Http\Controllers\online_messageController;
use App\Http\Controllers\segment_combination_setupController;
use App\Http\Controllers\segment_head_detailsController;
use App\Http\Controllers\segment_headController;
use App\Http\Controllers\segment_structure_infoController;
use App\Http\Controllers\supplierController;
use App\Http\Controllers\terms_conditionController;
use App\Http\Controllers\timesheet_statusController;
use App\Http\Controllers\timesheetController;
use App\Http\Controllers\user_manualController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\WebmasterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\workerController;
use App\Http\Controllers\workflowController;
use Illuminate\Support\Facades\Route;

 Route::prefix(config('config.backend_path'))->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('admin');


     Route::resource('menu', menuController::class)->names([
         'index' => 'menu.index',
         'create' => 'menu.create',
         'store' => 'menu.store',
         'show' => 'menu.show',
         'edit' => 'menu.edit',
         'update' => 'menu.update',
         'destroy' => 'menu.destroy',
     ]);



     Route::resource('permission', PermissionController::class)->names([
         'index' => 'permission.index',
         'create' => 'permission.create',
         'store' => 'permission.store',
         'show' => 'permission.show',
         'edit' => 'permission.edit',
         'update' => 'permission.update',
         'destroy' => 'permission.destroy'
     ]);

     Route::resource('role', RoleController::class)->names([
         'index' => 'role.index',
         'create' => 'role.create',
         'store' => 'role.store',
         'show' => 'role.show',
         'edit' => 'role.edit',
         'update' => 'role.update',
         'destroy' => 'role.destroy'
     ]);


     Route::post('update-sortaccess', [RoleController::class, 'index'])->name('update-sortaccess');


     Route::resource('user_manual', user_manualController::class)->names([
         'index' => 'user_manual.index',
         'create' => 'user_manual.create',
         'store' => 'user_manual.store',
         'show' => 'user_manual.show',
         'edit' => 'user_manual.edit',
         'update' => 'user_manual.update',
         'destroy' => 'user_manual.destroy'
     ]);
     Route::post('update-user-manual',  [user_manualController::class,'update_user_manual'])->name('update-user-manual');


     Route::resource('user', UserController::class)->names([
         'index' => 'user.index',
         'create' => 'user.create',
         'store' => 'user.store',
         'show' => 'user.show',
         'edit' => 'user.edit',
         'update' => 'user.update',
         'destroy' => 'user.destroy'
     ]);
     Route::get('file-manager', [FileManagerController::class, 'index'])->name('FileManager');
     Route::get('files-manager', [FileManagerController::class, 'manager'])->name('FilesManager');

     Route::get('webmaster', [WebmasterController::class, 'index'])->name('webmaster');

     Route::get('profile', [UserController::class,'profile'])->name('profile');

     Route::get('getUserList', [UserController::class,'getUserList'])->name('getUserList');

     Route::post('save_setting', [WebmasterController::class, 'saveData'])->name('save_setting');
     Route::post('test-mail', [WebmasterController::class, 'testMail'])->name('test-mail');

     Route::post('/upload-logo', [WebmasterController::class, 'uploadLogo']);
     Route::post('/upload-favicon', [WebmasterController::class, 'uploadFavicon']);
     Route::delete('/revert-logo', [WebmasterController::class, 'revertLogo']);
     Route::delete('/revert-favicon', [WebmasterController::class, 'revertFavicon']);

     Route::post('/upload-usermanual', [user_manualController::class, 'uploadUsermanual']);
     Route::delete('/revert-usermanual', [user_manualController::class, 'revertUsermanual']);

    // Route::post('/webmaster/mail/smtp', [WebmasterController::class, 'mail_smtp_check'])->name('mailSMTPCheck');
     //Route::post('/webmaster/mail/test', [WebmasterController::class, 'mail_test'])->name('mailTest');


     Route::get('cv_mail_inbox', 'mailController@cv_mail_inbox');
     Route::post('view-mailbox', 'mailController@view_mailbox');
     Route::get('mail/Inbox', 'mailController@readmail');


     Route::post('mail/testConnection',  [WebmasterController::class,'check_connection'])->name('mailSMTPCheck');


     Route::get('test-imap', [WebmasterController::class,'test_imap'])->name('test-imap');


     Route::resource('division',  divisionController::class)->names([
         'index' => 'division.index',
         'create' => 'division.create',
         'store' => 'division.store',
         'show' => 'division.show',
         'edit' => 'division.edit',
         'update' => 'division.update',
         'destroy' => 'division.destroy'
     ]);

     Route::resource('escalation_frequency',  escalation_frequencyController::class)->names([
         'index' => 'escalation_frequency.index',
         'create' => 'escalation_frequency.create',
         'store' => 'escalation_frequency.store',
         'show' => 'escalation_frequency.show',
         'edit' => 'escalation_frequency.edit',
         'update' => 'escalation_frequency.update',
         'destroy' => 'escalation_frequency.destroy'
     ]);
     Route::post('update-escalation-frequency',  [escalation_frequencyController::class,'update_escalation_frequency'])->name('update-escalation-frequency');

     Route::resource('boundary_validation',  boundary_validationController::class)->names([
         'index' => 'boundary_validation.index',
         'create' => 'boundary_validation.create',
         'store' => 'boundary_validation.store',
         'show' => 'boundary_validation.show',
         'edit' => 'boundary_validation.edit',
         'update' => 'boundary_validation.update',
         'destroy' => 'boundary_validation.destroy'
     ]);

     Route::resource('terms_condition',  terms_conditionController::class)->names([
         'index' => 'terms_condition.index',
         'create' => 'terms_condition.create',
         'store' => 'terms_condition.store',
         'show' => 'terms_condition.show',
         'edit' => 'terms_condition.edit',
         'update' => 'terms_condition.update',
         'destroy' => 'terms_condition.destroy'
     ]);

     Route::resource('workflow',  workflowController::class)->names([
         'index' => 'workflow.index',
         'create' => 'workflow.create',
         'store' => 'workflow.store',
         'show' => 'workflow.show',
         'edit' => 'workflow.edit',
         'update' => 'workflow.update',
         'destroy' => 'workflow.destroy'
     ]);

     Route::resource('leaving_details',  leaving_detailController::class)->names([
         'index' => 'leaving_details.index',
         'create' => 'leaving_details.create',
         'store' => 'leaving_details.store',
         'show' => 'leaving_details.show',
         'edit' => 'leaving_details.edit',
         'update' => 'leaving_details.update',
         'destroy' => 'leaving_details.destroy'
     ]);


     Route::resource('terms_condition',  terms_conditionController::class)->names([
         'index' => 'terms_condition.index',
         'create' => 'terms_condition.create',
         'store' => 'terms_condition.store',
         'show' => 'terms_condition.show',
         'edit' => 'terms_condition.edit',
         'update' => 'terms_condition.update',
         'destroy' => 'terms_condition.destroy'
     ]);
    Route::resource('online_messages',  online_messageController::class)->names([
         'index' => 'online_messages.index',
         'create' => 'online_messages.create',
         'store' => 'online_messages.store',
         'show' => 'online_messages.show',
         'edit' => 'online_messages.edit',
         'update' => 'online_messages.update',
         'destroy' => 'online_messages.destroy'
     ]);
     Route::resource('flag_color',  flag_colorController::class)->names([
         'index' => 'flag_color.index',
         'create' => 'flag_color.create',
         'store' => 'flag_color.store',
         'show' => 'flag_color.show',
         'edit' => 'flag_color.edit',
         'update' => 'flag_color.update',
         'destroy' => 'flag_color.destroy'
     ]);

     Route::resource('faq',  faqController::class)->names([
         'index' => 'faq.index',
         'create' => 'faq.create',
         'store' => 'faq.store',
         'show' => 'faq.show',
         'edit' => 'faq.edit',
         'update' => 'faq.update',
         'destroy' => 'faq.destroy'
     ]);
     Route::post('update-FAQ-flag',  [faqController::class,'update_flag'])->name('update-FAQ-flag');


     Route::resource('timesheet_status',  timesheet_statusController::class)->names([
         'index' => 'timesheet_status.index',
         'create' => 'timesheet_status.create',
         'store' => 'timesheet_status.store',
         'show' => 'timesheet_status.show',
         'edit' => 'timesheet_status.edit',
         'update' => 'timesheet_status.update',
         'destroy' => 'timesheet_status.destroy'
     ]);

     Route::resource('worker',  workerController::class)->names([
         'index' => 'worker.index',
         'create' => 'worker.create',
         'store' => 'worker.store',
         'show' => 'worker.show',
         'edit' => 'worker.edit',
         'update' => 'worker.update',
         'destroy' => 'worker.destroy'
     ]);


     Route::resource('invoice',  invoiceController::class)->names([
         'index' => 'invoice.index',
         'create' => 'invoice.create',
         'store' => 'invoice.store',
         'show' => 'invoice.show',
         'edit' => 'invoice.edit',
         'update' => 'invoice.update',
         'destroy' => 'invoice.destroy'
     ]);

     Route::resource('timesheet',  timesheetController::class)->names([
         'index' => 'timesheet.index',
         'create' => 'timesheet.create',
         'store' => 'timesheet.store',
         'show' => 'timesheet.show',
         'edit' => 'timesheet.edit',
         'update' => 'timesheet.update',
         'destroy' => 'timesheet.destroy'
     ]);

     Route::resource('assignment',  assignmentController::class)->names([
         'index' => 'assignment.index',
         'create' => 'assignment.create',
         'store' => 'assignment.store',
         'show' => 'assignment.show',
         'edit' => 'assignment.edit',
         'update' => 'assignment.update',
         'destroy' => 'assignment.destroy'
     ]);

     Route::resource('industry',  industryController::class)->names([
         'index' => 'industry.index',
         'create' => 'industry.create',
         'store' => 'industry.store',
         'show' => 'industry.show',
         'edit' => 'industry.edit',
         'update' => 'industry.update',
         'destroy' => 'industry.destroy'
     ]);

     Route::resource('consultant',  consultantController::class)->names([
         'index' => 'consultant.index',
         'create' => 'consultant.create',
         'store' => 'consultant.store',
         'show' => 'consultant.show',
         'edit' => 'consultant.edit',
         'update' => 'consultant.update',
         'destroy' => 'consultant.destroy'
     ]);

     Route::resource('supplier',  supplierController::class)->names([
         'index' => 'supplier.index',
         'create' => 'supplier.create',
         'store' => 'supplier.store',
         'show' => 'supplier.show',
         'edit' => 'supplier.edit',
         'update' => 'supplier.update',
         'destroy' => 'supplier.destroy'
     ]);

     Route::resource('client',  clientController::class)->names([
         'index' => 'client.index',
         'create' => 'client.create',
         'store' => 'client.store',
         'show' => 'client.show',
         'edit' => 'client.edit',
         'update' => 'client.update',
         'destroy' => 'client.destroy'
     ]);

     Route::resource('segment_head',  segment_headController ::class)->names([
         'index' => 'segment_head.index',
         'create' => 'segment_head.create',
         'store' => 'segment_head.store',
         'show' => 'segment_head.show',
         'edit' => 'segment_head.edit',
         'update' => 'segment_head.update',
         'destroy' => 'segment_head.destroy'
     ]);

     Route::resource('segment_structure_info',  segment_structure_infoController::class)->names([
         'index' => 'segment_structure_info.index',
         'create' => 'segment_structure_info.create',
         'store' => 'segment_structure_info.store',
         'show' => 'segment_structure_info.show',
         'edit' => 'segment_structure_info.edit',
         'update' => 'segment_structure_info.update',
         'destroy' => 'segment_structure_info.destroy'
     ]);

     Route::resource('segment_combination_setup',  segment_combination_setupController::class)->names([
         'index' => 'segment_combination_setup.index',
         'create' => 'segment_combination_setup.create',
         'store' => 'segment_combination_setup.store',
         'show' => 'segment_combination_setup.show',
         'edit' => 'segment_combination_setup.edit',
         'update' => 'segment_combination_setup.update',
         'destroy' => 'segment_combination_setup.destroy'
     ]);

     Route::post('delete_segment_combination_user/{id}', 'segment_combination_setupController@delete_segment_combination_user');

     Route::resource('segment_head_details',  segment_head_detailsController::class)->names([
         'index' => 'segment_head_details.index',
         'create' => 'segment_head_details.create',
         'store' => 'segment_head_details.store',
         'show' => 'segment_head_details.show',
         'edit' => 'segment_head_details.edit',
         'update' => 'segment_head_details.update',
         'destroy' => 'segment_head_details.destroy'
     ]);



     Route::post('del_seg_head',  [segment_structure_infoController::class, 'del_seg_head'])->name('del_seg_head');
     Route::post('getsegmnets', [segment_structure_infoController::class, 'getsegmnets'])->name('getsegmnets');

     Route::post('delete_segment_combination_user/{id}', [segment_combination_setupController::class, 'delete_segment_combination_user']);

     Route::any('loadCombinationSegmentData',  [segment_combination_setupController::class, 'loadCombinationSegmentData'])->name('loadCombinationSegmentData');


     Route::get('get_treeviewuser/{uid}', [UserController::class, 'get_treeviewuser'])->name('get_treeviewuser');

     Route::any('update-sortaccess', [ RoleController::class, 'update_sortaccess'])->name('update_sortaccess');

     Route::post('getsegmnets', [segment_structure_infoController::class, 'getsegmnets'])->name('getsegmnets');
    // Add more admin routes here
});


/*Route::prefix('admin')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'users'])->name('admin.users');
});
Route::Group(['prefix' => config('config.backend_path')], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'users'])->name('admin.users');
});
 Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');*/
