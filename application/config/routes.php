<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "main";
$route['404_override'] = '';

/*articles routing*/
$route['articles/view/(:any)'] = "articles/view/$1";
$route['articles/(:num)'] = "articles/index/$1";
$route['articles/(:any)/(:any)'] = "articles/view/$2";
$route['articles/(:any)'] = "articles/with_categs/$1/1";
$route['articles/'] = "articles/index";

/*static pages*/
$route['page/(:any)'] = "pages/view/$1";

/*forms*/
$route['forms'] = "forms";
$route['forms/edit/(:num)'] = "forms/index/$1";
$route['forms/printer'] = "forms/printer";
$route['forms/find_user'] = "forms/find_user";
$route['forms/view/(:any)'] = "forms/view/$1";
$route['forms/pager'] = "forms/pager";
$route['forms/pager/(:num)'] = "forms/pager/$1";
$route['forms/user_delete/(:num)/(:any)'] = "forms/user_delete/$1/$2";
$route['forms/get_city'] = "forms/get_city";
$route['forms/get_surname'] = "forms/get_surname";
$route['forms/find_surname'] = "forms/find_surname";
$route['forms/get_special'] = "forms/get_special";
$route['forms/scanner'] = "forms/scanner";
$route['forms/search'] = "forms/search";
$route['forms/print_page/(:num)/(:num)'] = "forms/print_page/$1/$2";

$route['admin/settings/edit/(:num)'] = "admin/setting_edit/$1";
$route['admin/articles/edit/(:num)'] = "admin/article_edit/$1";
$route['admin/categs/edit/(:num)'] = "admin/categ_edit/$1";
$route['admin/gallery/edit/(:num)'] = "admin/album_edit/$1";
$route['admin/meta/edit/(:num)'] = "admin/meta_edit/$1";
$route['admin/pages/edit/(:num)'] = "admin/page_edit/$1";
$route['admin/forms/edit/(:num)'] = "admin/forms_edit/$1";
$route['admin/themes/edit/(:num)'] = "admin/themes_edit/$1";

$route['admin/settings/add'] = "admin/setting_edit";
$route['admin/articles/add'] = "admin/article_edit";
$route['admin/categs/add'] = "admin/categ_edit";
$route['admin/gallery/add'] = "admin/album_edit";
$route['admin/meta/add'] = "admin/meta_edit";
$route['admin/pages/add'] = "admin/page_edit";
$route['admin/forms/add'] = "admin/forms_edit";
$route['admin/themes/add'] = "admin/themes_edit";

$route['admin/gallery/images/(:num)/(:any)'] = "admin/album_images/$1/$2";
$route['admin/pages/images/(:num)/(:any)'] = "admin/album_images/$1/$2";
$route['admin/articles/images/(:num)/(:any)'] = "admin/album_images/$1/$2";

$route['admin'] = "admin";
$route['articles'] = "articles";
$route['admin/(:any)'] = "admin/$1";
$route['(:any)'] = "pages/view/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */