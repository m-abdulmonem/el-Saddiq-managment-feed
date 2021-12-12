@if(!session("error-404") || request()->segment(1) == "daily")
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"  data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item ">
                <a href="{{ url("/") }}" class="nav-link @homeMenu(1)">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>@lang("home.title")</p>
                </a>
            </li>
            <!-- ./dashboard -->


    @if(user_can(['read product','read medicine','read product_price_history']))
        @php($product = ['products','medicines','products/history/prices'])
        <li class="nav-item has-treeview @menuAny($product,0)">
            <a href="{{ route("products.index") }}" class="nav-link @menuAny($product,1)">
                <i class="fas fa-boxes"></i>
                <p>
                    @lang("products/products.title")
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @can("read product")
                    <li class="nav-item">
                        <a href="{{ route("products.index") }}" class="nav-link @menu($product[0],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("products/products.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read medicine")
                    <li class="nav-item">
                        <a href="{{ route("medicines.index") }}" class="nav-link @menu($product[1],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("products/medicines.title")</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif
    <!-- ./products -->

    @if(user_can(['read expenses','read receipts','read payments','read banks']))
        @php($transaction = ['expenses','receipts','payments','banks','payment/purchases','payment/returned','receipts/sales','receipts/returned'])
        <li class="nav-item has-treeview @menuAny($transaction,0)">
            <a href="#" class="nav-link @menuAny($transaction,1)">
                <i class="fas fa-wallet"></i>
                <p>
                    @lang("transactions/banks.transactions_title")
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @can("read expenses")
                    <li class="nav-item">
                        <a href="{{ route("expenses.index") }}" class="nav-link @menu($transaction[0],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("transactions/expenses.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read payments")
                    <li class="nav-item">
                        <a href="{{ route("sales.index") }}" class="nav-link @menu($transaction[6],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("transactions/receipts.sales.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read payments")
                    <li class="nav-item">
                        <a href="{{ route("purchases.returned.index") }}" class="nav-link @menu($transaction[7],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("transactions/receipts.returned.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read payments")
                    <li class="nav-item">
                        <a href="{{ route("payments.index") }}" class="nav-link @menu($transaction[2],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("transactions/payments.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read payments")
                    <li class="nav-item">
                        <a href="{{ route("purchases.index") }}" class="nav-link @menu($transaction[4],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("transactions/payments.purchases.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read payments")
                    <li class="nav-item">
                        <a href="{{ route("returned.index") }}" class="nav-link @menu($transaction[5],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("transactions/payments.returned.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read banks")
                    <li class="nav-item">
                        <a href="{{ route("banks.index") }}" class="nav-link @menu($transaction[3],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("transactions/banks.title")</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif
    <!-- ./transactions -->

    @if(user_can(['read daily']))
        @php($product = ['dailies'])
        <li class="nav-item has-treeview @menuAny($product,0)">
            <a href="{{ route("dailies.index") }}" class="nav-link @menuAny($product,1)">
                <i class="fas fa-boxes"></i>
                <p>
                    @lang("dailies.title")
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route("dailies.index") }}" class="nav-link @menu($product[0],1)">
                        <i class="far fa-circle nav-icon"></i>
                        <p>@lang("dailies.title")</p>
                    </a>
                </li>
            </ul>
        </li>
    @endif
    <!-- ./dailies -->

    @if(user_can(['read client','read client_balance','read client_bill']))
        @php($client = ['clients','graph/clients','clients/invoices'])
        <li class="nav-item has-treeview @menuAny($client,0)">
                <a href="{{ route("clients.index") }}" class="nav-link @menuAny($client,1)">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        @lang("clients/clients.title")
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can("read client")
                        <li class="nav-item">
                            <a href="{{ route("clients.index") }}" class="nav-link @menu($client[0],1)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang("clients/clients.title")</p>
                            </a>
                        </li>
                    @endcan
                    @can("read client_bill")
                        <li class="nav-item">
                            <a href="{{ route("invoices.index") }}" class="nav-link @menu($client[2],1)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang("clients/bills.title")</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
    @endif
    <!-- ./clients -->

    @if(user_can(['read supplier','read supplier_bill']))
        @php($suppliers = ['suppliers','suppliers/bills'])
        <li class="nav-item has-treeview @menuAny($suppliers,0)">
                <a href="{{ route("suppliers.index") }}" class="nav-link  @menuAny($suppliers,1)">
                    <i class="fas fa-industry"></i>
                    <p>
                        @lang("suppliers/suppliers.title")
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can("read supplier")
                        <li class="nav-item">
                            <a href="{{ route("suppliers.index") }}" class="nav-link @menu($suppliers[0],1)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang("suppliers/suppliers.title")</p>
                            </a>
                        </li>
                    @endcan
                    @can("read supplier_bill")
                        <li class="nav-item @menu($suppliers[1],0) }}">
                            <a href="{{ route("bills.index") }}" class="nav-link @menu($suppliers[1],1)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang("suppliers/bills.supplier_bills")</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
    @endif
    <!-- ./suppliers -->

{{--    @if(user_can(['read client_bill','read supplier_bill']))--}}
{{--        <li class="nav-item">--}}
{{--            <a href="{{ route("bills.index") }}" class="nav-link {{ active_class("bills",1) }}">--}}
{{--                <i class="fas fa-file-invoice"></i>--}}
{{--                <p>--}}
{{--                    {{ trans("bills.title") }}--}}
{{--                </p>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    @endif--}}
{{--    <!-- ./bills -->--}}

{{--    @can("read balance")--}}
{{--        <li class="nav-item">--}}
{{--            <a href="{{ route("balances.index") }}" class="nav-link {{ active_class("balances",1) }}">--}}
{{--                <i class="fas fa-wallet"></i>--}}
{{--                <p>{{ trans("balances.title") }}</p>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    @endcan--}}
{{--    <!-- ./balances -->--}}

    @if(user_can(['read user','read salary','read job','read attendance']))
        @php($users = ['users','attendances','jobs','salaries'])
        <li class="nav-item has-treeview  @menuAny($users,0)">
            <a href="{{ url("users") }}" class="nav-link @menuAny($users,1)">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    @lang("users/users.title")
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @can("read user")
                    <li class="nav-item">
                        <a href="{{ route("users.index") }}" class="nav-link @menu($users[0],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("users/users.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read attendance")
                    <li class="nav-item">
                        <a href="{{ route("attendances.index") }}" class="nav-link @menu($users[1],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("users/attendances.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read job")
                    <li class="nav-item">
                        <a href="{{ route("jobs.index") }}" class="nav-link @menu($users[2],1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("users/jobs.title")</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif
    <!-- ./users -->

    @can("read stock")
        <li class="nav-item">
            <a href="{{ route("stocks.index") }}" class="nav-link @menu("stocks",1)">
                <i class="fas fa-warehouse"></i>
                <p>@lang("stocks.title")</p>
            </a>
        </li>
    @endcan
    <!-- ./stocks -->

    @can("read category")
        <li class="nav-item">
            <a href="{{ route("categories.index") }}" class="nav-link @menu("categories",1)">
                <i class="nav-icon fas fa-list"></i>
                <p>
                    @lang("products/categories.title")
                </p>
            </a>
        </li>
    @endcan
    <!-- ./categories -->

    @if( user_can(['read chick','read chick_order','read chick_booking']) )
        @php($chicks = ['chicks','chicks/orders','chicks/booking'])
        <li class="nav-item has-treeview @menuAny($chicks,0) ">
            <a href="{{ url("chicks") }}" class="nav-link @menuAny($chicks,1)">
                <i class="fas fa-kiwi-bird"></i>
                <p>
                    @lang("chicks/chicks.title")
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @can("read chick")
                    <li class="nav-item">
                        <a href="{{ route("chicks.index") }}" class="nav-link @menu('chicks',1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("chicks/chicks.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read chick_order")
                    <li class="nav-item">
                        <a href="{{ route("chicks.orders.index") }}" class="nav-link @menu('chicks/orders',1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("chicks/orders.title")</p>
                        </a>
                    </li>
                @endcan
                @can("read chick_booking")
                    <li class="nav-item">
                        <a href="{{ route("chicks.booking.index") }}" class="nav-link @menu('chicks/booking',1)">
                            <i class="far fa-circle nav-icon"></i>
                            <p>@lang("chicks/booking.title")</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
    <!-- ./chicks -->

    @can("read setting")
        <li class="nav-item">
            <a href="{{ route("settings.index") }}" class="nav-link @menu('settings/settings',1)">
                <i class="nav-icon fas fa-cogs"></i>
                <p>@lang("settings.title")</p>
            </a>
        </li>
    @endcan
    <!-- ./settings -->

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
@endif
