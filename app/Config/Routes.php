<?php

use CodeIgniter\Router\RouteCollection;

$isLogged   = ['filter' => 'login'];

/**
 * @var RouteCollection $routes
 */
// Home Page
$routes->add('/', 'Home::index');
$routes->add('home', 'Home::index');
$routes->add('setlanguage', 'Home::setLanguageWeb');

/**
 * Authentication
 */
$routes->add('cms', 'LoginController::index');
$routes->group('cms/auth', function ($routes) {
    $routes->add('', 'LoginController::index');
    $routes->add('login', 'LoginController::authProcess');
    $routes->add('logout', 'LoginController::logoutProcess');
});

$routes->add('cms/dashboard', 'Home::dashboardCms', $isLogged);

// CMS API
$routes->group('cms/api', $isLogged, function () use ($routes) {
    $routes->post('menu/get-master', 'Masters\Menu::getSelectMaster');
    $routes->post('getusergroup', 'Masters\UserGroup::apiGetUserGroup');
    $routes->post('getcompany', 'Masters\Company::apiGetCompany');
    $routes->post('getcategory', 'Masters\Category::apiGetCategory');
    $routes->post('gettype', 'Masters\DataType::apiGetType');
    $routes->post('get(:any)', 'Masters\DataType::apiGetByCategory/$1');
});
$routes->add('api-(:any)/(:any)/preview/(:any)', 'PreviewFile::image/$1/$2/$3');

// ADMIN PANEL -- MASTERS
$routes->group('cms/company', $isLogged, function ($routes) {
    $routes->add('', 'Masters\Company::index');
    $routes->add('table', 'Masters\Company::datatable');
    $routes->add('form', 'Masters\Company::form');
    $routes->add('form/(:any)', 'Masters\Company::form/$1');
    $routes->add('add', 'Masters\Company::add');
    $routes->add('update', 'Masters\Company::update');
    $routes->add('delete', 'Masters\Company::delete');
});
$routes->group('cms/user', $isLogged, function ($routes) {
    $routes->add('', 'Masters\User::index');
    $routes->add('table', 'Masters\User::datatable');
    $routes->add('form', 'Masters\User::forms');
    $routes->add('form/(:any)', 'Masters\User::forms/$1');
    $routes->add('add', 'Masters\User::add');
    $routes->add('update', 'Masters\User::update');
    $routes->add('delete', 'Masters\User::delete');
    $routes->add('access', 'Masters\User::formGroups');
    $routes->add('access/table', 'Masters\User::datatableGroups');
    $routes->add('access/add', 'Masters\User::addGroups');
    $routes->add('access/update', 'Masters\User::updateGroups');
    $routes->add('access/delete', 'Masters\User::deleteGroups');
    $routes->add('updatefield', 'Masters\User::updateField');
});
$routes->group('cms/usergroup', $isLogged, function ($routes) {
    $routes->add('', 'Masters\UserGroup::index');
    $routes->add('table', 'Masters\UserGroup::datatable');
    $routes->add('form', 'Masters\UserGroup::forms');
    $routes->add('form/(:any)', 'Masters\UserGroup::forms/$1');
    $routes->add('add', 'Masters\UserGroup::add');
    $routes->add('update', 'Masters\UserGroup::update');
    $routes->add('delete', 'Masters\UserGroup::delete');
    $routes->add('privileges', 'Masters\UserGroup::formPrivileges');
    $routes->add('privileges/update', 'Masters\UserGroup::updatePrivileges');
});
$routes->group('cms/menu', $isLogged, function ($routes) {
    $routes->get('', 'Masters\Menu::index');
    $routes->post('table', 'Masters\Menu::getTable');
    $routes->post('form', 'Masters\Menu::form');
    $routes->post('form/(:any)', 'Masters\Menu::form/$1');
    $routes->post('add', 'Masters\Menu::add');
    $routes->post('update', 'Masters\Menu::update');
    $routes->post('delete', 'Masters\Menu::destroy');
    $routes->post('sort', 'Masters\Menu::formSort');
    $routes->post('update-sort', 'Masters\Menu::updateSort');
    $routes->post('features', 'Masters\Menu::formFeatures');
    $routes->post('features/table', 'Masters\Menu::getTableFeatures');
    $routes->post('features/add', 'Masters\Menu::addFeatures');
    $routes->post('features/delete', 'Masters\Menu::deleteFeatures');
    $routes->post('features/add-template', 'Masters\Menu::addTemplateFeatures');
    $routes->post('features/updatefield', 'Masters\Menu::updateFieldFeatures');
});
$routes->group('cms/category', $isLogged, function ($routes) {
    $routes->add('', 'Masters\Category::index');
    $routes->add('table', 'Masters\Category::datatable');
    $routes->add('form', 'Masters\Category::form');
    $routes->add('form/(:any)', 'Masters\Category::form/$1');
    $routes->add('add', 'Masters\Category::add');
    $routes->add('update', 'Masters\Category::update');
    $routes->add('delete', 'Masters\Category::delete');
});
$routes->group('cms/datatype', $isLogged, function ($routes) {
    $routes->add('', 'Masters\DataType::index');
    $routes->add('table', 'Masters\DataType::datatable');
    $routes->add('form', 'Masters\DataType::form');
    $routes->add('form/(:any)', 'Masters\DataType::form/$1');
    $routes->add('add', 'Masters\DataType::add');
    $routes->add('update', 'Masters\DataType::update');
    $routes->add('delete', 'Masters\DataType::delete');
});
// ADMIN PANEL -- CMS
$routes->group('cms/slide', $isLogged, function ($routes) {
    $routes->add('', 'Cms\SlideImage::index');
    $routes->add('table', 'Cms\SlideImage::datatable');
    $routes->add('form', 'Cms\SlideImage::form');
    $routes->add('form/(:any)', 'Cms\SlideImage::form/$1');
    $routes->add('add', 'Cms\SlideImage::add');
    $routes->add('update', 'Cms\SlideImage::update');
    $routes->add('delete', 'Cms\SlideImage::delete');
    $routes->add('updatefield', 'Cms\SlideImage::updateField');
});
$routes->group('cms/categoryproduct', $isLogged, function ($routes) {
    $routes->add('', 'Cms\ProductCategory::index');
    $routes->add('table', 'Cms\ProductCategory::datatable');
    $routes->add('form', 'Cms\ProductCategory::form');
    $routes->add('form/(:any)', 'Cms\ProductCategory::form/$1');
    $routes->add('add', 'Cms\ProductCategory::add');
    $routes->add('update', 'Cms\ProductCategory::update');
    $routes->add('delete', 'Cms\ProductCategory::delete');
    $routes->add('updatefield', 'Cms\ProductCategory::updateField');
});
$routes->group('cms/products', $isLogged, function ($routes) {
    $routes->add('', 'Cms\Products::index');
    $routes->add('table', 'Cms\Products::datatable');
    $routes->add('form', 'Cms\Products::form');
    $routes->add('form/(:any)', 'Cms\Products::form/$1');
    $routes->add('add', 'Cms\Products::add');
    $routes->add('update', 'Cms\Products::update');
    $routes->add('delete', 'Cms\Products::delete');
    $routes->add('updatefield', 'Cms\Products::updateField');
});
$routes->group('cms/the-updates', $isLogged, function ($routes) {
    $routes->add('', 'Cms\TheUpdates::index');
    $routes->add('table', 'Cms\TheUpdates::datatable');
    $routes->add('form', 'Cms\TheUpdates::form');
    $routes->add('form/(:any)', 'Cms\TheUpdates::form/$1');
    $routes->add('add', 'Cms\TheUpdates::add');
    $routes->add('update', 'Cms\TheUpdates::update');
    $routes->add('delete', 'Cms\TheUpdates::delete');
    $routes->add('updatefield', 'Cms\TheUpdates::updateField');
    $routes->add('upload', 'Cms\TheUpdates::uploadEditor');
    $routes->add('browse', 'Cms\TheUpdates::browserEditor');
});
$routes->group('cms/contentcompany', $isLogged, function ($routes) {
    $routes->add('', 'Cms\ContentCompany::index');
    $routes->add('add', 'Cms\ContentCompany::add');
    $routes->add('update', 'Cms\ContentCompany::update');
    $routes->add('delete', 'Cms\ContentCompany::delete');
    $routes->add('upload', 'Cms\ContentCompany::uploadEditor');
    $routes->add('browse', 'Cms\ContentCompany::browserEditor');
});
$routes->group('cms/bamboo', $isLogged, function ($routes) {
    $routes->add('', 'Cms\ContentBamboo::index');
    $routes->add('add', 'Cms\ContentBamboo::add');
    $routes->add('update', 'Cms\ContentBamboo::update');
    $routes->add('delete', 'Cms\ContentBamboo::delete');
    $routes->add('upload', 'Cms\ContentBamboo::uploadEditor');
    $routes->add('browse', 'Cms\ContentBamboo::browserEditor');
});
$routes->group('cms/contentfurnishing', $isLogged, function ($routes) {
    $routes->add('', 'Cms\ContentFurnishing::index');
});
$routes->add('cms/updatefullcontent', 'Home::UpdateContent', $isLogged);
$routes->add('cms/updateimage', 'Home::updateImageContent', $isLogged);
$routes->add('cms/switchLang', 'Home::switchLanguage', $isLogged);


// FRONT-END COMPRO
/**
 * Company
 */
$routes->group('company', function ($routes) {
    $routes->add('', 'CompanyController::index');
});
/**
 * Furnishing
 */
$routes->group('furnishing', function ($routes) {
    $routes->add('', 'ProductController::index');
    $routes->add('getproducts', 'ProductController::getProducts');
    $routes->add('detail/(:any)', 'ProductController::detailProduct/$1');
});
/**
 * Bamboo
 */
$routes->group('bamboo', function ($routes) {
    $routes->add('', 'BambooController::index');
});
/**
 * Contact Page
 */
$routes->group('contact', function ($routes) {
    $routes->add('', 'ContactController::index');
});
/**
 * Updates Page
 */
$routes->group('updates', function ($routes) {
    $routes->add('', 'Home::updatesPage');
    $routes->add('detail/(:any)', 'Home::updateDetail/$1');
});
