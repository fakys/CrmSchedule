<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{isset($title)?$title:'CRM'}}</title>
    <link rel="stylesheet" href="{{asset('assets/layouts/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/Html/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/layouts/css/base_layout.css')}}">
    @yield('css_files')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                   aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img src="#" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <img src="#" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="#" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-white-blue elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('interface.index')}}" class="brand-link main-link">
            <span class="">CRM</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item menu-is-opening menu-open rm-group-container">
                        <a href="#" class="nav-link rm-group">
                            <i class="fa fa-cogs nav-icon" aria-hidden="true"></i>
                            <p class="name-rm-layout text-nowrap">
                                РМ Руководителя
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item rm-level-2">
                                <a href="{{route('system_settings.settings')}}" class="nav-link">
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                    <p>Настройки системы</p>
                                </a>
                            </li>
                            <li class="nav-item rm-level-2">
                                <a href="{{route('modules_settings.settings')}}" class="nav-link">
                                    <i class="fa fa-sitemap" aria-hidden="true"></i>
                                    <p>Модули</p>
                                </a>
                            </li>
                            <li class="nav-item rm-level-2">
                                <div class="nav-link">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <p>
                                        Пользователи
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </div>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item rm-level-3">
                                        <a href="{{route('users_interface.users_info')}}" class="nav-link">
                                            <p>Пользователи</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Роли</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="{{route('users_interface.user_groups_info')}}" class="nav-link">
                                            <p>Группы</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item menu-is-opening menu-open rm-group-container">
                        <a href="#" class="nav-link rm-group">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                            <p class="name-rm-layout text-nowrap">
                                РМ Преподавателя
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item rm-level-2">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                    <p>
                                        Расписание
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Архив</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Текущее расписание</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Добавить расписание</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Изменить расписание</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item rm-level-2">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-address-book" aria-hidden="true"></i>
                                    <p>
                                        Преподаватели
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Все преподаватели</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Расписание преподавателя</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Добавить преподавателя</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Уволенные преподаватели</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item rm-level-2">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                    <p>
                                        Студенты
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Группы</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Специальности</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Профессии</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Расписание групп</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item rm-level-2">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-table" aria-hidden="true"></i>
                                    <p>
                                        Отчеты
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Отчет по группам (Расширенный)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Отчет по преподавателям (Расширенный)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Отчет по предметам</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Статистика по предметам</p>
                                        </a>
                                    </li>
                                    <li class="nav-item rm-level-3">
                                        <a href="#" class="nav-link">
                                            <p>Статистика по преподавателям</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard v3</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v3</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- jQuery -->
        <script src="{{asset('assets/plugins/js/jquery.min.js')}}"></script>
        <!-- Main content -->
        <div class="content">
            <!-- alert -->
            <div class="base-alert">
                <div class="alert d-flex align-items-center" role="alert">
                    <div class="massage-save-alert">

                    </div>
                    <div class="btn-close-save-alert">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <script src="{{asset('assets/js/alert.js')}}"></script>

            @yield('content')
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="#">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<script src="{{asset('assets/js/base.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/plugins/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('assets/layouts/js/adminlte.js')}}"></script>

@yield('js_files')
</body>
</html>
