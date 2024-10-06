<?php

use App\Models\Setting;
use App\Models\Sms\SmsBody;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;


// /*
//  *  admin side  main url
//  *
//  */
// if (!function_exists('admin_assets')) {

//     /**
//      * get admin style files [urls]
//      *
//      * @param string $url
//      * @return string
//      */
//     function admin_assets(string $url = '/'): string
//     {
//         return asset('assets/dashboard/' . trim($url, '/'));
//     }
// }
if (!function_exists("_assets")) {
    function _assets($path, $folder, $plugin = null, bool $fullPath = false): string
    {
        $assets = "assets/$folder/";

        $imgTypes = ['jpeg', 'jpg', 'png', 'ico', 'svg'];
        $extension = array_reverse(explode(".", $path));

        if ($fullPath) {
            return asset($assets . "package/$path");
        }
        if ($plugin) {
            $pluginFolder = is_string($plugin) ? $plugin : $extension[count($extension) - 1];
            return asset($assets . "package/$pluginFolder/" . $extension[0] . "/$path");
        }
        if (in_array($extension[0], $imgTypes)) {
            return asset($assets . "img/$path");
        }
        return asset($assets . $extension[0] . "/$path");
    }
}

if (!function_exists("admin_assets")) {
    function admin_assets($path, $plugin = null, bool $fullPath = false): string
    {
        return _assets($path, "dashboard", $plugin, $fullPath);
    }
}

if (!function_exists("frontend_assets")) {
    /**
     * @param $path
     * @param string|null $plugin
     * @param false $fullPath
     * @return string
     */
    function frontend_assets($path, string $plugin = null, bool $fullPath = false): string
    {
        return _assets($path, "frontend", $plugin, $fullPath);
    }
}


/*
 *
 *
 */
if (!function_exists("admin")) {
    /**
     * For Admin Middleware
     * @return Guard|StatefulGuard
     */
    function admin(): Guard|StatefulGuard
    {
        return auth()->guard();
    }

}

/*
 *
 *
 */
if (!function_exists("profile")) {
    /**
     * For Admin Middleware
     * @param null $property
     * @param bool $update
     * @return Authenticatable|null
     */
    function profile($property = null, bool $update = false)
    {
        if ($update)
            return auth()->user();
        return (auth()->check())
            ? auth()->user()->$property
            : null;
    }
}

if (!function_exists("user_can")) {

    function user_can($permissions, $all = null, $user = null)
    {
        if ($all)
            return profile(null, true)->hasAllPermissions($permissions);
        if (!is_array($permissions)) {
            if ($user)
                return User::find($user)->can($permissions);
            return profile(null, true)->can($permissions);
        }
        if ($user)
            return User::find($user)->hasAnyPermission($permissions);
        return (($profile = profile(null, true)) ? $profile->hasAnyPermission($permissions) : null);
    }
}

if (!function_exists("btn_delete")) {
    /**
     *
     * @param $page_perm
     * @param $url
     * @param $data
     * @param null $property
     * @param bool $back
     * @param null $title
     * @return string
     */
    function btn_delete($page_perm, $url, $data, $property = null, bool $back = false, $title = null): string
    {
        return (user_can("delete $page_perm"))
            ? '<button class="btn btn-danger btn-delete " type="button"
                       data-url="' . route("$url.destroy", $data->id) . '"
                       data-name="' . ($property ? $data->$property : $data->name) . '"
                       data-token="' . csrf_token() . '"
                       data-title="' . trans("home.confirm_delete") . '"
                       data-text="' . trans("home.alert_delete", ['name' => $property ? $data->$property : $data->name]) . '"
                       ' . ($back ? 'data-back=' . route("$url.index") : null) . '>
                       <i class="fa fa-trash"></i> ' . ($title ? trans("home.delete") : null) . '</a>'
            : "<button class='btn btn-danger disabled'><i class='fa fa-trash'></i></button>";
    }
}


if (!function_exists("btn_update")) {
    function btn_update($page_perm, $url, $data): string
    {
        return (user_can("delete $page_perm"))
            ? '<a href="' . route("$url.edit", $data->id) . '" class="btn btn-info"><i class="fa fa-edit"></i></a>'
            : "<button class='btn btn-info disabled btn-update'><i class='fa fa-edit'></i></button>";
    }
}

if (!function_exists("button_update")) {
    function button_update($page_perm, $url, $data): string
    {
        return (user_can("delete $page_perm"))
            ? '<button data-url="' . route("$url.edit", $data->id) . '" class="btn btn-info"><i class="fa fa-edit"></i></button>'
            : "<button class='btn btn-info disabled btn-update'><i class='fa fa-edit'></i></button>";
    }
}

if (!function_exists("btn_view")) {
    function btn_view($page_perm, $url, $data, $title = null): string
    {
        return (user_can("read $page_perm"))
            ? '<a href="' . route("$url.show", $data->id) . '" class="btn btn-success"><i class="fa fa-eye"></i> ' . ($title ? trans("home.read") : null) . '</a>'
            : "<button class='btn btn-success disabled'><i class='fa fa-eye'></i> " . ($title ? trans("home.read") : null) . "</button>";
    }
}
if (!function_exists("btn_create")) {
    function btn_create($page_perm, $url): string
    {
        return (user_can("create $page_perm"))
            ? '<a href="' . route("$url.create") . '" class="btn btn-info"><i class="fa fa-plus"></i> ' . trans("home.new") . '</a>'
            : "<button class='btn btn-info disabled'><i class='fa fa-plus'></i> " . trans("home.new") . "</button>";
    }
}


if (!function_exists("check_perm")) {

    function check_perm($permission, $all = null, $user = null, $data_type = null)
    {
        //check if user has permission to read this page
        if (!user_can($permission, $all, $user)) {
            if ($data_type == "json")
                return json([], 403, trans("alert_access_denied"));
            //show 403 error page => [page unauthorized]
            abort(403);
        }
    }
}
// filter functions

/***
 * check valid email
 *
 */
if (!function_exists("is_email")) {

    /**
     *
     * @param string $email
     * @return mixed
     */
    function is_email(string $email): mixed
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

if (!function_exists("errors")) {

    /**
     * laravel validation errors
     * displaying all errors with bootstrap alert class
     *
     * @param $errors
     */
    function errors($errors): void
    {
        if ($errors)
            foreach ($errors->all() as $error)
                echo "<div class='alert alert-danger'>$error</div>";
    }
}

if (!function_exists('controllers_trans')) {

    /**
     * Get Controller Arabic Name
     *
     * @param $key
     * @return mixed
     */
    function controllers_trans($key): mixed
    {
        $trans = [
            '/' => trans("home.title"),
            'settings' => trans("settings.title"),
            'users' => trans("users/users.title"),
            'user' => trans("users/users.user"),
            'clients' => trans("clients/clients.title"),
            'categories' => trans("products/categories.title"),
            'stocks' => trans("stocks.title"),
            'jobs' => trans("users/jobs.title"),
            'attendances' => trans("users/attendances.title"),
            'products' => trans("products/products.title"),
            'product' => trans("products.title"),
            'bills' => trans("clients/bills.title"),
            'suppliers/bills' => trans("suppliers/bills.title"),
            'clients/invoices' => trans("clients/bills.title"),
            'balances' => trans("balances.title"),
            'suppliers' => trans("suppliers/suppliers.title"),
            'chicks' => trans("chicks/chicks.title"),
            'medicines' => trans("products/medicines.title"),
            'expenses' => trans("transactions/expenses.title"),
            'receipts' => trans("transactions/receipts.title"),
            'payments' => trans("transactions/payments.title"),
            'payment' => trans("transactions/payments.title"),
            'banks' => trans("transactions/banks.title"),
            'dailies' => trans("dailies.title"),
        ];
        return array_key_exists($key, $trans)
            ? $trans[$key]
            : null;
    }
}

if (!function_exists('get_breadcrumb')) {

    /**
     * Get [Breadcrumb]
     *
     * @param int $key
     * @param int $second
     * @param null $title
     * @return string|null
     */
    function get_breadcrumb(int $key = 1, int $second = 2, $title = null): ?string
    {

        if (request()->segment($key))
            //echo home anchor link
            echo '<li class="breadcrumb-item active"><a href="' . url('/') . '">' . controllers_trans('/') . ' </a></li>';

        if (request()->segment($second)) {

            $html = '<li class="breadcrumb-item"><a href="' . url(request()->segment($key)) . '"> ' . controllers_trans(request()->segment($key)) . '</a></li>';

            return $html .= "<li class='breadcrumb-item active'>$title</li>";

        }
//        ( ? $page : null);
        return ($page = controllers_trans((request()->segment($key) ? request()->segment($key) : ''))) ? '<li class="breadcrumb-item active">' . $page . '</li>' : null;
    }

}

if (!function_exists("json")) {

    /**
     * print data in json format
     *
     * @param mixed $data
     * @return JsonResponse
     */
    function json(mixed $data): JsonResponse
    {
        $data = is_callable($data) ? $data() : func_get_args();

        return response()->json($data);
    }
}

if (!function_exists("jsonSuccess")) {

    /**
     *
     *
     * @param string $text
     * @param callable|null $data
     * @return JsonResponse
     */
    function jsonSuccess(string $text, mixed $data = null): JsonResponse
    {

        return response()->json([
            'text' => $text,
            'data' => (func_get_args() > 2
                ? func_get_args()
                : (is_callable($data)
                    ? $data()
                    : $data)
            ),
            'code' => 1,
        ]);

    }
}

if (!function_exists("jsonError")) {

    /**
     *
     *
     * @param string $text
     * @param array $data
     * @return JsonResponse
     */
    function jsonError(string $text, array $data = []): JsonResponse
    {
        return response()->json([
            'text' => $text,
            'data' => $data,
            'code' => 0,
        ]);
    }
}




if (!function_exists('image')) {

    /**
     * Store Images Or Files to Server
     * get Save [Image] or [file] by file name
     * get old [image] when update
     *
     *
     * @param $name
     * @param bool $get_img
     * @param null $update
     * @param string $folder_name
     * @return string|UrlGenerator
     */
    function image($name, bool $get_img = false, $update = null, string $folder_name = 'images'): UrlGenerator|string
    {
        if (!request()->hasFile($name) && $update)
            return $update;
        if (request()->hasFile($name) && !$get_img) {
            request()->validate([
                $name => 'image|mimes:jpeg,png,jpg,gif|max:6000'
            ]);
            return request()->file($name)->store($folder_name, 'public');
        }
        if ($get_img) {
            return (str_contains($name, 'images') || str_contains($name, 'companies_logo'))
                ? asset('storage/' . $name)
                : admin_assets("MAAdminLogo.png");
        }
    }
}


if (!function_exists("storeImage")) {

    function storeImage($request, $name, $folderName = "images")
    {
        if ($request->hasFile($name)) {

            $request->validate([
                $name => 'image|mimes:jpeg,png,jpg,gif|max:6000'
            ]);

            return $request->file($name)->store($folderName, 'public');
        }

        return false;
    }
}


if (!function_exists("updateImage")) {
    function updateImage($request, $name, $file, $folderName = "images")
    {

        return ($image = storeImage($request, $name, $folderName)) ? $image : $file;
    }
}


if (!function_exists("img")) {

    function img($name): string
    {
        return (str_contains($name, 'images') || str_contains($name, 'companies_logo'))
            ? asset('storage/' . $name)
            : admin_assets("MAAdminLogo.png");
    }
}


if (!function_exists('settings')) {

    /**
     * get site [Settings]
     *
     * @param $property
     * @param bool $action
     * @param array $data
     * @return mixed
     */
    function settings($property = null, bool $action = false, array $data = []): mixed
    {
        $settings = Setting::orderBy('id', 'DESC')->first();
        if ($action)
            return $settings
                ? $settings->update($data)
                : Setting::create($data);
        return $settings ? Setting::orderBy('id', 'DESC')->first()->$property : false;
    }
}

if (!function_exists('get_role_name')) {

    /**
     * get User Role Name
     * @param $user
     * @return mixed
     */
    function get_role_name($user): mixed
    {
        return str_replace(['[', '"', '"', ']'], '', $user->getRoleNames());
    }
}

if (!function_exists("array_extract")) {

    function array_extract($array, $index = "name"): void
    {
        foreach ($array as $value) {
            echo $value->$index . ",";
        }
    }
}

if (!function_exists("array_to_string")) {

    function array_to_string($array = [], $separator = ","): void
    {
        foreach ($array as $value)
            echo "$value $separator";
    }
}

if (!function_exists("get_roles")) {

    function get_roles($roles): void
    {
        foreach ($roles as $role) {
            echo "$role->name,";
        }
    }
}// end of get roles

if (!function_exists("get_days")) {

    function get_days($roles): void
    {
        foreach ($roles as $role) {
            echo "$role->name,";
        }
    }
}// end of get roles

if (!function_exists("datatable_files")) {
    /**
     * get datatable js files
     *
     * @param string $file_type
     * @param bool $buttons
     * @return string
     */
    function datatable_files(string $file_type = "js", bool $buttons = true)
    {
        if ($file_type == "css")
            echo '<!-- DataTables -->
                <link rel="stylesheet" href="' . admin_assets("dataTables.bootstrap4.min.css") . '">
                 <link rel="stylesheet" href="' . admin_assets("responsive.dataTables.min.css") . '">';
        if ($file_type == "css" && $buttons) {
            return '<link rel="stylesheet" href="' . admin_assets("buttons.dataTables.min.css") . '">';
        }
        if ($file_type == "js")
            echo '  <!-- DataTables -->
                <script src="' . admin_assets("jquery.dataTables.min.js") . '"></script>
                <script src="' . admin_assets("dataTables.bootstrap4.min.js") . '"></script>
                <script src="' . admin_assets("datatables/table.js") . '"></script>';
        if ($buttons)
            echo '<script src="' . admin_assets("datatables/dataTables.buttons.min.js") . '"></script>
                  <script src="' . admin_assets("datatables/buttons.print.min.js") . '"></script>
                  <script src="' . admin_assets("datatables/buttons.colVis.min.js") . '"></script>';

    }
}// end of datatable_files

if (!function_exists("str")) {

    /**
     * make an instance of Str class
     *
     * @return Str
     */
    function str(): Str
    {
        return new Str();
    }

}//end of str

if (!function_exists("str_limit")) {
    /**
     * crop your text by [$limit]
     *
     * @param $str
     * @param $limit
     * @param string $mark
     * @return string
     */
    function str_limit($str, $limit, string $mark = "..."): string
    {
        return str()->limit($str, $limit) . $mark;
    }
}//end of str_limit


if (!function_exists("active_menu_any")) {

    function active_menu_any(array $routes, $class = null): void
    {
        foreach ($routes as $route)
            echo active_menu($route, $class);
    }
}

if (!function_exists("active_menu_home")) {

    function active_menu_home($class = null)
    {
        if (!active_menu_route())
            return get_active_menu_class($class);
    }
}

if (!function_exists("active_menu")) {

    function active_menu($page, $class = null)
    {

        return ($page == active_menu_route()) ? get_active_menu_class($class) : null;
    }
}
if (!function_exists("active_menu_route")) {

    function active_menu_route(): string
    {

        $route = implode("/", request()->segments());

        $route = str_replace(['create', 'edit'], "", $route);

        return trim(preg_replace("/[0-9]/", "", $route), "/");
    }
}

if (!function_exists("get_active_menu_class")) {

    function get_active_menu_class($class)
    {
        $classes = ['open' => 'menu-open', 'active' => 'active'];

        if (is_int($class))
            return array_values($classes)[$class];

        return $classes[$class];
    }
}

if (!function_exists("select_options")) {

    /**
     * select
     *
     * @param array $options
     * @param null $old
     * @param null $update
     * @param string $trans_page
     */
    function select_options(array $options = [], $old = null, $update = null, string $trans_page = "users"): void
    {
        foreach ($options as $key => $option) {

            $selected = (($key == 0 || $option == old($old) || $update === $option) ? "selected" : "");

            echo "<option value='$option' " . $selected . ">" . trans("$trans_page.option_" . ($option ? $option : "default")) . "</option>";
        }
    }
}
if (!function_exists("select_options_db")) {

    /**
     * select
     *
     * @param array $options
     * @param null $old
     * @param null $update
     * @param array $attr
     */
    function select_options_db($options, $old = null, $update = null, $attr = []): void
    {


        if (!empty($attr)) {
            $id = $attr['key'];
            foreach ($options as $obj)
                echo "<option value='" . $obj->$id . "' " . (($obj->$id == 0 || $obj->$id == old($old) || $update === $obj->$id) ? "selected" : "") . ">" . get_properties($obj, $attr['data']) . "</option>";
        } else
            foreach ($options as $key => $option)
                echo "<option value='$key' " . (($key == 0 || $key == old($old) || $update === $key) ? "selected" : "") . ">$option</option>";
    }
}

if (!function_exists("get_properties")) {
    function get_properties($obj, $properties): void
    {
        foreach ($properties as $property)
            echo $obj->$property;
    }
}


if (!function_exists("num_to_arabic")) {

    /**
     * Converts numbers in string from western to eastern Arabic numerals.
     *
     * @param $number
     * @return string Text with western Arabic numerals converted into eastern Arabic numerals.
     */
    function num_to_arabic($number): string
    {
        return num_format(NumberFormatter::CURRENCY, $number);
    }
}

if (!function_exists("spell_out")) {

    function spell_out($value): bool|string
    {
        return num_format(NumberFormatter::SPELLOUT, $value);
    }
}

if (!function_exists("num_format")) {

    function num_format($style, $value): bool|string
    {
        return numfmt_format_currency(numfmt_create("ar_EG", $style), $value, "EGP");
    }
}

if (!function_exists("currency")) {

    /**
     * @param $number
     * @return string
     */
    function currency($number): string
    {
        return num_to_arabic($number);
    }
}

if (!function_exists("to_arabic_int")) {

    /**
     * convert english number to arabic number
     *
     * @param $num
     * @return mixed
     */
    function to_arabic_int($num): mixed
    {
        return $num ? str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'], $num) : null;
    }
}

if (!function_exists("num_to_ar")) {

    function num_to_ar($num)
    {
        return to_arabic_int($num);
    }
}



if (!function_exists("date_ar")) {
    /**
     * @param $date
     * @return Carbon|string
     * @throws Exception
     */
    function date_ar($date)
    {
        return carbon($date)->locale("ar_AR");
    }
}
if (!function_exists("hour_in_ar")) {
    /**
     * @param $date
     * @return Carbon|string
     */
    function hour_in_ar($date)
    {
        return str_replace(['pm', 'am'], ['م', 'ص'], num_to_ar($date));
    }
}


if (!function_exists("date_ar_format")) {
    /**
     * @param $date
     * @return string|null
     * @throws Exception
     */
    function date_ar_format($date)
    {
        if ($date instanceof Carbon) {
            $d = date_ar($date);
            return to_arabic_int($d->day) . " $d->monthName, " . to_arabic_int($d->year);
        }
        return null;
    }
}

if (!function_exists("carbon")) {
    /**
     * Create a new Carbon instance of
     * given time, or return a new instance.
     *
     * @param DateTime|null $datetime
     * @param string $format
     * @return Carbon
     * @throws Exception
     */
    function carbon($datetime = null, string $format = 'Y-m-d H:i:s'): Carbon
    {
        if ($datetime instanceof DateTime) {
            return new Carbon($datetime->format($format));
        }

        return new Carbon;
    }
}// nd of carbon

if (!function_exists("carbon_parse")) {
    /**
     * Create a new Carbon instance of
     * given time, or return a new instance.
     *
     * @param DateTime|null $datetime
     * @param string $format
     * @return string
     * @throws Exception
     */
    function carbon_parse($datetime = null, $format = null): string
    {
        $carbon = Carbon::parse($datetime);

        return $format ? $carbon->format($format) : $carbon;
    }
}


if (!function_exists("rand_color")) {

    function rand_color($useSeparator = false): string
    {
        $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);

        return $useSeparator ? "#$rand" : $rand;
    }
}

if (!function_exists("search")) {

    function search($key, array $search): array
    {
        // no shortest distance found, yet
        $shortest = -1;

        // loop through words to find the closest
        foreach ($search as $word) {

            // calculate the distance between the input word,
            // and the current word
            $lev = levenshtein($key, $word);

            // check for an exact match
            if ($lev == 0) {

                // closest word is this one (exact match)
                $closest = $word;
                $shortest = 0;

                // break out of the loop; we0 ve found an exact match
                break;
            }

            // if this distance is less than the next found shortest
            // distance, OR if a next shortest word has not yet been found
            if ($lev <= $shortest || $shortest < 0) {
                // set the closest match, and shortest distance
                $closest = $word;
                $shortest = $lev;
            }
        }

        return [
            'closest' => $closest,
            'condition' => ($shortest == 0),
            "mean" => trans("home." . (($shortest == 0) ? "exact_match_found" : "did_u_mean")) . ": $closest\n"
        ];
    }

}


if (!function_exists("nexmoBalance")) {
    function smsProviderBalance(): float
    {
        return round(2, 2);
    }
}
if (!function_exists("nexmoBalanceCheck")) {
    /**
     *
     * @return bool
     */
    function smsProviderBalanceCheck(): bool
    {
        return smsProviderBalance() > 0.03;
    }
}
if (!function_exists("nexmo")) {

    /**
     * Send SMS Messages By Nexmo Provider
     *
     * @param $to
     * @param $message
     * @return mixed
     */
    function smsMessage($to, $message): mixed
    {

    }
}

if (!function_exists("beCallable")) {

    /**
     *
     *
     * @param $data
     *
     * @param int $defaultArgs
     *  its the the function argus count are needed to run the function
     * @return array
     */
    function beCallable($data, $defaultArgs = 2)
    {

        if (func_get_args() > $defaultArgs)
            return func_get_args();

        return (is_callable($data) ? $data() : $data);
    }
}

if (!function_exists("eachData")) {

    /**
     * loop the given array
     *
     * @param $data
     * @param callable $callback
     * @return callable|Collection
     */
    function eachData($data, callable $callback)
    {
        $collect = collect();

        foreach ($data as $k => $v)
            $callback($collect, $k, $v);

        return $collect !== null ? $collect : $callback;
    }
}

if (!function_exists("mapArray")) {

    function mapArray($data, $callback)
    {
        $collect = collect();

        foreach ($data as $k => $v)
            $callback($collect, $v, $k);

        return $collect;
    }
}


if (!function_exists("startDate")) {
    /**
     * reformat unix date format to timestamp
     *
     * @param $date
     * @return false|string
     */
    function startDate($date)
    {
//        return (!isDate($date))
//            ?
//        date("Y-m-d 00:00:00", strtotime("2020-10-25")
        return date('Y-m-d 00:00:00', strtotime($date));
//            : "$date 00:00:00";
    }
}

if (!function_exists("endDate")) {

    /**
     * reformat unix date format to timestamp
     *
     * @param $date
     * @param string $time
     * @return false|string
     */
    function endDate($date, $time = "23:59:59")
    {
//        return (!isDate($date))
//            ?
        return date("Y-m-d $time", strtotime($date));
//            : "$date $time";
    }
}


if (!function_exists("removeMines")) {
    /**
     * remove mines from string
     *
     * @param $val
     * @return int
     */
    function removeMines($val)
    {
        return (int)str_replace("-", "", $val);
    }
}

if (!function_exists("isDate")) {

    /**
     * check if the given string is valid date
     *
     * @param string $date
     * @return bool
     */
    function isDate(string $date)
    {
        return DateTime::createFromFormat("Y-m-d", $date) !== false;
    }
}
if (!function_exists("smsBody")) {

    function smsBody($code)
    {
        return SmsBody::findBy($code);
    }
}
