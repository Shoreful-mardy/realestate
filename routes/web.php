<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ChatController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Agent\AgentPropertyController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CompareController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great! 
|
*/

Route::get('/', function () {
    return view('welcome');
});

//// user Frontend All route
Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//===========Start user Protected Route==========
Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::POST('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');


    /// User Schedule Request Start
    Route::get('/user/schedule/request', [UserController::class, 'UserScheduleRequest'])->name('user.schedule.request');
    /// User Schedule Request End

    /// User Live Chat route Start
    Route::get('/live/chat', [UserController::class, 'LiveChat'])->name('live.chat');
    /// User Live Chat route End


    //Route For Property Wishlist
    Route::controller(WishlistController::class)->group(function(){
        Route::get('/user/wishlist','UserWishList')->name('user.wishlist');
        Route::get('/get-wishlist-property/','GetWishListProperty');
        Route::get('/wishlist-remove/{id}','WishListRemove');
    });

    //Route For Property Compare
    Route::controller(CompareController::class)->group(function(){
        Route::get('/user/compare','UserCompare')->name('user.compare');
        Route::get('/get-compare-property/','GetCompareProperty');
        Route::get('/compare-remove/{id}','CompareRemove');
    });


    //Route For user Comment
    Route::POST('/store/comment', [BlogController::class, 'StoreComment'])->name('store.comment'); 




});



//===========End user Protected Route==========


require __DIR__.'/auth.php';


//===========Start Admin Protected Route==========
Route::middleware(['auth','roles:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
});
 //Group Protected Route For Admin
Route::middleware(['auth','roles:admin'])->group(function(){
    //Route For Property Type
    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/type','AllType')->name('all.type')->middleware('permission:all.type');
        Route::get('/add/type','AddType')->name('add.type')->middleware('permission:add.type');
        Route::post('/store/type','StoreType')->name('store.type');
        Route::get('/edit/type/{id}','EditType')->name('edit.type')->middleware('permission:edit.type');
        Route::post('/update/type','UpdateType')->name('update.type');
        Route::get('/delete/type/{id}','DeleteType')->name('delete.type');
    });

    //Route For all Amenitie
    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/amenitie','AllAmenitie')->name('all.aminite')->middleware('permission:all.amenitie');
        Route::get('/add/aminite','AddAminite')->name('add.aminite')->middleware('permission:add.amenitie');
        Route::post('/store/aminite','StoreAminite')->name('store.aminite');
        Route::get('/edit/aminite/{id}','EditAminite')->name('edit.aminite');
        Route::post('/update/aminite','UpdateAminite')->name('update.aminite');
        Route::get('/delete/aminite/{id}','DeleteAminite')->name('delete.aminite');
    });


    //Route For Property
    Route::controller(PropertyController::class)->group(function(){
        Route::get('/all/property','AllProperty')->name('all.property')->middleware('permission:all.property');
        Route::get('/add/property','AddProperty')->name('add.property')->middleware('permission:add.property');
        Route::post('/store/property','StoreProperty')->name('store.property');
        Route::get('/edit/property/{id}','EditProperty')->name('edit.property');
        Route::post('/update/property','UpdateProperty')->name('update.property');
        Route::post('/update/property/thamnail','UpdatePropertyThambnail')->name('update.property.thamnail');
        Route::post('/update/property/multiimage','UpdatePropertyMultiimage')->name('update.property.multiimage');
        Route::get('/property/multiimg/delete/{id}','PropertyMultiImageDelete')->name('property.multiimg.delete');
        Route::post('/store/new/multiimage','StoreNewMultiimage')->name('store.new.multiimage');
        Route::post('/Update/property/facilities','UpdatePropertyFacilities')->name('update.property.facilities');
        Route::get('/delete/property/{id}','DeleteProperty')->name('delete.property');
        Route::get('/details/property/{id}','DetailsProperty')->name('details.property');
        Route::post('/inactive/property','InActiveProperty')->name('inactive.property');
        Route::post('/active/property','ActiveProperty')->name('active.property');



        //// package history for Admin 

        Route::get('/admin/package/history','AdminPackageHistory')->name('admin.package.history')->middleware('permission:package.menu');
        Route::get('/admin/invoice/{id}','AdminPackageInvoice')->name('admin.package.invoice');

        /// Message For Admin
         
        Route::get('/admin/property/message','AdminPropertyMessage')->name('admin.property.message');
        Route::get('/admin/message/details/{id}','AdminDetailsMessage')->name('admin.message.details');


    });


    //Route For Agent
    Route::controller(AdminController::class)->group(function(){
        Route::get('/all/agent','AllAgent')->name('all.agent')->middleware('permission:all.agent');
        Route::get('/add/agent','AddAgent')->name('add.agent')->middleware('permission:add.agent');
        Route::post('/store/agent','StoreAgent')->name('store.agent');
        Route::get('/edit/agent/{id}','EditAgent')->name('edit.agent');
        Route::post('/update/agent','UpdateAgent')->name('update.agent');
        Route::get('/delete/agent/{id}','DeleteAgent')->name('delete.agent');
        Route::get('/changeStatus','ChangeStatus');

    });

    //Route For Property State
    Route::controller(StateController::class)->group(function(){
        Route::get('/all/state','AllState')->name('all.state')->middleware('permission:state.all');
        Route::get('/add/state','AddState')->name('add.state')->middleware('permission:add.state');
        Route::post('/store/state','StoreState')->name('store.state');
        Route::get('/edit/state/{id}','EditState')->name('edit.state');
        Route::post('/update/state','UpdateState')->name('update.state');
        Route::get('/delete/state/{id}','DeleteState')->name('delete.state');
    });

    //Route For Testimonials Manage
    Route::controller(TestimonialController::class)->group(function(){
        Route::get('/all/testimonials','AllTestimonials')->name('all.testimonials')->middleware('permission:all.testimonials');
        Route::get('/add/testimonials','AddTestimonials')->name('add.testimonials')->middleware('permission:add.testimonials');
        Route::post('/store/testimonials','StoreTestimonials')->name('store.testimonials');
        Route::get('/edit/testimonials/{id}','EditTestimonials')->name('edit.testimonials');
        Route::post('/update/testimonials','UpdateTestimonials')->name('update.testimonials');
        Route::get('/delete/testimonials/{id}','DeleteTestimonials')->name('delete.testimonials');
    });

    //Blog Category All Route
    Route::controller(BlogController::class)->group(function(){
        Route::get('/all/blog/category','AllBlogCategory')->name('all.blog.category')->middleware('permission:all.category');
        Route::post('/store/blog/category','StoreBlogCategory')->name('store.blog.category');
        Route::get('/blog/category/{id}','EditBlogcategory');
        Route::post('/update/blog/category','UpdateBlogCategory')->name('update.blog.category');
        Route::get('/delete/blog/category/{id}','DeleteBlogCategory')->name('delete.blog.category');
    });

    //Route For Blog Post Manage
    Route::controller(BlogController::class)->group(function(){
        Route::get('/all/post','AllPost')->name('all.post')->middleware('permission:all.post');
        Route::get('/add/post','AddPost')->name('add.post')->middleware('permission:add.post');
        Route::post('/store/post','StorePost')->name('store.post');
        Route::get('/edit/post/{id}','EditPost')->name('edit.post');
        Route::post('/update/post','UpdatePost')->name('update.post');
        Route::get('/delete/post/{id}','DeletePost')->name('delete.post');
    });

    //Route For Blog Post Comment Manage Start
    Route::controller(BlogController::class)->group(function(){
        Route::get('/admin/post/comment','AdminBlogComment')->name('admin.blog.comment');
        Route::get('/admin/comment/reply/{id}','AdminCommentReply')->name('admin.comment.reply');
        Route::post('/reply/message','ReplyMessage')->name('reply.message');

    });

    //SMTP Setting All Route all Start from here
    Route::controller(SettingController::class)->group(function(){
        Route::get('/smtp/setting','SmtpSetting')->name('smtp.setting');
        Route::post('/update/smtp/setting','UpdateSmtpSetting')->name('update.smtp.setting');
    });

    //Site Setting All Route all Start from here
    Route::controller(SettingController::class)->group(function(){
        Route::get('/site/setting','SiteSetting')->name('site.setting');
        Route::post('/update/site/setting','UpdateSiteSetting')->name('update.site.setting');
    });

    //Permission All Route
    Route::controller(RoleController::class)->group(function(){
        Route::get('/all/permission','AllPermission')->name('all.permission');
        Route::get('/add/permission','AddPermission')->name('add.permission');
        Route::post('/store/permission','StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}','EditPermission')->name('edit.permission');
        Route::post('/update/permission','UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}','DeletePermission')->name('delete.permission');


        //Route For Excel Import and Export

        Route::get('/import/permission','ImportPermission')->name('import.permission');
        Route::get('/export/permission','Export')->name('export');
        Route::post('/import/permission','Import')->name('import');

    });

    //Roles All Route
    Route::controller(RoleController::class)->group(function(){
        Route::get('/all/role','AllRole')->name('all.role');
        Route::get('/add/roles','AddRoles')->name('add.roles');
        Route::post('/store/roles','StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}','EditRoles')->name('edit.roles');
        Route::post('/update/roles','UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}','DeleteRoles')->name('delete.roles');

        // Add Role In Permission
        Route::get('/add/role/permission','AddRolePermission')->name('add.role.permission');
        Route::post('/role/permission/store','RolePermissionStore')->name('role.permission.store');
        Route::get('/all/role/permission','AllRolePermission')->name('all.role.permission');
        Route::get('/admin/edit/roles/{id}','AdminEditRoles')->name('admin.edit.roles');
        Route::post('/role/permission/update/{id}','RolePermisionUpdate')->name('role.permission.update');
        Route::get('/admin/delete/roles/{id}','AdminDeleteRoles')->name('admin.delete.roles');
    });

    //Admin User Manage All Route all Start from here
    Route::controller(AdminController::class)->group(function(){
        Route::get('/all/admin','AllAdmin')->name('all.admin');
        Route::get('/add/admin','AddAdmin')->name('add.admin');
        Route::post('/add/admin','StoreAdmin')->name('store.admin');
        Route::get('/admin/edit/{id}','AdminEdit')->name('edit.admin');
        Route::post('/update/admin/{id}','UpdateAdmin')->name('update.admin');
        Route::get('/admin/delete/{id}','AdminDelete')->name('delete.admin');



    });


});
//===========End Admin Protected Route==========

//===========Start Agent Protected Route==========

Route::middleware(['auth','roles:agent'])->group(function(){
    ///Agent log out and Profile  Start
    Route::get('/agent/logout', [AgentController::class, 'AgetnLogout'])->name('agent.logout');
    Route::get('/agent/profile', [AgentController::class, 'AgentProfile'])->name('agent.profile');
    Route::post('/agent/profile/store', [AgentController::class, 'AgentProfileStore'])->name('agent.profile.store');
    Route::get('/agent/change/password', [AgentController::class, 'AgentChangePassword'])->name('agent.change.password');
    Route::post('/agent/update/password', [AgentController::class, 'AgentUpdatePassword'])->name('agent.update.password');
    ///Agent log out and Profile  End
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agnet.dashboard');
    Route::get('/buy/dashboard', [AgentController::class, 'BuyPackage'])->name('buy.package');

});

Route::middleware(['auth','roles:agent'])->group(function(){
  
    //Route For Property All 
    Route::controller(AgentPropertyController::class)->group(function(){
        Route::get('/agent/all/property','AgentAllProperty')->name('agent.all.property');
        Route::get('/agent/add/property','AgentAddProperty')->name('agent.add.property');
        Route::post('/agent/store/property','AgentStoreProperty')->name('agent.store.property');
        Route::get('/agent/edit/property/{id}','AgentEditProperty')->name('agent.edit.property');
        Route::post('/agent/update/property','AgentUpdateProperty')->name('agent.update.property');
        Route::post('/agent/update/property/thambanail','AgentUpdatePropertyThambnail')->name('agent.update.property.thamnail');
        Route::post('/agent/update/property/multiimage','AgentUpdatePropertyMultiImage')->name('agent.update.property.multiimage');
        Route::get('/agent/property/multiimage/delete{id}','AgentPropertyMultiImageDelete')->name('agent.property.multiimg.delete');
        Route::post('/agent/store/new/multiimage','AgentStoreNewMultiImage')->name('agent.store.new.multiimage');
        Route::post('/agent/update/property/facilities','AgentUpdatePropertyFacilities')->name('agent.update.property.facilities');
        Route::get('/Agent/delete/property/{id}','AgentDeleteProperty')->name('agent.delete.property');
        Route::get('/agent/details/property/{id}','AgentDetailsProperty')->name('agent.details.property');
       

        //// Route For Property Message
        Route::get('/agent/property/message','AgentPropertyMessage')->name('agent.property.message');
         Route::get('/agent/message/details/{id}','AgentDetailsMessage')->name('agent.message.details');

         ///Route For Schedule Request
         Route::get('/agent/schedule/request','AgentScheduleRequest')->name('agent.schedule.request');
         Route::get('/agent/details/schedule/{id}','AgentDetailsSchedule')->name('agent.details.schedule');
         Route::post('/agent/update/schedule','AgentUpdateSchedule')->name('agent.update.schedule');
    });//End Group

    //Agent Buy Package
    Route::controller(AgentPropertyController::class)->group(function(){
        Route::get('/buy/dashboard','BuyPackage')->name('buy.package');
        Route::get('/buy/business/plan','BuyBusinessPlan')->name('buy.business.plan');
        Route::post('/store/business/plan','StoreBusinessPlan')->name('store.business.plan');
        Route::get('/store/professional/plan','BuyProfessionalPlan')->name('buy.professional.plan');
        Route::post('/store/professional/plan','StoreProfessionalPlan')->name('store.professional.plan');
        Route::get('/package/history','PackageHistory')->name('package.history');
        Route::get('/package/invoice/{id}','AgentPackageInvoice')->name('agent.package.invoice');
    });//End Group

    //Agent Live Chat  route
    Route::get('/agent/live/chat', [ChatController::class, 'AgentLiveChat'])->name('agent.live.chat');








});

//===========End Agent Protected Route==========


    Route::get('/agent/login', [AgentController::class, 'AgentLogin'])->name('agent.login')->middleware(RedirectIfAuthenticated::class);
    Route::post('/agent/register', [AgentController::class, 'AgentRegister'])->name('agent.register');
     Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);

/// FrontEnd Property  Details all Route start

    Route::get('/property/details/{id}/{slug}', [IndexController::class, 'PropertyDetails']);

    // Route For Add to wishlist
    Route::post('/add-to-wishlist/{property_id}', [WishlistController::class, 'AddToWishList']);
    // Route For Add to Compare
    Route::post('/add-to-compare/{property_id}', [CompareController::class, 'AddToComapre']);
// Sent Message From Property Details Page
    Route::post('/property/message', [IndexController::class, 'PropertyMessage'])->name('property.message');
    // Agent  Details Page in Frontend
    Route::get('/agent/details/{id}', [IndexController::class, 'AgentDetails'])->name('agent.details');
    // Sent Message From Agent Details Page
    Route::post('/agent/details/message', [IndexController::class, 'AgentDetailsMessage'])->name('agent.details.message');
    // Get All Rent Property
    Route::get('/rent/property/', [IndexController::class, 'RentProperty'])->name('rent.property');
    Route::get('/buy/property/', [IndexController::class, 'BuyProperty'])->name('buy.property');
    //Category wise Details Page
    Route::get('/property/category/{id}', [IndexController::class, 'PropertyCategory'])->name('property.type');
    Route::get('/state/details/{id}', [IndexController::class, 'StateDetails'])->name('state.details');
    // Homepage Buy Property Search Options
    Route::post('/buy/property/search', [IndexController::class, 'BuyPropertySearch'])->name('buy.property.search');
    // Homepage Rent Property Search Options
    Route::post('/rent/property/search', [IndexController::class, 'RentPropertySearch'])->name('rent.property.search');
    // Sidebar All Property Search Options
    Route::post('/all/property/search', [IndexController::class, 'AllPropertySearch'])->name('all.property.search');
    // BLog Details 
    Route::get('/blog/details/{slug}', [BlogController::class, 'BlogDetails']);
    Route::get('blog/cat/list/{id}', [BlogController::class, 'BlogCatList']);
    Route::get('/blog', [BlogController::class, 'BlogList'])->name('blog.list');


    // Route For Schedule Tour
    Route::post('/store/schedule', [IndexController::class, 'StoreSchedule'])->name('store.schedule');

    // Live Chat Post Request route
    Route::post('/send-message', [ChatController::class, 'SendMessage'])->name('send.msg');
    Route::get('/user-all', [ChatController::class, 'GetAllUsers']);
    Route::get('/user-message/{id}', [ChatController::class, 'UserMessageById']);







////FrontEnd Property  Details all Route start
