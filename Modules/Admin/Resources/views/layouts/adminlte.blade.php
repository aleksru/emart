@extends('adminlte::page')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@yield('content')

@section('css')
    <link href="{{asset('compiled/css/modules/admin/app.css')}}" rel="stylesheet">
@stop

@section('js')
    <script src="{{ asset('compiled/js/modules/admin/app.js') }}"></script>
@stop